<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Diagnosis Keperawatan</h1>
                <p class="text-slate-600">{{ $diagnosis->patient->name }} - {{ $diagnosis->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('nursing-diagnoses.show', $diagnosis) }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    Lihat
                </a>
                <a href="{{ route('nursing-diagnoses.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('nursing-diagnoses.update', $diagnosis) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Patient Info (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pasien</label>
                    <div class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2">
                        {{ $diagnosis->patient->name }} - {{ $diagnosis->patient->medical_record_number }}
                    </div>
                </div>

                <!-- SDKI Code -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode SDKI</label>
                    <input type="text" name="sdki_code" value="{{ old('sdki_code', $diagnosis->sdki_code) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Contoh: D.0001">
                    <p class="mt-1 text-sm text-slate-500">Masukkan kode diagnosis sesuai Standar Diagnosis Keperawatan Indonesia (SDKI)</p>
                    @error('sdki_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosis -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Diagnosis Keperawatan *</label>
                    <textarea name="diagnosis" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Tuliskan diagnosis keperawatan berdasarkan SDKI..." required>{{ old('diagnosis', $diagnosis->diagnosis) }}</textarea>
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Prioritas *</label>
                    <select name="priority" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Prioritas</option>
                        <option value="tinggi" {{ old('priority', $diagnosis->priority) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="sedang" {{ old('priority', $diagnosis->priority) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="rendah" {{ old('priority', $diagnosis->priority) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Related Factors -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Faktor yang Berhubungan</label>
                    <textarea name="related_factors" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Faktor etiologi atau penyebab diagnosis...">{{ old('related_factors', $diagnosis->related_factors) }}</textarea>
                    @error('related_factors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Defining Characteristics -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Karakteristik yang Menentukan</label>
                    <textarea name="defining_characteristics" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Tanda dan gejala yang mendukung diagnosis...">{{ old('defining_characteristics', $diagnosis->defining_characteristics) }}</textarea>
                    @error('defining_characteristics')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Factors -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Faktor Risiko <span class="text-sm text-slate-500">(jika diagnosis risiko)</span></label>
                    <textarea name="risk_factors" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Faktor yang meningkatkan kerentanan...">{{ old('risk_factors', $diagnosis->risk_factors) }}</textarea>
                    @error('risk_factors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan atau informasi tambahan...">{{ old('notes', $diagnosis->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('nursing-diagnoses.show', $diagnosis) }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Update Diagnosis
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
