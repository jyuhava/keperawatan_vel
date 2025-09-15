<x-dashboard-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="mt-2 text-blue-100">
                        @if(auth()->user()->isMahasiswa())
                            Continue documenting your nursing care activities.
                        @elseif(auth()->user()->isDosen())
                            Review your students' nursing documentation.
                        @else
                            Manage the nursing care documentation system.
                        @endif
                    </p>
                </div>
                <div class="hidden md:block">
                    <ion-icon name="medical" class="text-6xl text-blue-200"></ion-icon>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Patients Card -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <ion-icon name="people" class="text-2xl text-blue-600"></ion-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['patients']['total'] }}</p>
                    <p class="text-xs text-green-600">{{ $stats['patients']['active'] }} aktif</p>
                </div>
            </div>
        </div>

        <!-- Assessments Card -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <ion-icon name="document-text" class="text-2xl text-purple-600"></ion-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Asesmen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['assessments']['total'] }}</p>
                    <p class="text-xs text-blue-600">{{ $stats['assessments']['this_month'] }} bulan ini</p>
                </div>
            </div>
        </div>

        <!-- Diagnoses Card -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="bg-red-100 p-3 rounded-full">
                    <ion-icon name="medical-outline" class="text-2xl text-red-600"></ion-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Diagnosis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['diagnoses']['total'] }}</p>
                    <p class="text-xs text-red-600">{{ $stats['diagnoses']['high_priority'] }} prioritas tinggi</p>
                </div>
            </div>
        </div>

        <!-- Implementations Card -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <ion-icon name="clipboard" class="text-2xl text-green-600"></ion-icon>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Implementasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['implementations']['total'] }}</p>
                    <p class="text-xs text-green-600">{{ $stats['implementations']['today'] }} hari ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <ion-icon name="time" class="mr-2 text-blue-600"></ion-icon>
                Aktivitas Terkini
            </h3>
            
            @if($recentActivities->count() > 0)
                <div class="space-y-4">
                    @foreach($recentActivities->take(5) as $activity)
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <ion-icon name="{{ $activity['icon'] }}" class="text-blue-600"></ion-icon>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada aktivitas terkini.</p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <ion-icon name="flash" class="mr-2 text-yellow-600"></ion-icon>
                Aksi Cepat
            </h3>
            
            <div class="space-y-3">
                @if(auth()->user()->isMahasiswa())
                    <a href="{{ route('patients.create') }}" 
                       class="w-full flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <ion-icon name="person-add" class="text-blue-600 mr-3"></ion-icon>
                        <span class="text-blue-700 font-medium">Tambah Pasien Baru</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
