<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Assessment</h1>
                <p class="text-slate-600">{{ $assessment->patient->name }} - {{ $assessment->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('assessments.show', $assessment) }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    Lihat
                </a>
                <a href="{{ route('assessments.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('assessments.update', $assessment) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Patient Info (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pasien</label>
                    <div class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2">
                        {{ $assessment->patient->name }} - {{ $assessment->patient->medical_record_number }}
                    </div>
                </div>

                <!-- Chief Complaint -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keluhan Utama *</label>
                    <textarea name="chief_complaint" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Deskripsikan keluhan utama pasien..." required>{{ old('chief_complaint', $assessment->chief_complaint) }}</textarea>
                    @error('chief_complaint')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medical History -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Riwayat Penyakit</label>
                    <textarea name="medical_history" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Riwayat penyakit sekarang dan terdahulu...">{{ old('medical_history', $assessment->medical_history) }}</textarea>
                    @error('medical_history')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vital Signs -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanda-Tanda Vital</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Tekanan Darah (mmHg)</label>
                            <input type="text" name="vital_signs[blood_pressure]" 
                                   value="{{ old('vital_signs.blood_pressure', $assessment->vital_signs['blood_pressure'] ?? '') }}" 
                                   class="w-full border border-slate-300 rounded px-2 py-1 text-sm" 
                                   placeholder="120/80">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Nadi (x/menit)</label>
                            <input type="number" name="vital_signs[pulse]" 
                                   value="{{ old('vital_signs.pulse', $assessment->vital_signs['pulse'] ?? '') }}" 
                                   class="w-full border border-slate-300 rounded px-2 py-1 text-sm" 
                                   placeholder="80">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Suhu (°C)</label>
                            <input type="number" step="0.1" name="vital_signs[temperature]" 
                                   value="{{ old('vital_signs.temperature', $assessment->vital_signs['temperature'] ?? '') }}" 
                                   class="w-full border border-slate-300 rounded px-2 py-1 text-sm" 
                                   placeholder="36.5">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">RR (x/menit)</label>
                            <input type="number" name="vital_signs[respiratory_rate]" 
                                   value="{{ old('vital_signs.respiratory_rate', $assessment->vital_signs['respiratory_rate'] ?? '') }}" 
                                   class="w-full border border-slate-300 rounded px-2 py-1 text-sm" 
                                   placeholder="20">
                        </div>
                    </div>
                    @error('vital_signs')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Physical Examination -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pemeriksaan Fisik</label>
                    <textarea name="physical_examination" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Hasil pemeriksaan fisik head to toe...">{{ old('physical_examination', $assessment->physical_examination) }}</textarea>
                    @error('physical_examination')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Psychological Assessment -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pengkajian Psikologis</label>
                    <textarea name="psychological_assessment" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Kondisi psikologis, mood, kecemasan, dll...">{{ old('psychological_assessment', $assessment->psychological_assessment) }}</textarea>
                    @error('psychological_assessment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Social Assessment -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pengkajian Sosial</label>
                    <textarea name="social_assessment" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Dukungan keluarga, kondisi sosial ekonomi, dll...">{{ old('social_assessment', $assessment->social_assessment) }}</textarea>
                    @error('social_assessment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Spiritual Assessment -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pengkajian Spiritual</label>
                    <textarea name="spiritual_assessment" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Kebutuhan spiritual, praktik keagamaan, dll...">{{ old('spiritual_assessment', $assessment->spiritual_assessment) }}</textarea>
                    @error('spiritual_assessment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('assessments.show', $assessment) }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Update Assessment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
