<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Evaluasi Keperawatan</h1>
                <p class="text-slate-600">{{ $evaluation->patient->name }} - {{ $evaluation->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('evaluations.show', $evaluation) }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    Lihat
                </a>
                <a href="{{ route('evaluations.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('evaluations.update', $evaluation) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Patient Info (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pasien</label>
                    <div class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2">
                        {{ $evaluation->patient->name }} - {{ $evaluation->patient->medical_record_number }}
                    </div>
                </div>

                <!-- Nursing Diagnosis (Read Only) -->
                @if($evaluation->nursingDiagnosis)
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Diagnosis Terkait</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                        <span class="font-medium">{{ $evaluation->nursingDiagnosis->sdki_code ?? 'N/A' }}</span> - 
                        {{ $evaluation->nursingDiagnosis->diagnosis }}
                    </div>
                </div>
                @endif

                <!-- Evaluation Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Evaluasi *</label>
                        <input type="date" name="evaluation_date" 
                               value="{{ old('evaluation_date', $evaluation->evaluation_date->format('Y-m-d')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('evaluation_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu Evaluasi *</label>
                        <input type="time" name="evaluation_time" 
                               value="{{ old('evaluation_time', $evaluation->evaluation_time->format('H:i')) }}" 
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
                                  placeholder="Keluhan atau pernyataan pasien..." required>{{ old('subjective', $evaluation->subjective) }}</textarea>
                        <p class="mt-1 text-sm text-slate-500">Data yang disampaikan langsung oleh pasien</p>
                        @error('subjective')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Objective -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Objektif (O) *</label>
                        <textarea name="objective" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                  placeholder="Hasil observasi, pemeriksaan fisik, vital sign..." required>{{ old('objective', $evaluation->objective) }}</textarea>
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
                              placeholder="Analisis terhadap data subjektif dan objektif..." required>{{ old('analysis', $evaluation->analysis) }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Interpretasi dari data yang telah dikumpulkan</p>
                    @error('analysis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Planning -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Perencanaan (P) *</label>
                    <textarea name="planning" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rencana tindakan lanjutan..." required>{{ old('planning', $evaluation->planning) }}</textarea>
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
                        <option value="resolved" {{ old('outcome', $evaluation->outcome) == 'resolved' ? 'selected' : '' }}>Teratasi (Resolved)</option>
                        <option value="improved" {{ old('outcome', $evaluation->outcome) == 'improved' ? 'selected' : '' }}>Membaik (Improved)</option>
                        <option value="stable" {{ old('outcome', $evaluation->outcome) == 'stable' ? 'selected' : '' }}>Stabil (Stable)</option>
                        <option value="declined" {{ old('outcome', $evaluation->outcome) == 'declined' ? 'selected' : '' }}>Menurun (Declined)</option>
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
                        <option value="fully_achieved" {{ old('goal_achievement', $evaluation->goal_achievement) == 'fully_achieved' ? 'selected' : '' }}>Tercapai Sepenuhnya</option>
                        <option value="partially_achieved" {{ old('goal_achievement', $evaluation->goal_achievement) == 'partially_achieved' ? 'selected' : '' }}>Tercapai Sebagian</option>
                        <option value="not_achieved" {{ old('goal_achievement', $evaluation->goal_achievement) == 'not_achieved' ? 'selected' : '' }}>Tidak Tercapai</option>
                    </select>
                    @error('goal_achievement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Progress Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan Progress</label>
                    <textarea name="progress_notes" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Catatan perkembangan kondisi pasien...">{{ old('progress_notes', $evaluation->progress_notes) }}</textarea>
                    @error('progress_notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recommendations -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rekomendasi</label>
                    <textarea name="recommendations" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rekomendasi untuk asuhan selanjutnya...">{{ old('recommendations', $evaluation->recommendations) }}</textarea>
                    @error('recommendations')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Follow Up Plan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Rencana Tindak Lanjut</label>
                    <textarea name="follow_up_plan" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Rencana evaluasi dan tindakan selanjutnya...">{{ old('follow_up_plan', $evaluation->follow_up_plan) }}</textarea>
                    @error('follow_up_plan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evaluator -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Evaluator *</label>
                    <input type="text" name="evaluator_name" 
                           value="{{ old('evaluator_name', $evaluation->evaluator_name) }}" 
                           class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                           placeholder="Nama perawat/mahasiswa yang melakukan evaluasi" required>
                    @error('evaluator_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('evaluations.show', $evaluation) }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Update Evaluasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Evaluation History -->
        @if($evaluation->created_at != $evaluation->updated_at)
        <div class="mt-6 bg-yellow-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-yellow-900 mb-2">
                <ion-icon name="time-outline" class="mr-2"></ion-icon>
                Riwayat Perubahan
            </h3>
            <div class="text-sm text-yellow-800">
                <p><strong>Dibuat:</strong> {{ $evaluation->created_at->format('d F Y, H:i') }} oleh {{ $evaluation->user->name }}</p>
                <p><strong>Terakhir diupdate:</strong> {{ $evaluation->updated_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
        @endif

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
                    <h4 class="font-medium mb-2">Tips Dokumentasi:</h4>
                    <p><strong>Akurat:</strong> Catat data sesuai kenyataan</p>
                    <p><strong>Objektif:</strong> Hindari interpretasi subjektif</p>
                    <p><strong>Komprehensif:</strong> Sertakan semua data relevan</p>
                    <p><strong>Tepat Waktu:</strong> Dokumentasi segera</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
