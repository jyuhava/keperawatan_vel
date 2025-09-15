<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Intervensi Keperawatan</h1>
                <p class="text-slate-600">{{ $nursingIntervention->patient->name }} - {{ $nursingIntervention->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('nursing-interventions.show', $nursingIntervention) }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    Lihat
                </a>
                <a href="{{ route('nursing-interventions.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('nursing-interventions.update', $nursingIntervention) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Patient Info (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pasien</label>
                    <div class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2">
                        {{ $nursingIntervention->patient->name }} - {{ $nursingIntervention->patient->medical_record_number }}
                    </div>
                </div>

                <!-- Nursing Diagnosis (Read Only if exists) -->
                @if($nursingIntervention->nursingDiagnosis)
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Diagnosis Terkait</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                        <span class="font-medium">{{ $nursingIntervention->nursingDiagnosis->sdki_code ?? 'N/A' }}</span> - 
                        {{ $nursingIntervention->nursingDiagnosis->diagnosis }}
                    </div>
                </div>
                @endif

                <!-- SIKI Code -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kode SIKI</label>
                    <input type="text" name="siki_code" 
                           value="{{ old('siki_code', $nursingIntervention->siki_code) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Contoh: I.01001">
                    <p class="mt-1 text-sm text-slate-500">Masukkan kode intervensi sesuai Standar Intervensi Keperawatan Indonesia (SIKI)</p>
                    @error('siki_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Intervention Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Intervensi *</label>
                    <textarea name="intervention_name" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Nama intervensi berdasarkan SIKI..." required>{{ old('intervention_name', $nursingIntervention->intervention_name) }}</textarea>
                    @error('intervention_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Goals -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tujuan Intervensi *</label>
                    <textarea name="goals" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Tujuan yang ingin dicapai dari intervensi..." required>{{ old('goals', $nursingIntervention->goals) }}</textarea>
                    @error('goals')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tindakan Keperawatan *</label>
                    <textarea name="actions" rows="5" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rincian tindakan yang akan dilakukan..." required>{{ old('actions', $nursingIntervention->actions) }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Tuliskan langkah-langkah tindakan secara detail</p>
                    @error('actions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expected Outcomes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Luaran yang Diharapkan</label>
                    <textarea name="expected_outcomes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Hasil yang diharapkan setelah intervensi...">{{ old('expected_outcomes', $nursingIntervention->expected_outcomes) }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Sesuaikan dengan Standar Luaran Keperawatan Indonesia (SLKI)</p>
                    @error('expected_outcomes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Prioritas *</label>
                    <select name="priority" class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        <option value="">Pilih Prioritas</option>
                        <option value="tinggi" {{ old('priority', $nursingIntervention->priority) == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="sedang" {{ old('priority', $nursingIntervention->priority) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="rendah" {{ old('priority', $nursingIntervention->priority) == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frequency -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Frekuensi</label>
                    <input type="text" name="frequency" 
                           value="{{ old('frequency', $nursingIntervention->frequency) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Contoh: 3x sehari, setiap 4 jam, PRN">
                    <p class="mt-1 text-sm text-slate-500">Seberapa sering intervensi dilakukan</p>
                    @error('frequency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Durasi</label>
                    <input type="text" name="duration" 
                           value="{{ old('duration', $nursingIntervention->duration) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Contoh: 15 menit, 30 menit">
                    <p class="mt-1 text-sm text-slate-500">Durasi setiap kali tindakan</p>
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan khusus atau pertimbangan...">{{ old('notes', $nursingIntervention->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('nursing-interventions.show', $nursingIntervention) }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Update Intervensi
                    </button>
                </div>
            </form>
        </div>

        <!-- SIKI Reference Card -->
        <div class="mt-6 bg-green-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-green-900 mb-2">
                <ion-icon name="information-circle-outline" class="mr-2"></ion-icon>
                Referensi SIKI
            </h3>
            <div class="text-sm text-green-800 space-y-1">
                <p><strong>I.01001:</strong> Pemberian Posisi</p>
                <p><strong>I.01002:</strong> Dukungan Mobilisasi</p>
                <p><strong>I.01003:</strong> Pemberian Posisi: Neurologi</p>
                <p><strong>I.02001:</strong> Manajemen Jalan Nafas</p>
                <p class="mt-2 italic">Lihat buku SIKI untuk kode intervensi lengkap</p>
            </div>
        </div>
    </div>
</x-dashboard-layout>
