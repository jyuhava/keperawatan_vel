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
            <nav class="mt-6 px-4" x-data="{ 
                activeDropdown: null,
                userRole: '{{ auth()->user()->role }}'
            }">
                <ul class="space-y-1">
                    
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="speedometer" class="text-xl {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Dashboard</span>
                        </a>
                    </li>

                    @if(auth()->user()->role !== 'admin')
                    <!-- Pasien Section -->
                    <li class="pt-4" x-show="sidebarOpen" x-transition>
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">
                            Data Pasien
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('patients.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('patients.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="people" class="text-xl {{ request()->routeIs('patients.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Data Pasien</span>
                        </a>
                    </li>

                    <!-- Dokumentasi Keperawatan Section -->
                    <li class="pt-4" x-show="sidebarOpen" x-transition>
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">
                            Proses Keperawatan
                        </div>
                    </li>
                    
                    <!-- Asesmen -->
                    <li>
                        <a href="{{ route('assessments.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('assessments.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="clipboard" class="text-xl {{ request()->routeIs('assessments.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Asesmen</span>
                        </a>
                    </li>

                    <!-- Diagnosa Keperawatan -->
                    <li>
                        <a href="{{ route('nursing-diagnoses.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('nursing-diagnoses.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="medical" class="text-xl {{ request()->routeIs('nursing-diagnoses.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Diagnosa</span>
                        </a>
                    </li>

                    <!-- Intervensi Keperawatan -->
                    <li>
                        <a href="{{ route('nursing-interventions.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('nursing-interventions.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="list" class="text-xl {{ request()->routeIs('nursing-interventions.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Intervensi</span>
                        </a>
                    </li>

                    <!-- Implementasi -->
                    <li>
                        <a href="{{ route('implementations.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('implementations.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="checkmark-done" class="text-xl {{ request()->routeIs('implementations.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Implementasi</span>
                        </a>
                    </li>

                    <!-- Evaluasi -->
                    <li>
                        <a href="{{ route('evaluations.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('evaluations.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="bar-chart" class="text-xl {{ request()->routeIs('evaluations.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Evaluasi</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role === 'admin')
                    <!-- Admin Section -->
                    <li class="pt-4" x-show="sidebarOpen" x-transition>
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">
                            Admin Panel
                        </div>
                    </li>
                    
                    <!-- User Management -->
                    <li>
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="people-circle" class="text-xl {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Kelola User</span>
                        </a>
                    </li>

                    <!-- Admin Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('admin.*') ? 'bg-purple-600 text-white' : '' }}">
                            <ion-icon name="analytics" class="text-xl {{ request()->routeIs('admin.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Admin Dashboard</span>
                        </a>
                    </li>

                    <!-- System Reports -->
                    <li>
                        <button @click="activeDropdown = activeDropdown === 'reports' ? null : 'reports'" 
                                class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-700 transition-colors group">
                            <div class="flex items-center">
                                <ion-icon name="document-text" class="text-xl text-slate-300 group-hover:text-white"></ion-icon>
                                <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Laporan</span>
                            </div>
                            <ion-icon x-show="sidebarOpen" name="chevron-down" 
                                      class="text-sm transition-transform"
                                      :class="activeDropdown === 'reports' ? 'rotate-180' : ''"></ion-icon>
                        </button>
                        <ul x-show="activeDropdown === 'reports' && sidebarOpen" 
                            x-transition:enter="transition-all duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="ml-6 mt-2 space-y-1 border-l-2 border-slate-600 pl-4">
                            <li>
                                <a href="#" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors">
                                    <ion-icon name="people-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Laporan User
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors">
                                    <ion-icon name="medical-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Laporan Pasien
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors">
                                    <ion-icon name="stats-chart-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Laporan Aktivitas
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if(auth()->user()->role === 'dosen')
                    <!-- Dosen Section -->
                    <li class="pt-4" x-show="sidebarOpen" x-transition>
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">
                            Supervisi
                        </div>
                    </li>
                    
                    <!-- Monitor Student Progress -->
                    <li>
                        <a href="{{ route('supervision.monitor') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('supervision.monitor') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="school" class="text-xl {{ request()->routeIs('supervision.monitor') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Monitor Mahasiswa</span>
                        </a>
                    </li>

                    <!-- Supervision Dashboard -->
                    <li>
                        <a href="{{ route('supervision.dashboard') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('supervision.dashboard', 'supervision.detail', 'supervision.student') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="clipboard" class="text-xl {{ request()->routeIs('supervision.dashboard', 'supervision.detail', 'supervision.student') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Dashboard Supervisi</span>
                        </a>
                    </li>

                    <!-- Teaching Materials -->
                    <li>
                        <button @click="activeDropdown = activeDropdown === 'teaching' ? null : 'teaching'" 
                                class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-700 transition-colors group">
                            <div class="flex items-center">
                                <ion-icon name="library" class="text-xl text-slate-300 group-hover:text-white"></ion-icon>
                                <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Materi Ajar</span>
                            </div>
                            <ion-icon x-show="sidebarOpen" name="chevron-down" 
                                      class="text-sm transition-transform"
                                      :class="activeDropdown === 'teaching' ? 'rotate-180' : ''"></ion-icon>
                        </button>
                        <ul x-show="activeDropdown === 'teaching' && sidebarOpen" 
                            x-transition:enter="transition-all duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="ml-6 mt-2 space-y-1 border-l-2 border-slate-600 pl-4">
                            <li>
                                <a href="{{ route('materials.sdki') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('materials.sdki') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="book-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Panduan SDKI
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('materials.slki') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('materials.slki') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="library-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Materi SLKI
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('materials.siki') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('materials.siki') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="clipboard-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Panduan SIKI
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    <!-- Profile & Settings Section -->
                    <li class="pt-4" x-show="sidebarOpen" x-transition>
                        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-2">
                            Pengaturan
                        </div>
                    </li>

                    <!-- Profile -->
                    <li>
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center p-3 rounded-lg hover:bg-slate-700 transition-colors group {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white' : '' }}">
                            <ion-icon name="person-circle" class="text-xl {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-300' }} group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Profile</span>
                        </a>
                    </li>

                    <!-- Help & Support -->
                    <li>
                        <button @click="activeDropdown = activeDropdown === 'help' ? null : 'help'" 
                                class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-700 transition-colors group">
                            <div class="flex items-center">
                                <ion-icon name="help-circle" class="text-xl text-slate-300 group-hover:text-white"></ion-icon>
                                <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Bantuan</span>
                            </div>
                            <ion-icon x-show="sidebarOpen" name="chevron-down" 
                                      class="text-sm transition-transform"
                                      :class="activeDropdown === 'help' ? 'rotate-180' : ''"></ion-icon>
                        </button>
                        <ul x-show="activeDropdown === 'help' && sidebarOpen" 
                            x-transition:enter="transition-all duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="ml-6 mt-2 space-y-1 border-l-2 border-slate-600 pl-4">
                            <li>
                                <a href="{{ route('help.user-guide') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('help.user-guide') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="document-text-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Panduan User
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('help.faq') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('help.faq') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="chatbubble-outline" class="text-slate-400 mr-2"></ion-icon>
                                    FAQ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('help.contact') }}" class="flex items-center p-2 rounded text-sm hover:bg-slate-700 transition-colors {{ request()->routeIs('help.contact') ? 'bg-blue-600 text-white' : '' }}">
                                    <ion-icon name="mail-outline" class="text-slate-400 mr-2"></ion-icon>
                                    Kontak Support
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Bottom Section -->
                <div class="mt-8 pt-4 border-t border-slate-700">
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center p-3 rounded-lg hover:bg-red-600 transition-colors text-left group">
                            <ion-icon name="log-out" class="text-xl text-slate-300 group-hover:text-white"></ion-icon>
                            <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Logout</span>
                        </button>
                    </form>
                </div>
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