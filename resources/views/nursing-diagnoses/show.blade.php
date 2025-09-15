<x-dashboard-layout>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Diagnosis Keperawatan</h1>
                <p class="text-slate-600">{{ $diagnosis->patient->name }} - {{ $diagnosis->patient->medical_record_number }}</p>
            </div>
            <div class="flex gap-2">
                @can('update', $diagnosis)
                    <a href="{{ route('nursing-diagnoses.edit', $diagnosis) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <ion-icon name="create-outline"></ion-icon>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('nursing-diagnoses.index') }}" 
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
                <!-- Diagnosis Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Diagnosis Keperawatan</h3>
                            @if($diagnosis->sdki_code)
                                <p class="text-sm text-blue-600 font-medium">SDKI: {{ $diagnosis->sdki_code }}</p>
                            @endif
                        </div>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $diagnosis->priority == 'tinggi' ? 'bg-red-100 text-red-800' : 
                               ($diagnosis->priority == 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            Prioritas {{ ucfirst($diagnosis->priority) }}
                        </span>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-slate-900 text-base leading-relaxed">{{ $diagnosis->diagnosis }}</p>
                    </div>
                </div>

                <!-- Related Factors -->
                @if($diagnosis->related_factors)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Faktor yang Berhubungan</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $diagnosis->related_factors }}</p>
                        </div>
                    </div>
                @endif

                <!-- Defining Characteristics -->
                @if($diagnosis->defining_characteristics)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Karakteristik yang Menentukan</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $diagnosis->defining_characteristics }}</p>
                        </div>
                    </div>
                @endif

                <!-- Risk Factors -->
                @if($diagnosis->risk_factors)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Faktor Risiko</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $diagnosis->risk_factors }}</p>
                        </div>
                    </div>
                @endif

                <!-- Notes -->
                @if($diagnosis->notes)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-3">Catatan Tambahan</h3>
                        <div class="prose max-w-none">
                            <p class="text-slate-700 leading-relaxed">{{ $diagnosis->notes }}</p>
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
                            <p class="text-slate-900">{{ $diagnosis->patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">No. Medical Record</p>
                            <p class="text-slate-900">{{ $diagnosis->patient->medical_record_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Jenis Kelamin</p>
                            <p class="text-slate-900">{{ $diagnosis->patient->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Umur</p>
                            <p class="text-slate-900">{{ \Carbon\Carbon::parse($diagnosis->patient->date_of_birth)->age }} tahun</p>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Metadata -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Diagnosis</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Dibuat oleh</p>
                            <p class="text-slate-900">{{ $diagnosis->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $diagnosis->user->role }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600">Tanggal Dibuat</p>
                            <p class="text-slate-900">{{ $diagnosis->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        @if($diagnosis->updated_at != $diagnosis->created_at)
                            <div>
                                <p class="text-sm font-medium text-slate-600">Terakhir Diperbarui</p>
                                <p class="text-slate-900">{{ $diagnosis->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('nursing-interventions.create', ['diagnosis_id' => $diagnosis->id]) }}" 
                           class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="medical-outline"></ion-icon>
                            Buat Intervensi
                        </a>
                        <a href="{{ route('assessments.show', $diagnosis->patient->assessments->first() ?? '#') }}" 
                           class="w-full bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            <ion-icon name="document-text-outline"></ion-icon>
                            Lihat Assessment
                        </a>
                    </div>
                </div>

                <!-- Related Interventions -->
                @if($diagnosis->nursingInterventions->count() > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Intervensi Terkait</h3>
                        <div class="space-y-2">
                            @foreach($diagnosis->nursingInterventions as $intervention)
                                <div class="border-l-4 border-blue-400 pl-3 py-1">
                                    <a href="{{ route('nursing-interventions.show', $intervention) }}" 
                                       class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        {{ $intervention->siki_code ?? 'I.0001' }} - {{ Str::limit($intervention->intervention, 50) }}
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
