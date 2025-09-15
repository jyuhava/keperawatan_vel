<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - Nursing Care Documentation</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Scripts for Enhanced Features -->
    <script>
        // Global SDKI suggestions data
        window.sdkiSuggestions = [
            {
                code: 'D.0001',
                title: 'Bersihan Jalan Nafas Tidak Efektif',
                definition: 'Ketidakmampuan membersihkan sekret atau obstruksi dari saluran pernafasan',
                factors: 'Spasme jalan nafas, hipersekresi jalan nafas, disfungsi neuromuskular',
                characteristics: 'Batuk tidak efektif, tidak mampu batuk, sputum berlebih, mengi'
            },
            {
                code: 'D.0002',
                title: 'Pola Nafas Tidak Efektif', 
                definition: 'Inspirasi dan/atau ekspirasi yang tidak memberikan ventilasi adekuat',
                factors: 'Depresi pusat pernafasan, hambatan upaya nafas, deformitas dinding dada',
                characteristics: 'Dispnea, nafas pendek, bradipnea, takipnea, pola nafas abnormal'
            },
            {
                code: 'D.0005',
                title: 'Risiko Aspirasi',
                definition: 'Berisiko mengalami aspirasi sekret gastrointestinal ke dalam tracheobronchial',
                factors: 'Penurunan tingkat kesadaran, disfagia, gangguan menelan',
                characteristics: 'Faktor risiko'
            },
            {
                code: 'D.0011',
                title: 'Defisit Perawatan Diri',
                definition: 'Ketidakmampuan melakukan atau menyelesaikan aktivitas perawatan diri',
                factors: 'Kelemahan, kelelahan, gangguan muskuloskeletal, gangguan neuromuskular',
                characteristics: 'Tidak mampu mandi secara mandiri, tidak mampu mengenakan pakaian'
            },
            {
                code: 'D.0017',
                title: 'Gangguan Mobilitas Fisik',
                definition: 'Keterbatasan dalam gerakan fisik tubuh atau ekstremitas',
                factors: 'Gangguan metabolisme, gangguan sirkulasi, kekakuan sendi, kontraktur',
                characteristics: 'Mengeluh sulit menggerakkan ekstremitas, enggan melakukan pergerakan'
            },
            {
                code: 'D.0021',
                title: 'Gangguan Pertukaran Gas',
                definition: 'Kelebihan atau kekurangan oksigenasi dan eliminasi karbondioksida',
                factors: 'Ketidakseimbangan rasio ventilasi-perfusi, perubahan membran alveolar-kapiler',
                characteristics: 'Dispnea, nafas cuping hidung, pola nafas abnormal, konfusi'
            },
            {
                code: 'D.0029',
                title: 'Risiko Jatuh',
                definition: 'Berisiko mengalami jatuh yang dapat menyebabkan bahaya fisik',
                factors: 'Usia > 65 tahun, riwayat jatuh, penggunaan alat bantu, gangguan keseimbangan',
                characteristics: 'Faktor risiko'
            },
            {
                code: 'D.0056',
                title: 'Nyeri Akut',
                definition: 'Pengalaman sensorik atau emosional berkaitan dengan kerusakan jaringan aktual',
                factors: 'Agen pencedera fisiologis, agen pencedera kimiawi, agen pencedera fisik',
                characteristics: 'Mengeluh nyeri, tampak meringis, bersikap protektif, gelisah'
            }
        ];
        
        // Helper function for validation
        function triggerValidation(field, value) {
            window.dispatchEvent(new CustomEvent('validation-field-changed', {
                detail: { field: field, value: value }
            }));
        }
    </script>

    <style>
        .sidebar-collapsed {
            width: 4rem;
        }
        .sidebar-expanded {
            width: 16rem;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen">
        <!-- Notification System -->
        <x-notification-system />
        
        <!-- Sidebar -->
        <div class="bg-slate-800 text-white transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed'">
            
            <!-- Logo -->
            <div class="p-4 border-b border-slate-700">
                <div class="flex items-center">
                    <div class="bg-blue-600 rounded-lg p-2">
                        <ion-icon name="medical" class="text-2xl"></ion-icon>
                    </div>
                    <div x-show="sidebarOpen" x-transition class="ml-3">
                        <h1 class="text-lg font-bold">NurseCare</h1>
                        <p class="text-xs text-slate-400">Documentation System</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="mt-8">
                <ul class="space-y-2 px-4">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="speedometer" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    <!-- Patients -->
                    <li>
                        <a href="{{ route('patients.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('patients.*') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="people" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Pasien</span>
                        </a>
                    </li>

                    <!-- Diagnosis & Interventions -->
                    <li>
                        <a href="{{ route('nursing-diagnoses.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('nursing-diagnoses.*', 'nursing-interventions.*') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="medical-outline" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Diagnosis & Intervensi</span>
                        </a>
                    </li>

                    <!-- Implementation & Evaluation -->
                    <li>
                        <a href="{{ route('implementations.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('implementations.*', 'evaluations.*') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="clipboard" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Implementasi & Evaluasi</span>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <!-- User Management (Admin only) -->
                    <li>
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('users.*') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="settings" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">User Management</span>
                        </a>
                    </li>
                    @endif

                    <!-- Profile -->
                    <li>
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('profile.*') ? 'bg-slate-700 border-r-4 border-blue-500' : '' }}">
                            <ion-icon name="person" class="text-xl"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Profile</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center p-3 rounded-lg hover:bg-red-600 transition-colors text-left">
                                <ion-icon name="log-out" class="text-xl"></ion-icon>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <!-- Sidebar Toggle -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <ion-icon name="menu" class="text-xl text-gray-600"></ion-icon>
                        </button>

                        <!-- Page Title -->
                        <h1 class="ml-4 text-xl font-semibold text-gray-800">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center space-x-4">
                        <!-- Role Badge -->
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                               {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-800' : 
                                  (auth()->user()->isDosen() ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>

                        <!-- User Avatar -->
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <ion-icon name="person" class="text-gray-600"></ion-icon>
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700">
                                {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            <div class="flex items-center">
                                <ion-icon name="checkmark-circle" class="mr-2"></ion-icon>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <div class="flex items-center">
                                <ion-icon name="alert-circle" class="mr-2"></ion-icon>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <div class="flex items-center mb-2">
                                <ion-icon name="alert-circle" class="mr-2"></ion-icon>
                                <strong>Please fix the following errors:</strong>
                            </div>
                            <ul class="ml-6 list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>
