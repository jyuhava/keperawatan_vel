<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Evaluasi Keperawatan</h1>
                <p class="text-slate-600">{{ $evaluation->patient->name }} - {{ $evaluation->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                @can('update', $evaluation)
                <a href="{{ route('evaluations.edit', $evaluation) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="create-outline"></ion-icon>
                    Edit
                </a>
                @endcan
                <a href="{{ route('evaluations.index') }}" 
                   class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Evaluation Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Informasi Evaluasi</h2>
                        <div class="flex gap-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($evaluation->outcome === 'resolved') bg-green-100 text-green-800
                                @elseif($evaluation->outcome === 'improved') bg-blue-100 text-blue-800
                                @elseif($evaluation->outcome === 'stable') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($evaluation->outcome === 'resolved') Teratasi
                                @elseif($evaluation->outcome === 'improved') Membaik
                                @elseif($evaluation->outcome === 'stable') Stabil
                                @else Menurun @endif
                            </span>
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                @if($evaluation->goal_achievement === 'fully_achieved') bg-emerald-100 text-emerald-800
                                @elseif($evaluation->goal_achievement === 'partially_achieved') bg-amber-100 text-amber-800
                                @else bg-rose-100 text-rose-800 @endif">
                                @if($evaluation->goal_achievement === 'fully_achieved') Tercapai Penuh
                                @elseif($evaluation->goal_achievement === 'partially_achieved') Tercapai Sebagian
                                @else Tidak Tercapai @endif
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Tanggal Evaluasi</label>
                            <p class="text-slate-900">{{ $evaluation->evaluation_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Waktu</label>
                            <p class="text-slate-900">{{ $evaluation->evaluation_time->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Evaluator</label>
                            <p class="text-slate-900">{{ $evaluation->evaluator_name }}</p>
                        </div>
                    </div>

                    <!-- Related Diagnosis -->
                    @if($evaluation->nursingDiagnosis)
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="font-medium text-blue-900 mb-2">Diagnosis Terkait</h3>
                        <div class="text-blue-800">
                            <p class="font-medium">{{ $evaluation->nursingDiagnosis->sdki_code }} - {{ $evaluation->nursingDiagnosis->diagnosis }}</p>
                            <p class="text-sm mt-1">Prioritas: {{ ucfirst($evaluation->nursingDiagnosis->priority) }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- SOAP Evaluation -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Evaluasi SOAP</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Subjective -->
                        <div>
                            <h3 class="text-md font-semibold text-slate-800 mb-2 flex items-center">
                                <span class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm mr-2">S</span>
                                Subjektif
                            </h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-blue-800 whitespace-pre-line">{{ $evaluation->subjective }}</p>
                            </div>
                        </div>

                        <!-- Objective -->
                        <div>
                            <h3 class="text-md font-semibold text-slate-800 mb-2 flex items-center">
                                <span class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-sm mr-2">O</span>
                                Objektif
                            </h3>
                            <div class="bg-green-50 rounded-lg p-4">
                                <p class="text-green-800 whitespace-pre-line">{{ $evaluation->objective }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-6">
                        <!-- Analysis -->
                        <div>
                            <h3 class="text-md font-semibold text-slate-800 mb-2 flex items-center">
                                <span class="w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm mr-2">A</span>
                                Analisis
                            </h3>
                            <div class="bg-purple-50 rounded-lg p-4">
                                <p class="text-purple-800 whitespace-pre-line">{{ $evaluation->analysis }}</p>
                            </div>
                        </div>

                        <!-- Planning -->
                        <div>
                            <h3 class="text-md font-semibold text-slate-800 mb-2 flex items-center">
                                <span class="w-6 h-6 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm mr-2">P</span>
                                Perencanaan
                            </h3>
                            <div class="bg-orange-50 rounded-lg p-4">
                                <p class="text-orange-800 whitespace-pre-line">{{ $evaluation->planning }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress & Recommendations -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Progress & Rekomendasi</h2>
                    
                    @if($evaluation->progress_notes)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Catatan Progress</h3>
                        <div class="bg-slate-50 rounded-lg p-4">
                            <p class="text-slate-700 whitespace-pre-line">{{ $evaluation->progress_notes }}</p>
                        </div>
                    </div>
                    @endif

                    @if($evaluation->recommendations)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Rekomendasi</h3>
                        <div class="bg-amber-50 rounded-lg p-4">
                            <p class="text-amber-800 whitespace-pre-line">{{ $evaluation->recommendations }}</p>
                        </div>
                    </div>
                    @endif

                    @if($evaluation->follow_up_plan)
                    <div>
                        <h3 class="text-md font-semibold text-slate-800 mb-2">Rencana Tindak Lanjut</h3>
                        <div class="bg-cyan-50 rounded-lg p-4">
                            <p class="text-cyan-800 whitespace-pre-line">{{ $evaluation->follow_up_plan }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Aksi</h2>
                    <div class="flex flex-wrap gap-3">
                        @can('update', $evaluation)
                        <a href="{{ route('evaluations.edit', $evaluation) }}" 
                           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="create-outline"></ion-icon>
                            Edit Evaluasi
                        </a>
                        @endcan
                        
                        <a href="{{ route('evaluations.create', ['patient_id' => $evaluation->patient->id]) }}" 
                           class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="add-outline"></ion-icon>
                            Evaluasi Baru
                        </a>

                        @if($evaluation->patient)
                        <a href="{{ route('patients.show', $evaluation->patient) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="person-outline"></ion-icon>
                            Lihat Pasien
                        </a>
                        @endif

                        @can('delete', $evaluation)
                        <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus evaluasi ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
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
                            <p class="text-slate-900">{{ $evaluation->patient->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">No. Rekam Medis</label>
                            <p class="text-slate-900">{{ $evaluation->patient->medical_record_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Tanggal Lahir</label>
                            <p class="text-slate-900">{{ $evaluation->patient->date_of_birth->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Jenis Kelamin</label>
                            <p class="text-slate-900">{{ $evaluation->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Evaluation Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Timeline Evaluasi</h3>
                    <div class="space-y-3">
                        @if($evaluation->patient->evaluations->count() > 1)
                            @foreach($evaluation->patient->evaluations->take(5) as $eval)
                            <div class="flex items-center space-x-3 {{ $eval->id === $evaluation->id ? 'bg-blue-50 -mx-2 px-2 py-1 rounded' : '' }}">
                                <div class="w-2 h-2 rounded-full {{ $eval->id === $evaluation->id ? 'bg-blue-500' : 'bg-slate-300' }}"></div>
                                <div class="flex-1">
                                    <p class="text-sm {{ $eval->id === $evaluation->id ? 'font-medium text-blue-900' : 'text-slate-700' }}">
                                        {{ $eval->evaluation_date->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-slate-500">{{ ucfirst($eval->outcome) }}</p>
                                </div>
                                @if($eval->id !== $evaluation->id)
                                <a href="{{ route('evaluations.show', $eval) }}" class="text-blue-600 hover:text-blue-800">
                                    <ion-icon name="arrow-forward-outline" class="text-sm"></ion-icon>
                                </a>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-slate-500">Ini adalah evaluasi pertama untuk pasien ini.</p>
                        @endif
                    </div>
                </div>

                <!-- Related Records -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Rekam Keperawatan Terkait</h3>
                    <div class="space-y-3">
                        @if($evaluation->patient->assessments->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Assessment Terbaru</label>
                            <a href="{{ route('assessments.show', $evaluation->patient->assessments->latest()->first()) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $evaluation->patient->assessments->latest()->first()->created_at->format('d/m/Y') }}
                            </a>
                        </div>
                        @endif

                        @if($evaluation->patient->nursingInterventions->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Intervensi Aktif</label>
                            <div class="space-y-1">
                                @foreach($evaluation->patient->nursingInterventions->take(3) as $intervention)
                                <a href="{{ route('nursing-interventions.show', $intervention) }}" 
                                   class="block text-blue-600 hover:text-blue-800 text-sm">
                                    {{ $intervention->siki_code }} - {{ Str::limit($intervention->intervention_name, 40) }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($evaluation->patient->implementations->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Implementasi Terbaru</label>
                            <a href="{{ route('implementations.show', $evaluation->patient->implementations->latest()->first()) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                {{ $evaluation->patient->implementations->latest()->first()->implementation_date->format('d/m/Y') }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="{{ route('evaluations.create', ['patient_id' => $evaluation->patient->id]) }}" 
                           class="w-full bg-purple-50 hover:bg-purple-100 text-purple-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="analytics-outline"></ion-icon>
                            Evaluasi Baru
                        </a>
                        <a href="{{ route('nursing-interventions.create', ['patient_id' => $evaluation->patient->id]) }}" 
                           class="w-full bg-green-50 hover:bg-green-100 text-green-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="add-outline"></ion-icon>
                            Intervensi Baru
                        </a>
                        <a href="{{ route('implementations.create', ['patient_id' => $evaluation->patient->id]) }}" 
                           class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <ion-icon name="play-outline"></ion-icon>
                            Implementasi Baru
                        </a>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Metadata</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Dibuat</span>
                            <span class="text-slate-900">{{ $evaluation->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Diupdate</span>
                            <span class="text-slate-900">{{ $evaluation->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Oleh</span>
                            <span class="text-slate-900">{{ $evaluation->user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
