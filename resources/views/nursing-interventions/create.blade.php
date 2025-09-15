<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Intervensi Keperawatan</h1>
                <p class="text-slate-600">Buat rencana intervensi berdasarkan standar SIKI</p>
            </div>
            <a href="{{ route('nursing-interventions.index') }}" 
               class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="arrow-back-outline"></ion-icon>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('nursing-interventions.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Patient Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Pasien *</label>
                    <select name="patient_id" id="patient_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Pasien</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} - {{ $patient->medical_record_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nursing Diagnosis Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Diagnosis Terkait</label>
                    <select name="nursing_diagnosis_id" id="diagnosis_id" class="w-full border border-slate-300 rounded-lg px-3 py-2">
                        <option value="">Pilih Diagnosis (Opsional)</option>
                        @foreach($diagnoses as $diagnosis)
                            <option value="{{ $diagnosis->id }}" {{ old('nursing_diagnosis_id', request('diagnosis_id')) == $diagnosis->id ? 'selected' : '' }}>
                                {{ $diagnosis->sdki_code ?? 'D.0001' }} - {{ Str::limit($diagnosis->diagnosis, 80) }}
                            </option>
                        @endforeach
                    </select>
                    @error('nursing_diagnosis_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SIKI Code -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode SIKI</label>
                    <input type="text" name="siki_code" value="{{ old('siki_code') }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Contoh: I.01001">
                    <p class="mt-1 text-sm text-slate-500">Masukkan kode intervensi sesuai Standar Intervensi Keperawatan Indonesia (SIKI)</p>
                    @error('siki_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Intervention -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Intervensi Keperawatan *</label>
                    <textarea name="intervention" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Tuliskan intervensi keperawatan berdasarkan SIKI..." required>{{ old('intervention') }}</textarea>
                    @error('intervention')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Goals -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tujuan/Luaran yang Diharapkan</label>
                    <textarea name="goals" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Jelaskan tujuan atau luaran yang ingin dicapai...">{{ old('goals') }}</textarea>
                    @error('goals')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tindakan/Aktivitas *</label>
                    <textarea name="actions" rows="5" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rincian tindakan atau aktivitas yang akan dilakukan..." required>{{ old('actions') }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Tuliskan langkah-langkah detail tindakan keperawatan</p>
                    @error('actions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rationale -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rasional</label>
                    <textarea name="rationale" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Alasan ilmiah atau dasar teori dari intervensi ini...">{{ old('rationale') }}</textarea>
                    @error('rationale')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frequency -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Frekuensi</label>
                        <input type="text" name="frequency" value="{{ old('frequency') }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                               placeholder="Contoh: 3x sehari, setiap 4 jam">
                        @error('frequency')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Durasi</label>
                        <input type="text" name="duration" value="{{ old('duration') }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                               placeholder="Contoh: 15 menit, selama rawat inap">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan atau informasi tambahan...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('nursing-interventions.index') }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Simpan Intervensi
                    </button>
                </div>
            </form>
        </div>

        <!-- SIKI Reference Card -->
        <div class="mt-6 bg-blue-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">
                <ion-icon name="information-circle-outline" class="mr-2"></ion-icon>
                Referensi SIKI
            </h3>
            <div class="text-sm text-blue-800 space-y-1">
                <p><strong>I.01001:</strong> Dukungan Ventilasi</p>
                <p><strong>I.02001:</strong> Manajemen Jalan Nafas</p>
                <p><strong>I.03001:</strong> Pemantauan Respirasi</p>
                <p><strong>I.04001:</strong> Manajemen Nyeri</p>
                <p class="mt-2 italic">Lihat buku SIKI untuk kode intervensi lengkap</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-load diagnoses when patient is selected
        document.getElementById('patient_id').addEventListener('change', function() {
            // This could be enhanced with AJAX to load patient-specific diagnoses
        });
    </script>
</x-dashboard-layout>
