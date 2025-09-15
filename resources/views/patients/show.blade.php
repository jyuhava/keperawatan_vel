<x-dashboard-layout>
    <x-slot name="title">Detail Pasien - {{ $patient->name }}</x-slot>

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('patients.index') }}" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <ion-icon name="arrow-back" class="text-xl mr-2"></ion-icon>
                Kembali
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pasien</h2>
                <p class="text-gray-600">{{ $patient->medical_record_number }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @if(auth()->user()->role !== 'admin' && (auth()->user()->role === 'dosen' || $patient->user_id === auth()->id()))
            <a href="{{ route('patients.edit', $patient) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors">
                <ion-icon name="pencil" class="mr-2"></ion-icon>
                Edit
            </a>
            @endif
        </div>
    </div>
            
            <!-- Patient Header Card -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                <div class="h-20 w-20 rounded-full bg-white/20 backdrop-blur flex items-center justify-center border-2 border-white/30">
                                    <span class="text-2xl font-bold text-white">
                                        {{ strtoupper(substr($patient->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold">{{ $patient->name }}</h1>
                                <p class="text-blue-100 text-lg">No. RM: {{ $patient->medical_record_number }}</p>
                                <div class="flex items-center space-x-4 mt-2 text-sm">
                                    <span class="flex items-center">
                                        <ion-icon name="{{ $patient->gender === 'male' ? 'male' : 'female' }}" class="mr-1"></ion-icon>
                                        {{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                    <span class="flex items-center">
                                        <ion-icon name="calendar" class="mr-1"></ion-icon>
                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} tahun
                                    </span>
                                    <span class="flex items-center">
                                        <ion-icon name="location" class="mr-1"></ion-icon>
                                        {{ $patient->room_number ?? 'Belum ada kamar' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-500',
                                    'discharged' => 'bg-blue-500',
                                    'transferred' => 'bg-yellow-500'
                                ];
                                $statusLabels = [
                                    'active' => 'Aktif',
                                    'discharged' => 'Pulang',
                                    'transferred' => 'Pindah'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white {{ $statusColors[$patient->status] ?? 'bg-gray-500' }}">
                                {{ $statusLabels[$patient->status] ?? ucfirst($patient->status) }}
                            </span>
                            <div class="text-blue-100 text-sm mt-2">
                                Masuk: {{ \Carbon\Carbon::parse($patient->admission_date)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Personal Information -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                    <ion-icon name="person" class="text-2xl text-blue-600"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Informasi Pribadi</h3>
                                    <p class="text-gray-600">Data personal pasien</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                    <p class="text-lg text-gray-900">{{ $patient->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                                    <p class="text-lg text-gray-900 flex items-center">
                                        <ion-icon name="{{ $patient->gender === 'male' ? 'male' : 'female' }}" 
                                                  class="mr-2 {{ $patient->gender === 'male' ? 'text-blue-500' : 'text-pink-500' }}"></ion-icon>
                                        {{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                                    <p class="text-lg text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} tahun)</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                                    <p class="text-lg text-gray-900">{{ $patient->phone ?: '-' }}</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                    <p class="text-lg text-gray-900">{{ $patient->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="bg-green-100 p-3 rounded-xl mr-4">
                                    <ion-icon name="medical" class="text-2xl text-green-600"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Informasi Medis</h3>
                                    <p class="text-gray-600">Riwayat kesehatan dan kondisi medis</p>
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Keluhan Utama</label>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-900">{{ $patient->chief_complaint ?: 'Tidak ada keluhan utama yang tercatat' }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Riwayat Penyakit</label>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-900">{{ $patient->medical_history ?: 'Tidak ada riwayat penyakit yang tercatat' }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Alergi</label>
                                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                                        <p class="text-gray-900">{{ $patient->allergies ?: 'Tidak ada alergi yang diketahui' }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Obat yang Sedang Dikonsumsi</label>
                                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                        <p class="text-gray-900">{{ $patient->current_medications ?: 'Tidak ada obat yang sedang dikonsumsi' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nursing Care Documentation -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <div class="bg-purple-100 p-3 rounded-xl mr-4">
                                        <ion-icon name="clipboard" class="text-2xl text-purple-600"></ion-icon>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">Dokumentasi Asuhan Keperawatan</h3>
                                        <p class="text-gray-600">Riwayat proses keperawatan</p>
                                    </div>
                                </div>
                                @if(auth()->user()->role !== 'admin' && (auth()->user()->role === 'dosen' || $patient->user_id === auth()->id()))
                                <a href="{{ route('assessments.create', ['patient_id' => $patient->id]) }}" 
                                   class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors">
                                    <ion-icon name="add" class="mr-2"></ion-icon>
                                    Tambah Asesmen
                                </a>
                                @endif
                            </div>
                            
                            @if($patient->assessments->count() > 0)
                            <div class="space-y-4">
                                @foreach($patient->assessments as $assessment)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Asesmen Keperawatan</h4>
                                            <p class="text-gray-600 text-sm">{{ $assessment->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <a href="{{ route('assessments.show', $assessment) }}" 
                                           class="text-purple-600 hover:text-purple-800 font-medium">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <ion-icon name="clipboard-outline" class="text-4xl text-gray-300 mb-4"></ion-icon>
                                <p class="text-gray-500">Belum ada dokumentasi asuhan keperawatan</p>
                                @if(auth()->user()->role !== 'admin' && (auth()->user()->role === 'dosen' || $patient->user_id === auth()->id()))
                                <a href="{{ route('assessments.create', ['patient_id' => $patient->id]) }}" 
                                   class="inline-flex items-center mt-4 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                    <ion-icon name="add" class="mr-2"></ion-icon>
                                    Mulai Asesmen
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Contact Information -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-100 p-3 rounded-xl mr-4">
                                    <ion-icon name="call" class="text-2xl text-red-600"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Kontak Darurat</h3>
                                </div>
                            </div>
                            
                            @if($patient->emergency_contact_name || $patient->emergency_contact_phone)
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                                    <p class="text-gray-900">{{ $patient->emergency_contact_name ?: '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Telepon</label>
                                    <p class="text-gray-900">{{ $patient->emergency_contact_phone ?: '-' }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-gray-500 text-center py-4">Belum ada kontak darurat</p>
                            @endif
                        </div>
                    </div>

                    <!-- Admission Info -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                                    <ion-icon name="calendar" class="text-2xl text-blue-600"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Info Perawatan</h3>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Masuk</label>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($patient->admission_date)->format('d/m/Y') }}</p>
                                </div>
                                
                                @if($patient->discharge_date)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Keluar</label>
                                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($patient->discharge_date)->format('d/m/Y') }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Lama Perawatan</label>
                                    <p class="text-gray-900">
                                        {{ \Carbon\Carbon::parse($patient->admission_date)->diffForHumans(null, true) }}
                                    </p>
                                </div>
                                
                                @if($patient->room_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Kamar</label>
                                    <p class="text-gray-900">{{ $patient->room_number }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Nurse Information -->
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'dosen')
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-100 p-3 rounded-xl mr-4">
                                    <ion-icon name="person-circle" class="text-2xl text-green-600"></ion-icon>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Perawat</h3>
                                </div>
                            </div>
                            
                            @if($patient->user)
                            <div class="text-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->user->name) }}&background=random" 
                                     alt="{{ $patient->user->name }}" 
                                     class="w-16 h-16 rounded-full mx-auto mb-3">
                                <p class="font-medium text-gray-900">{{ $patient->user->name }}</p>
                                <p class="text-gray-500 text-sm">{{ $patient->user->email }}</p>
                                @if($patient->user->student_id)
                                <p class="text-gray-500 text-xs mt-1">ID: {{ $patient->user->student_id }}</p>
                                @endif
                            </div>
                            @else
                            <p class="text-gray-500 text-center">Tidak ada perawat yang ditugaskan</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
