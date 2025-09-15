<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Assessment</h1>
                <p class="text-slate-600">{{ $assessment->patient->name }} - {{ $assessment->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                @can('update', $assessment)
                    <a href="{{ route('assessments.edit', $assessment) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <ion-icon name="create-outline"></ion-icon>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('assessments.index') }}" 
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
                <!-- Patient Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Pasien</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-slate-600">Nama Pasien</span>
                            <p class="font-medium">{{ $assessment->patient->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-600">No. Medical Record</span>
                            <p class="font-medium">{{ $assessment->patient->medical_record_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-600">Usia</span>
                            <p class="font-medium">{{ $assessment->patient->age }} tahun</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-600">Jenis Kelamin</span>
                            <p class="font-medium">{{ $assessment->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chief Complaint -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Keluhan Utama</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->chief_complaint }}</p>
                </div>

                <!-- Medical History -->
                @if($assessment->medical_history)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Penyakit</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->medical_history }}</p>
                </div>
                @endif

                <!-- Physical Examination -->
                @if($assessment->physical_examination)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pemeriksaan Fisik</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->physical_examination }}</p>
                </div>
                @endif

                <!-- Psychological Assessment -->
                @if($assessment->psychological_assessment)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pengkajian Psikologis</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->psychological_assessment }}</p>
                </div>
                @endif

                <!-- Social Assessment -->
                @if($assessment->social_assessment)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pengkajian Sosial</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->social_assessment }}</p>
                </div>
                @endif

                <!-- Spiritual Assessment -->
                @if($assessment->spiritual_assessment)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pengkajian Spiritual</h2>
                    <p class="text-slate-700 whitespace-pre-line">{{ $assessment->spiritual_assessment }}</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Vital Signs -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Tanda-Tanda Vital</h2>
                    @if($assessment->vital_signs)
                        <div class="space-y-3">
                            @if(isset($assessment->vital_signs['blood_pressure']))
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tekanan Darah</span>
                                    <span class="font-medium">{{ $assessment->vital_signs['blood_pressure'] }} mmHg</span>
                                </div>
                            @endif
                            @if(isset($assessment->vital_signs['pulse']))
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Nadi</span>
                                    <span class="font-medium">{{ $assessment->vital_signs['pulse'] }} x/menit</span>
                                </div>
                            @endif
                            @if(isset($assessment->vital_signs['temperature']))
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Suhu</span>
                                    <span class="font-medium">{{ $assessment->vital_signs['temperature'] }}°C</span>
                                </div>
                            @endif
                            @if(isset($assessment->vital_signs['respiratory_rate']))
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Respirasi</span>
                                    <span class="font-medium">{{ $assessment->vital_signs['respiratory_rate'] }} x/menit</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-slate-500 text-sm">Tidak ada data tanda vital</p>
                    @endif
                </div>

                <!-- Assessment Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Assessment</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-slate-600">Mahasiswa</span>
                            <p class="font-medium">{{ $assessment->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-600">Tanggal Assessment</span>
                            <p class="font-medium">{{ $assessment->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div>
                            <span class="text-sm text-slate-600">Terakhir Diupdate</span>
                            <p class="font-medium">{{ $assessment->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Related Data -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Data Terkait</h2>
                    <div class="space-y-2">
                        <a href="{{ route('nursing-diagnoses.index', ['assessment_id' => $assessment->id]) }}" 
                           class="block p-2 text-blue-600 hover:bg-blue-50 rounded">
                            <ion-icon name="medical-outline" class="mr-2"></ion-icon>
                            Diagnosis Keperawatan
                        </a>
                        <a href="{{ route('nursing-interventions.index', ['assessment_id' => $assessment->id]) }}" 
                           class="block p-2 text-green-600 hover:bg-green-50 rounded">
                            <ion-icon name="clipboard-outline" class="mr-2"></ion-icon>
                            Intervensi Keperawatan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
