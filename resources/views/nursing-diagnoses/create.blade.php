<x-dashboard-layout>
    <div class="p-6">
        <!-- Progress Stepper -->
        <x-nursing-process-stepper :current-step="2" />
        
        <!-- Student Guidance (only for students) -->
        @if(auth()->user()->isMahasiswa())
            <x-student-guidance :patient-id="request('patient_id')" />
            
            <!-- Collaboration Panel for real-time guidance -->
            <x-collaboration-panel :patient-id="request('patient_id')" />
            
            <!-- Adaptive Learning System -->
            <x-adaptive-learning 
                :patient-data="isset($selectedPatient) ? $selectedPatient : null" 
                current-field="diagnosis" />
        @endif
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Diagnosis Keperawatan</h1>
                <p class="text-slate-600">Buat diagnosis berdasarkan standar SDKI</p>
            </div>
            <a href="{{ route('nursing-diagnoses.index') }}" 
               class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <ion-icon name="arrow-back-outline"></ion-icon>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('nursing-diagnoses.store') }}" class="p-6 space-y-6">
                @csrf

                <!-- Patient Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Pasien *</label>
                    <select name="patient_id" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
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

                <!-- SDKI Code -->
                <x-diagnosis-suggestions field="sdki_code" :suggestions="[]">
                    <x-real-time-validator field="sdki_code">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Kode SDKI
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="sdki_code" 
                               value="{{ old('sdki_code') }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                               placeholder="Ketik untuk mencari... (contoh: D.0001)"
                               required
                               x-on:input="query = $event.target.value; filterSuggestions(); showSuggestions = query.length > 0; triggerValidation('sdki_code', $event.target.value)"
                               x-on:focus="showSuggestions = query.length > 0"
                               x-on:blur="setTimeout(() => showSuggestions = false, 200)">
                        
                        @if(auth()->user()->isMahasiswa())
                        <x-learning-hint type="tip" icon="lightbulb-outline">
                            <strong>Tips:</strong> Ketik beberapa huruf untuk mendapat saran diagnosis SDKI yang sesuai. 
                            Format kode: D.xxxx (contoh: D.0001)
                        </x-learning-hint>
                        @endif
                    </x-real-time-validator>
                </x-diagnosis-suggestions>
                
                @error('sdki_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Diagnosis -->
                <div>
                    <x-real-time-validator field="diagnosis">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Diagnosis Keperawatan 
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea name="diagnosis" 
                                  rows="4" 
                                  class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                  placeholder="Gunakan format PES: Problem + berhubungan dengan + ditandai dengan..." 
                                  required
                                  x-on:input="triggerValidation('diagnosis', $event.target.value)">{{ old('diagnosis') }}</textarea>
                                  
                        @if(auth()->user()->isMahasiswa())
                        <x-learning-hint type="tip" icon="document-text-outline">
                            <strong>Format PES Statement:</strong><br>
                            • <strong>P</strong>roblem: Diagnosis sesuai SDKI<br>
                            • <strong>E</strong>tiology: "berhubungan dengan [penyebab]"<br>
                            • <strong>S</strong>igns: "ditandai dengan [gejala]"
                        </x-learning-hint>
                        @endif
                    </x-real-time-validator>
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <x-real-time-validator field="priority">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Prioritas 
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="priority" 
                                class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                required
                                x-on:change="triggerValidation('priority', $event.target.value)">
                            <option value="">Pilih Prioritas</option>
                            <option value="tinggi" {{ old('priority') == 'tinggi' ? 'selected' : '' }}>🔴 Tinggi - Mengancam jiwa/keselamatan</option>
                            <option value="sedang" {{ old('priority') == 'sedang' ? 'selected' : '' }}>🟡 Sedang - Mempengaruhi recovery</option>
                            <option value="rendah" {{ old('priority') == 'rendah' ? 'selected' : '' }}>🟢 Rendah - Tidak langsung berbahaya</option>
                        </select>
                        
                        @if(auth()->user()->isMahasiswa())
                        <x-learning-hint type="tip" icon="flag-outline">
                            <strong>Panduan Prioritas:</strong><br>
                            • <strong>Tinggi:</strong> Masalah yang mengancam jiwa (ABCs: Airway, Breathing, Circulation)<br>
                            • <strong>Sedang:</strong> Masalah yang mempengaruhi pemulihan atau kenyamanan<br>
                            • <strong>Rendah:</strong> Masalah yang tidak langsung membahayakan pasien
                        </x-learning-hint>
                        @endif
                    </x-real-time-validator>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Related Factors -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Faktor yang Berhubungan</label>
                    <textarea name="related_factors" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Faktor etiologi atau penyebab diagnosis...">{{ old('related_factors') }}</textarea>
                    @error('related_factors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Defining Characteristics -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Karakteristik yang Menentukan</label>
                    <textarea name="defining_characteristics" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Tanda dan gejala yang mendukung diagnosis...">{{ old('defining_characteristics') }}</textarea>
                    @error('defining_characteristics')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Factors (for risk diagnoses) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Faktor Risiko <span class="text-sm text-slate-500">(jika diagnosis risiko)</span></label>
                    <textarea name="risk_factors" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Faktor yang meningkatkan kerentanan...">{{ old('risk_factors') }}</textarea>
                    @error('risk_factors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                    <a href="{{ route('nursing-diagnoses.index') }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Simpan Diagnosis
                    </button>
                </div>
            </form>
        </div>

        <!-- Enhanced SDKI Reference Card with Interactive Features -->
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200" x-data="{ expandedSection: null }">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-blue-900 flex items-center">
                    <ion-icon name="library-outline" class="mr-2 text-xl"></ion-icon>
                    Referensi & Bantuan SDKI
                </h3>
                <div class="flex gap-2">
                    <button @click="expandedSection = expandedSection === 'common' ? null : 'common'"
                            class="text-sm bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-lg transition-colors">
                        Diagnosis Umum
                    </button>
                    <button @click="expandedSection = expandedSection === 'emergency' ? null : 'emergency'"
                            class="text-sm bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-lg transition-colors">
                        Emergency
                    </button>
                </div>
            </div>
            
            <!-- Quick Reference -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <h4 class="font-semibold text-blue-800 mb-2">🫁 Pernapasan</h4>
                    <div class="space-y-1 text-blue-700">
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0001'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Bersihan Jalan Nafas Tidak Efektif'">
                            <span><strong>D.0001:</strong> Bersihan Jalan Nafas Tidak Efektif</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0002'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Pola Nafas Tidak Efektif'">
                            <span><strong>D.0002:</strong> Pola Nafas Tidak Efektif</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0021'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Gangguan Pertukaran Gas'">
                            <span><strong>D.0021:</strong> Gangguan Pertukaran Gas</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <h4 class="font-semibold text-blue-800 mb-2">🩺 Keselamatan</h4>
                    <div class="space-y-1 text-blue-700">
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0029'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Risiko Jatuh'; document.querySelector('select[name=\'priority\']').value = 'tinggi'">
                            <span><strong>D.0029:</strong> Risiko Jatuh</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0005'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Risiko Aspirasi'; document.querySelector('select[name=\'priority\']').value = 'tinggi'">
                            <span><strong>D.0005:</strong> Risiko Aspirasi</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                        <div class="flex justify-between items-center p-2 bg-white rounded hover:bg-blue-50 transition-colors cursor-pointer"
                             @click="document.querySelector('input[name=\'sdki_code\']').value = 'D.0056'; document.querySelector('textarea[name=\'diagnosis\']').value = 'Nyeri Akut'; document.querySelector('select[name=\'priority\']').value = 'sedang'">
                            <span><strong>D.0056:</strong> Nyeri Akut</span>
                            <ion-icon name="add-circle-outline" class="text-green-600"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Expanded Sections -->
            <div x-show="expandedSection === 'common'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="mt-4 p-4 bg-white rounded-lg">
                <h4 class="font-semibold text-gray-900 mb-3">Diagnosis Keperawatan Paling Umum</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    <div>
                        <strong>Fisiologis:</strong>
                        <ul class="mt-1 space-y-1 text-gray-700">
                            <li>• D.0011: Defisit Perawatan Diri</li>
                            <li>• D.0017: Gangguan Mobilitas Fisik</li>
                            <li>• D.0074: Gangguan Pola Tidur</li>
                            <li>• D.0056: Nyeri Akut/Kronis</li>
                        </ul>
                    </div>
                    <div>
                        <strong>Psikososial:</strong>
                        <ul class="mt-1 space-y-1 text-gray-700">
                            <li>• D.0080: Ansietas</li>
                            <li>• D.0054: Defisit Pengetahuan</li>
                            <li>• D.0083: Gangguan Citra Tubuh</li>
                            <li>• D.0078: Isolasi Sosial</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div x-show="expandedSection === 'emergency'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                <h4 class="font-semibold text-red-900 mb-3">⚠️ Diagnosis Prioritas Tinggi (Emergency)</h4>
                <div class="text-sm text-red-800 space-y-2">
                    <div class="flex items-start">
                        <span class="font-mono bg-red-100 px-2 py-1 rounded mr-3">ABC</span>
                        <div>
                            <strong>Airway, Breathing, Circulation:</strong><br>
                            D.0001 (Bersihan Jalan Nafas), D.0002 (Pola Nafas), D.0021 (Pertukaran Gas)
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="font-mono bg-red-100 px-2 py-1 rounded mr-3">RISK</span>
                        <div>
                            <strong>Risiko Keselamatan:</strong><br>
                            D.0029 (Risiko Jatuh), D.0005 (Risiko Aspirasi), D.0043 (Risiko Injury)
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-xs text-blue-600 italic flex items-center">
                <ion-icon name="information-circle-outline" class="mr-1"></ion-icon>
                Klik pada diagnosis untuk mengisi form otomatis. Lihat buku SDKI lengkap untuk detail karakteristik dan faktor risiko.
            </div>
        </div>
    </div>
</x-dashboard-layout>
