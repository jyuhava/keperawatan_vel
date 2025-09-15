<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Implementasi Keperawatan</h1>
                <p class="text-slate-600">Dokumentasi pelaksanaan tindakan keperawatan</p>
            </div>
            <a href="{{ route('implementations.index') }}" 
               class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="arrow-back-outline"></ion-icon>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('implementations.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Patient Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Pasien *</label>
                    <select name="patient_id" id="patient_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Pasien</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} - {{ $patient->medical_record_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nursing Intervention Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Intervensi *</label>
                    <select name="nursing_intervention_id" id="nursing_intervention_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih pasien terlebih dahulu</option>
                    </select>
                    @error('nursing_intervention_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Implementation Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Implementasi *</label>
                        <input type="date" name="implementation_date" 
                               value="{{ old('implementation_date', date('Y-m-d')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('implementation_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu Implementasi *</label>
                        <input type="time" name="implementation_time" 
                               value="{{ old('implementation_time', date('H:i')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('implementation_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions Performed -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tindakan yang Dilakukan *</label>
                    <textarea name="actions_performed" rows="5" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Deskripsikan tindakan yang telah dilakukan secara detail..." required>{{ old('actions_performed') }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Jelaskan langkah-langkah yang telah dilaksanakan</p>
                    @error('actions_performed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Patient Response -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Respon Pasien *</label>
                    <textarea name="patient_response" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Bagaimana respon pasien terhadap tindakan yang diberikan..." required>{{ old('patient_response') }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Catat respon verbal, non-verbal, dan perubahan kondisi pasien</p>
                    @error('patient_response')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Implementasi *</label>
                    <select name="status" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Status</option>
                        <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Dihentikan</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Durasi Pelaksanaan</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="number" name="duration_minutes" 
                                   value="{{ old('duration_minutes') }}" 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                   placeholder="0" min="0">
                            <p class="mt-1 text-xs text-slate-500">Menit</p>
                        </div>
                        <div>
                            <input type="number" name="duration_hours" 
                                   value="{{ old('duration_hours') }}" 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                   placeholder="0" min="0">
                            <p class="mt-1 text-xs text-slate-500">Jam</p>
                        </div>
                    </div>
                    @error('duration_minutes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Complications -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Komplikasi atau Masalah</label>
                    <textarea name="complications" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catat jika ada komplikasi atau masalah yang terjadi...">{{ old('complications') }}</textarea>
                    @error('complications')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nurse Signature -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perawat/Mahasiswa *</label>
                    <input type="text" name="nurse_signature" 
                           value="{{ old('nurse_signature', auth()->user()->name) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Nama lengkap yang melaksanakan" required>
                    @error('nurse_signature')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan tambahan atau observasi khusus...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('implementations.index') }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Simpan Implementasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Implementation Guide -->
        <div class="mt-6 bg-orange-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-orange-900 mb-2">
                <ion-icon name="information-circle-outline" class="mr-2"></ion-icon>
                Panduan Dokumentasi Implementasi
            </h3>
            <div class="text-sm text-orange-800 space-y-2">
                <p><strong>1. Tindakan:</strong> Jelaskan secara detail langkah-langkah yang dilakukan</p>
                <p><strong>2. Respon:</strong> Catat respon subjektif (yang disampaikan pasien) dan objektif (yang diamati)</p>
                <p><strong>3. Waktu:</strong> Dokumentasikan waktu mulai dan selesai tindakan</p>
                <p><strong>4. Hasil:</strong> Evaluasi apakah tindakan berhasil mencapai tujuan</p>
                <p><strong>5. Komplikasi:</strong> Catat jika ada efek samping atau masalah yang timbul</p>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic intervention loading -->
    <script>
        document.getElementById('patient_id').addEventListener('change', function() {
            const patientId = this.value;
            const interventionSelect = document.getElementById('nursing_intervention_id');
            
            if (patientId) {
                fetch(`/api/patients/${patientId}/nursing-interventions`)
                    .then(response => response.json())
                    .then(data => {
                        interventionSelect.innerHTML = '<option value="">Pilih Intervensi</option>';
                        data.forEach(intervention => {
                            const option = document.createElement('option');
                            option.value = intervention.id;
                            option.textContent = `${intervention.siki_code || ''} - ${intervention.intervention_name}`;
                            interventionSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading interventions:', error);
                        interventionSelect.innerHTML = '<option value="">Error loading interventions</option>';
                    });
            } else {
                interventionSelect.innerHTML = '<option value="">Pilih pasien terlebih dahulu</option>';
            }
        });
    </script>
</x-dashboard-layout>
