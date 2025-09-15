<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Evaluasi Keperawatan</h1>
                <p class="text-slate-600">Evaluasi efektivitas asuhan keperawatan berdasarkan SLKI</p>
            </div>
            <a href="{{ route('evaluations.index') }}" 
               class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="arrow-back-outline"></ion-icon>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('evaluations.store') }}" class="p-6 space-y-6">
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

                <!-- Nursing Diagnosis Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Diagnosis *</label>
                    <select name="nursing_diagnosis_id" id="nursing_diagnosis_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih pasien terlebih dahulu</option>
                    </select>
                    @error('nursing_diagnosis_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evaluation Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Evaluasi *</label>
                        <input type="date" name="evaluation_date" 
                               value="{{ old('evaluation_date', date('Y-m-d')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('evaluation_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu Evaluasi *</label>
                        <input type="time" name="evaluation_time" 
                               value="{{ old('evaluation_time', date('H:i')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('evaluation_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SOAP Evaluation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Subjective -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subjektif (S) *</label>
                        <textarea name="subjective" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                  placeholder="Keluhan atau pernyataan pasien..." required>{{ old('subjective') }}</textarea>
                        <p class="mt-1 text-sm text-slate-500">Data yang disampaikan langsung oleh pasien</p>
                        @error('subjective')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Objective -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Objektif (O) *</label>
                        <textarea name="objective" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                  placeholder="Hasil observasi, pemeriksaan fisik, vital sign..." required>{{ old('objective') }}</textarea>
                        <p class="mt-1 text-sm text-slate-500">Data yang dapat diamati dan diukur</p>
                        @error('objective')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Analysis -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Analisis (A) *</label>
                    <textarea name="analysis" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Analisis terhadap data subjektif dan objektif..." required>{{ old('analysis') }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Interpretasi dari data yang telah dikumpulkan</p>
                    @error('analysis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Planning -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Perencanaan (P) *</label>
                    <textarea name="planning" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rencana tindakan lanjutan..." required>{{ old('planning') }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Rencana asuhan keperawatan selanjutnya</p>
                    @error('planning')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Outcome -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Outcome/Hasil *</label>
                    <select name="outcome" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Outcome</option>
                        <option value="resolved" {{ old('outcome') == 'resolved' ? 'selected' : '' }}>Teratasi (Resolved)</option>
                        <option value="improved" {{ old('outcome') == 'improved' ? 'selected' : '' }}>Membaik (Improved)</option>
                        <option value="stable" {{ old('outcome') == 'stable' ? 'selected' : '' }}>Stabil (Stable)</option>
                        <option value="declined" {{ old('outcome') == 'declined' ? 'selected' : '' }}>Menurun (Declined)</option>
                    </select>
                    <p class="mt-1 text-sm text-slate-500">Sesuaikan dengan Standar Luaran Keperawatan Indonesia (SLKI)</p>
                    @error('outcome')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Goal Achievement -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pencapaian Tujuan *</label>
                    <select name="goal_achievement" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Pencapaian</option>
                        <option value="fully_achieved" {{ old('goal_achievement') == 'fully_achieved' ? 'selected' : '' }}>Tercapai Sepenuhnya</option>
                        <option value="partially_achieved" {{ old('goal_achievement') == 'partially_achieved' ? 'selected' : '' }}>Tercapai Sebagian</option>
                        <option value="not_achieved" {{ old('goal_achievement') == 'not_achieved' ? 'selected' : '' }}>Tidak Tercapai</option>
                    </select>
                    @error('goal_achievement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Progress Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Progress</label>
                    <textarea name="progress_notes" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan perkembangan kondisi pasien...">{{ old('progress_notes') }}</textarea>
                    @error('progress_notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recommendations -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rekomendasi</label>
                    <textarea name="recommendations" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rekomendasi untuk asuhan selanjutnya...">{{ old('recommendations') }}</textarea>
                    @error('recommendations')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Follow Up Plan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rencana Tindak Lanjut</label>
                    <textarea name="follow_up_plan" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rencana evaluasi dan tindakan selanjutnya...">{{ old('follow_up_plan') }}</textarea>
                    @error('follow_up_plan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evaluator -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Evaluator *</label>
                    <input type="text" name="evaluator_name" 
                           value="{{ old('evaluator_name', auth()->user()->name) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Nama perawat/mahasiswa yang melakukan evaluasi" required>
                    @error('evaluator_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('evaluations.index') }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Simpan Evaluasi
                    </button>
                </div>
            </form>
        </div>

        <!-- SOAP & SLKI Guide -->
        <div class="mt-6 bg-purple-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-purple-900 mb-2">
                <ion-icon name="information-circle-outline" class="mr-2"></ion-icon>
                Panduan Evaluasi SOAP & SLKI
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-purple-800">
                <div>
                    <h4 class="font-medium mb-2">Format SOAP:</h4>
                    <p><strong>S (Subjektif):</strong> "Pasien mengatakan..."</p>
                    <p><strong>O (Objektif):</strong> TD, Nadi, RR, Suhu, observasi</p>
                    <p><strong>A (Analisis):</strong> Masalah teratasi/belum</p>
                    <p><strong>P (Planning):</strong> Lanjutkan/modifikasi/hentikan</p>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Kriteria SLKI:</h4>
                    <p><strong>Level 1:</strong> Kondisi sangat terganggu</p>
                    <p><strong>Level 2:</strong> Kondisi cukup terganggu</p>
                    <p><strong>Level 3:</strong> Kondisi sedang</p>
                    <p><strong>Level 4:</strong> Kondisi cukup membaik</p>
                    <p><strong>Level 5:</strong> Kondisi tidak terganggu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic diagnosis loading -->
    <script>
        document.getElementById('patient_id').addEventListener('change', function() {
            const patientId = this.value;
            const diagnosisSelect = document.getElementById('nursing_diagnosis_id');
            
            if (patientId) {
                fetch(`/api/patients/${patientId}/nursing-diagnoses`)
                    .then(response => response.json())
                    .then(data => {
                        diagnosisSelect.innerHTML = '<option value="">Pilih Diagnosis</option>';
                        data.forEach(diagnosis => {
                            const option = document.createElement('option');
                            option.value = diagnosis.id;
                            option.textContent = `${diagnosis.sdki_code || ''} - ${diagnosis.diagnosis}`;
                            diagnosisSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading diagnoses:', error);
                        diagnosisSelect.innerHTML = '<option value="">Error loading diagnoses</option>';
                    });
            } else {
                diagnosisSelect.innerHTML = '<option value="">Pilih pasien terlebih dahulu</option>';
            }
        });
    </script>
</x-dashboard-layout>
