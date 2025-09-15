@props(['currentRoute' => ''])

<div class="h-full bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl transition-all duration-300 ease-in-out"
     :class="sidebarOpen ? 'w-72' : 'w-20'"
     x-data="{ 
        hoveredItem: null,
        expandedMenu: null,
        notifications: 5,
        onlineUsers: 24
     }">
    
    <!-- Header Section -->
    <div class="relative p-6 border-b border-slate-700/50">
        <!-- Toggle Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="absolute -right-3 top-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow-lg transition-all duration-200 transform hover:scale-110 z-10">
            <ion-icon :name="sidebarOpen ? 'chevron-back' : 'chevron-forward'" class="text-sm"></ion-icon>
        </button>
        
        <!-- Logo & Title -->
        <div class="flex items-center" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl p-3 shadow-lg">
                    <ion-icon name="shield-checkmark" class="text-2xl"></ion-icon>
                </div>
                <!-- Status Indicator -->
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 border-2 border-slate-900 rounded-full animate-pulse"></div>
            </div>
            
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 delay-150"
                 x-transition:enter-start="opacity-0 transform -translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="ml-4">
                <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                    NurseCare Pro
                </h1>
                <p class="text-xs text-slate-400 font-medium">Admin Dashboard</p>
            </div>
        </div>
        
        <!-- Admin Info -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300 delay-200"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="mt-4 bg-slate-800/50 rounded-lg p-3 border border-slate-700/30">
            <div class="flex items-center">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=3b82f6&color=fff&size=40" 
                         alt="Admin Avatar" class="w-10 h-10 rounded-lg">
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-slate-800 rounded-full"></div>
                </div>
                <div class="ml-3 flex-1">
                    <div class="text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                    <div class="text-xs text-slate-400 flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                        Online
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-6 px-4 flex-1 overflow-y-auto">
        <div class="space-y-2">
            
            <!-- Dashboard Section -->
            <div class="mb-6">
                <div x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-3">
                    Overview
                </div>
                
                <!-- Main Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   @mouseenter="hoveredItem = 'dashboard'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600/50' }} transition-colors">
                        <ion-icon name="grid" class="text-lg"></ion-icon>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Dashboard</span>
                    
                    <!-- Tooltip for collapsed state -->
                    <div x-show="!sidebarOpen && hoveredItem === 'dashboard'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Dashboard
                    </div>
                </a>
                
                <!-- Analytics -->
                <a href="#" 
                   @mouseenter="hoveredItem = 'analytics'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-300 hover:bg-slate-800/50 hover:text-white">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600/50 transition-colors">
                        <ion-icon name="analytics" class="text-lg"></ion-icon>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Analytics</span>
                    <div x-show="sidebarOpen" class="ml-auto">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">New</span>
                    </div>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'analytics'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Analytics
                    </div>
                </a>
            </div>

            <!-- Management Section -->
            <div class="mb-6">
                <div x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-3">
                    Management
                </div>
                
                <!-- User Management -->
                <div x-data="{ expanded: false }" class="relative">
                    <button @click="expanded = !expanded; expandedMenu = expanded ? 'users' : null" 
                            @mouseenter="hoveredItem = 'users'" 
                            @mouseleave="hoveredItem = null"
                            class="group w-full flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('users.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600/50' }} transition-colors">
                            <ion-icon name="people" class="text-lg"></ion-icon>
                        </div>
                        <span x-show="sidebarOpen" x-transition class="ml-3 flex-1 text-left">User Management</span>
                        <div x-show="sidebarOpen" class="ml-auto flex items-center">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full mr-2">{{ $onlineUsers ?? 24 }}</span>
                            <ion-icon name="chevron-down" class="text-sm transition-transform" :class="{ 'rotate-180': expanded }"></ion-icon>
                        </div>
                        
                        <div x-show="!sidebarOpen && hoveredItem === 'users'" 
                             x-transition
                             class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                            User Management
                        </div>
                    </button>
                    
                    <!-- Submenu -->
                    <div x-show="expanded && sidebarOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="mt-2 ml-11 space-y-1">
                        <a href="{{ route('users.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            All Users
                        </a>
                        <a href="{{ route('users.create') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Add New User
                        </a>
                        <a href="#" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Roles & Permissions
                        </a>
                    </div>
                </div>

                <!-- Patient Management -->
                <a href="{{ route('patients.index') }}" 
                   @mouseenter="hoveredItem = 'patients'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800/50 hover:text-white' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('patients.*') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600/50' }} transition-colors">
                        <ion-icon name="medical" class="text-lg"></ion-icon>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Patients</span>
                    <div x-show="sidebarOpen" class="ml-auto">
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">125</span>
                    </div>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'patients'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Patients
                    </div>
                </a>
                
                <!-- Documentation Management -->
                <div x-data="{ expanded: false }" class="relative">
                    <button @click="expanded = !expanded; expandedMenu = expanded ? 'docs' : null" 
                            @mouseenter="hoveredItem = 'docs'" 
                            @mouseleave="hoveredItem = null"
                            class="group w-full flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-300 hover:bg-slate-800/50 hover:text-white">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600/50 transition-colors">
                            <ion-icon name="document-text" class="text-lg"></ion-icon>
                        </div>
                        <span x-show="sidebarOpen" x-transition class="ml-3 flex-1 text-left">Documentation</span>
                        <div x-show="sidebarOpen" class="ml-auto">
                            <ion-icon name="chevron-down" class="text-sm transition-transform" :class="{ 'rotate-180': expanded }"></ion-icon>
                        </div>
                        
                        <div x-show="!sidebarOpen && hoveredItem === 'docs'" 
                             x-transition
                             class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                            Documentation
                        </div>
                    </button>
                    
                    <div x-show="expanded && sidebarOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="mt-2 ml-11 space-y-1">
                        <a href="{{ route('assessments.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Assessments
                        </a>
                        <a href="{{ route('nursing-diagnoses.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Diagnoses
                        </a>
                        <a href="{{ route('nursing-interventions.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Interventions
                        </a>
                        <a href="{{ route('implementations.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Implementations
                        </a>
                        <a href="{{ route('evaluations.index') }}" class="block px-3 py-2 text-xs text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors">
                            Evaluations
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Section -->
            <div class="mb-6">
                <div x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-3">
                    System
                </div>
                
                <!-- Settings -->
                <a href="#" 
                   @mouseenter="hoveredItem = 'settings'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-300 hover:bg-slate-800/50 hover:text-white">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600/50 transition-colors">
                        <ion-icon name="settings" class="text-lg"></ion-icon>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Settings</span>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'settings'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Settings
                    </div>
                </a>
                
                <!-- Reports -->
                <a href="#" 
                   @mouseenter="hoveredItem = 'reports'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-300 hover:bg-slate-800/50 hover:text-white">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600/50 transition-colors">
                        <ion-icon name="bar-chart" class="text-lg"></ion-icon>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Reports</span>
                    <div x-show="sidebarOpen" class="ml-auto">
                        <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                    </div>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'reports'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Reports
                    </div>
                </a>
                
                <!-- Notifications -->
                <a href="#" 
                   @mouseenter="hoveredItem = 'notifications'" 
                   @mouseleave="hoveredItem = null"
                   class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-300 hover:bg-slate-800/50 hover:text-white">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-700/50 group-hover:bg-slate-600/50 transition-colors relative">
                        <ion-icon name="notifications" class="text-lg"></ion-icon>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 border border-slate-900 rounded-full text-xs flex items-center justify-center text-white font-bold" style="font-size: 8px;" x-text="notifications"></div>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Notifications</span>
                    <div x-show="sidebarOpen" class="ml-auto">
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full" x-text="notifications"></span>
                    </div>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'notifications'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Notifications
                    </div>
                </a>
            </div>

            <!-- Quick Actions -->
            <div x-show="sidebarOpen" class="mt-8 pt-6 border-t border-slate-700/50">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3 mb-3">
                    Quick Actions
                </div>
                
                <div class="grid grid-cols-2 gap-2 px-3">
                    <button class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <ion-icon name="add-circle" class="text-lg mb-1"></ion-icon>
                        <div>Add User</div>
                    </button>
                    <button class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <ion-icon name="cloud-download" class="text-lg mb-1"></ion-icon>
                        <div>Export</div>
                    </button>
                    <button class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <ion-icon name="shield-checkmark" class="text-lg mb-1"></ion-icon>
                        <div>Backup</div>
                    </button>
                    <button class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 rounded-lg text-xs font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <ion-icon name="refresh" class="text-lg mb-1"></ion-icon>
                        <div>Sync</div>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-slate-700/50 bg-slate-900/50">
        <!-- System Status -->
        <div x-show="sidebarOpen" 
             x-transition
             class="bg-slate-800/50 rounded-lg p-3 mb-4 border border-slate-700/30">
            <div class="flex items-center justify-between">
                <div class="text-xs text-slate-400">System Status</div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                    <span class="text-xs text-green-400 font-medium">Operational</span>
                </div>
            </div>
            <div class="mt-2 flex justify-between text-xs">
                <span class="text-slate-400">Uptime</span>
                <span class="text-white font-medium">99.9%</span>
            </div>
        </div>

        <!-- Profile & Logout -->
        <div class="flex items-center" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
            <a href="{{ route('profile.edit') }}" 
               @mouseenter="hoveredItem = 'profile'" 
               @mouseleave="hoveredItem = null"
               class="flex items-center p-2 text-slate-300 hover:text-white hover:bg-slate-800/50 rounded-lg transition-colors">
                <ion-icon name="person-circle" class="text-2xl"></ion-icon>
                <span x-show="sidebarOpen" x-transition class="ml-2 text-sm">Profile</span>
                
                <div x-show="!sidebarOpen && hoveredItem === 'profile'" 
                     x-transition
                     class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                    Profile
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" 
                        @mouseenter="hoveredItem = 'logout'" 
                        @mouseleave="hoveredItem = null"
                        class="flex items-center p-2 text-slate-300 hover:text-red-400 hover:bg-slate-800/50 rounded-lg transition-colors">
                    <ion-icon name="log-out" class="text-xl"></ion-icon>
                    <span x-show="sidebarOpen" x-transition class="ml-2 text-sm">Logout</span>
                    
                    <div x-show="!sidebarOpen && hoveredItem === 'logout'" 
                         x-transition
                         class="absolute left-20 bg-slate-800 text-white px-3 py-2 rounded-lg shadow-lg text-sm whitespace-nowrap z-50">
                        Logout
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>
