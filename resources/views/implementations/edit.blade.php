<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Implementasi Keperawatan</h1>
                <p class="text-slate-600">{{ $implementation->patient->name }} - {{ $implementation->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('implementations.show', $implementation) }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    Lihat
                </a>
                <a href="{{ route('implementations.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('implementations.update', $implementation) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <!-- Patient Info (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pasien</label>
                    <div class="bg-slate-50 border border-slate-300 rounded-lg px-3 py-2">
                        {{ $implementation->patient->name }} - {{ $implementation->patient->medical_record_number }}
                    </div>
                </div>

                <!-- Nursing Intervention (Read Only) -->
                @if($implementation->nursingIntervention)
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Intervensi Terkait</label>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                        <span class="font-medium">{{ $implementation->nursingIntervention->siki_code ?? 'N/A' }}</span> - 
                        {{ $implementation->nursingIntervention->intervention_name }}
                    </div>
                </div>
                @endif

                <!-- Implementation Date & Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Implementasi *</label>
                        <input type="date" name="implementation_date" 
                               value="{{ old('implementation_date', $implementation->implementation_date->format('Y-m-d')) }}" 
                               class="w-full border border-slate-300 rounded-lg px-3 py-2" required>
                        @error('implementation_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Waktu Implementasi *</label>
                        <input type="time" name="implementation_time" 
                               value="{{ old('implementation_time', $implementation->implementation_time->format('H:i')) }}" 
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
                              placeholder="Deskripsikan tindakan yang telah dilakukan secara detail..." required>{{ old('actions_performed', $implementation->actions_performed) }}</textarea>
                    <p class="mt-1 text-sm text-slate-500">Jelaskan langkah-langkah yang telah dilaksanakan</p>
                    @error('actions_performed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Patient Response -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Respon Pasien *</label>
                    <textarea name="patient_response" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                              placeholder="Bagaimana respon pasien terhadap tindakan yang diberikan..." required>{{ old('patient_response', $implementation->patient_response) }}</textarea>
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
                        <option value="planned" {{ old('status', $implementation->status) == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="in_progress" {{ old('status', $implementation->status) == 'in_progress' ? 'selected' : '' }}>Sedang Berlangsung</option>
                        <option value="completed" {{ old('status', $implementation->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="discontinued" {{ old('status', $implementation->status) == 'discontinued' ? 'selected' : '' }}>Dihentikan</option>
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
                                   value="{{ old('duration_minutes', $implementation->duration_minutes) }}" 
                                   class="w-full border border-slate-300 rounded-lg px-3 py-2" 
                                   placeholder="0" min="0">
                            <p class="mt-1 text-xs text-slate-500">Menit</p>
                        </div>
                        <div>
                            <input type="number" name="duration_hours" 
                                   value="{{ old('duration_hours', $implementation->duration_hours) }}" 
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
                              placeholder="Catat jika ada komplikasi atau masalah yang terjadi...">{{ old('complications', $implementation->complications) }}</textarea>
                    @error('complications')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nurse Signature -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perawat/Mahasiswa *</label>
                    <input type="text" name="nurse_signature" 
                           value="{{ old('nurse_signature', $implementation->nurse_signature) }}" 
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
                              placeholder="Catatan tambahan atau observasi khusus...">{{ old('notes', $implementation->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('implementations.show', $implementation) }}" 
                       class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Update Implementasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Implementation History -->
        @if($implementation->created_at != $implementation->updated_at)
        <div class="mt-6 bg-yellow-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-yellow-900 mb-2">
                <ion-icon name="time-outline" class="mr-2"></ion-icon>
                Riwayat Perubahan
            </h3>
            <div class="text-sm text-yellow-800">
                <p><strong>Dibuat:</strong> {{ $implementation->created_at->format('d F Y, H:i') }} oleh {{ $implementation->user->name }}</p>
                <p><strong>Terakhir diupdate:</strong> {{ $implementation->updated_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
        @endif

        <!-- Implementation Guide -->
        <div class="mt-6 bg-orange-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-orange-900 mb-2">
                <ion-icon name="information-circle-outline" class="mr-2"></ion-icon>
                Tips Dokumentasi Implementasi
            </h3>
            <div class="text-sm text-orange-800 space-y-2">
                <p><strong>Objektif:</strong> Gunakan bahasa yang objektif dan menghindari interpretasi subjektif</p>
                <p><strong>Spesifik:</strong> Catat waktu, dosis, metode, dan durasi secara detail</p>
                <p><strong>Akurat:</strong> Dokumentasikan segera setelah tindakan dilakukan</p>
                <p><strong>Lengkap:</strong> Sertakan respon pasien baik verbal maupun non-verbal</p>
                <p><strong>Profesional:</strong> Gunakan terminologi medis yang tepat</p>
            </div>
        </div>
    </div>
</x-dashboard-layout>
