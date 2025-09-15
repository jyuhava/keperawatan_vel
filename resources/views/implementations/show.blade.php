<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Implementasi Keperawatan</h1>
                <p class="text-slate-600">{{ $implementation->patient->name }} - {{ $implementation->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                @can('update', $implementation)
                <a href="{{ route('implementations.edit', $implementation) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="create-outline"></ion-icon>
                    Edit
                </a>
                @endcan
                <a href="{{ route('implementations.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Implementation Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Informasi Implementasi</h2>
                        <span class="px-3 py-1 text-sm font-medium rounded-full 
                            @if($implementation->status === 'completed') bg-green-100 text-green-800
                            @elseif($implementation->status === 'in_progress') bg-yellow-100 text-yellow-800
                            @elseif($implementation->status === 'planned') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($implementation->status === 'completed') Selesai
                            @elseif($implementation->status === 'in_progress') Sedang Berlangsung
                            @elseif($implementation->status === 'planned') Direncanakan
                            @else Dihentikan @endif
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Tanggal</label>
                            <p class="text-slate-900">{{ $implementation->implementation_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Waktu</label>
                            <p class="text-slate-900">{{ $implementation->implementation_time->format('H:i') }} WIB</p>
                        </div>
                        @if($implementation->duration_hours || $implementation->duration_minutes)
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Durasi</label>
                            <p class="text-slate-900">
                                @if($implementation->duration_hours){{ $implementation->duration_hours }} jam @endif
                                @if($implementation->duration_minutes){{ $implementation->duration_minutes }} menit @endif
                            </p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Perawat/Mahasiswa</label>
                            <p class="text-slate-900">{{ $implementation->nurse_signature }}</p>
                        </div>
                    </div>

                    <!-- Related Intervention -->
                    @if($implementation->nursingIntervention)
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="font-medium text-blue-900 mb-2">Intervensi Terkait</h3>
                        <div class="text-blue-800">
                            <p class="font-medium">{{ $implementation->nursingIntervention->siki_code }} - {{ $implementation->nursingIntervention->intervention_name }}</p>
                            <p class="text-sm mt-1">{{ $implementation->nursingIntervention->goals }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Actions Performed -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Tindakan yang Dilakukan</h3>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="text-slate-700 whitespace-pre-line">{{ $implementation->actions_performed }}</p>
                        </div>
                    </div>

                    <!-- Patient Response -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Respon Pasien</h3>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-green-800 whitespace-pre-line">{{ $implementation->patient_response }}</p>
                        </div>
                    </div>

                    <!-- Complications -->
                    @if($implementation->complications)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Komplikasi atau Masalah</h3>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-red-800 whitespace-pre-line">{{ $implementation->complications }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Additional Notes -->
                    @if($implementation->notes)
                    <div>
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Catatan Tambahan</h3>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="text-slate-700 whitespace-pre-line">{{ $implementation->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Aksi</h2>
                    <div class="flex flex-wrap gap-3">
                        @can('update', $implementation)
                        <a href="{{ route('implementations.edit', $implementation) }}" 
                           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="create-outline"></ion-icon>
                            Edit Implementasi
                        </a>
                        @endcan
                        
                        <a href="{{ route('evaluations.create', ['implementation_id' => $implementation->id]) }}" 
                           class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="analytics-outline"></ion-icon>
                            Buat Evaluasi
                        </a>

                        @if($implementation->patient)
                        <a href="{{ route('patients.show', $implementation->patient) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="person-outline"></ion-icon>
                            Lihat Pasien
                        </a>
                        @endif

                        @can('delete', $implementation)
                        <form method="POST" action="{{ route('implementations.destroy', $implementation) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus implementasi ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                <ion-icon name="trash-outline"></ion-icon>
                                Hapus
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Pasien</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Nama</label>
                            <p class="text-slate-900">{{ $implementation->patient->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">No. Rekam Medis</label>
                            <p class="text-slate-900">{{ $implementation->patient->medical_record_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Tanggal Lahir</label>
                            <p class="text-slate-900">{{ $implementation->patient->date_of_birth->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Jenis Kelamin</label>
                            <p class="text-slate-900">{{ $implementation->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Related Records -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Rekam Keperawatan Terkait</h3>
                    <div class="space-y-3">
                        @if($implementation->patient->assessments->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Assessment Terbaru</label>
                            <a href="{{ route('assessments.show', $implementation->patient->assessments->latest()->first()) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $implementation->patient->assessments->latest()->first()->created_at->format('d/m/Y') }}
                            </a>
                        </div>
                        @endif

                        @if($implementation->patient->nursingDiagnoses->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Diagnosis Aktif</label>
                            <div class="space-y-1">
                                @foreach($implementation->patient->nursingDiagnoses->take(3) as $diagnosis)
                                <a href="{{ route('nursing-diagnoses.show', $diagnosis) }}" 
                                   class="block text-blue-600 hover:text-blue-800 text-sm">
                                    {{ $diagnosis->sdki_code }} - {{ Str::limit($diagnosis->diagnosis, 40) }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($implementation->patient->evaluations->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Evaluasi Terbaru</label>
                            <a href="{{ route('evaluations.show', $implementation->patient->evaluations->latest()->first()) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $implementation->patient->evaluations->latest()->first()->created_at->format('d/m/Y') }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('implementations.create', ['patient_id' => $implementation->patient->id]) }}" 
                           class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="add-outline"></ion-icon>
                            Implementasi Baru
                        </a>
                        <a href="{{ route('nursing-interventions.index', ['patient' => $implementation->patient->id]) }}" 
                           class="w-full bg-green-50 hover:bg-green-100 text-green-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="list-outline"></ion-icon>
                            Lihat Intervensi
                        </a>
                        <a href="{{ route('evaluations.create', ['patient_id' => $implementation->patient->id]) }}" 
                           class="w-full bg-purple-50 hover:bg-purple-100 text-purple-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="analytics-outline"></ion-icon>
                            Buat Evaluasi
                        </a>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Metadata</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Dibuat</span>
                            <span class="text-slate-900">{{ $implementation->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Diupdate</span>
                            <span class="text-slate-900">{{ $implementation->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Oleh</span>
                            <span class="text-slate-900">{{ $implementation->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
