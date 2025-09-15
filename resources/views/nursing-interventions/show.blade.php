<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Intervensi Keperawatan</h1>
                <p class="text-slate-600">{{ $intervention->patient->name }} - {{ $intervention->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                @can('update', $intervention)
                    <a href="{{ route('nursing-interventions.edit', $intervention) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <ion-icon name="create-outline"></ion-icon>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('nursing-interventions.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Intervention Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Intervensi Keperawatan</h3>
                            @if($intervention->siki_code)
                                <p class="text-sm text-blue-600 font-medium">SIKI: {{ $intervention->siki_code }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-slate-900 text-base leading-relaxed">{{ $intervention->intervention }}</p>
                    </div>
                </div>

                <!-- Goals/Outcomes -->
                @if($intervention->goals)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Tujuan/Luaran yang Diharapkan</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $intervention->goals }}</p>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                @if($intervention->actions)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Tindakan/Aktivitas</h3>
                        <div class="prose max-w-none">
                            <div class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $intervention->actions }}</div>
                        </div>
                    </div>
                @endif

                <!-- Rationale -->
                @if($intervention->rationale)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Rasional</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $intervention->rationale }}</p>
                        </div>
                    </div>
                @endif

                <!-- Frequency & Duration -->
                @if($intervention->frequency || $intervention->duration)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Jadwal Pelaksanaan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($intervention->frequency)
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Frekuensi</p>
                                    <p class="text-slate-900">{{ $intervention->frequency }}</p>
                                </div>
                            @endif
                            @if($intervention->duration)
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Durasi</p>
                                    <p class="text-slate-900">{{ $intervention->duration }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($intervention->notes)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Catatan Tambahan</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $intervention->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Pasien</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Nama Pasien</p>
                            <p class="text-slate-900">{{ $intervention->patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">No. Medical Record</p>
                            <p class="text-slate-900">{{ $intervention->patient->medical_record_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Jenis Kelamin</p>
                            <p class="text-slate-900">{{ $intervention->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Umur</p>
                            <p class="text-slate-900">{{ \Carbon\Carbon::parse($intervention->patient->date_of_birth)->age }} tahun</p>
                        </div>
                    </div>
                </div>

                <!-- Related Diagnosis -->
                @if($intervention->nursingDiagnosis)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Diagnosis Terkait</h3>
                        <div class="border-l-4 border-blue-400 pl-3">
                            <p class="font-medium text-blue-600">{{ $intervention->nursingDiagnosis->sdki_code ?? 'D.0001' }}</p>
                            <p class="text-sm text-slate-700">{{ $intervention->nursingDiagnosis->diagnosis }}</p>
                            <a href="{{ route('nursing-diagnoses.show', $intervention->nursingDiagnosis) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800">Lihat detail →</a>
                        </div>
                    </div>
                @endif

                <!-- Intervention Metadata -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Intervensi</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Dibuat oleh</p>
                            <p class="text-slate-900">{{ $intervention->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $intervention->user->role }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Tanggal Dibuat</p>
                            <p class="text-slate-900">{{ $intervention->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if($intervention->updated_at != $intervention->created_at)
                            <div>
                                <p class="text-sm font-medium text-slate-600">Terakhir Diperbarui</p>
                                <p class="text-slate-900">{{ $intervention->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('implementations.create', ['intervention_id' => $intervention->id]) }}" 
                           class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                            Buat Implementasi
                        </a>
                        @if($intervention->nursingDiagnosis)
                            <a href="{{ route('nursing-diagnoses.show', $intervention->nursingDiagnosis) }}" 
                               class="w-full bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                <ion-icon name="medical-outline"></ion-icon>
                                Lihat Diagnosis
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Related Implementations -->
                @if($intervention->implementations->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Implementasi Terkait</h3>
                        <div class="space-y-2">
                            @foreach($intervention->implementations as $implementation)
                                <div class="border-l-4 border-green-400 pl-3 py-1">
                                    <a href="{{ route('implementations.show', $implementation) }}" 
                                       class="text-sm font-medium text-green-600 hover:text-green-800">
                                        {{ $implementation->created_at->format('d/m/Y H:i') }} - {{ Str::limit($implementation->activity, 50) }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
