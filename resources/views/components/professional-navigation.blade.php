<div x-data="{ 
    showAdminMenu: false,
    notifications: {{ auth()->user()->isAdmin() ? 5 : 0 }},
    userRole: '{{ auth()->user()->role }}',
    userName: '{{ auth()->user()->name }}'
}" class="relative">

    <!-- Main Navigation Bar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                <!-- Left side - Logo and main nav -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                            <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-lg">
                                <ion-icon name="medical" class="text-2xl text-white"></ion-icon>
                            </div>
                            <div>
                                <div class="text-xl font-bold text-gray-900">NursingCare</div>
                                <div class="text-xs text-gray-500">Documentation System</div>
                            </div>
                        </a>
                    </div>

                    <!-- Main Navigation Links -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('dashboard') }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <ion-icon name="home" class="mr-2"></ion-icon>
                            Dashboard
                        </a>

                        @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('patients.index') }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('patients.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <ion-icon name="people" class="mr-2"></ion-icon>
                            Patients
                        </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}" 
                           class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors
                                  {{ request()->routeIs('users.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            <ion-icon name="settings" class="mr-2"></ion-icon>
                            User Management
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Right side - Admin controls and user menu -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Admin Quick Actions -->
                    @if(auth()->user()->isAdmin())
                    <div class="relative">
                        <button @click="showAdminMenu = !showAdminMenu" 
                                class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 
                                       text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
                                       transform hover:scale-105 shadow-lg flex items-center space-x-2">
                            <ion-icon name="shield-checkmark" class="text-lg"></ion-icon>
                            <span>Admin Panel</span>
                            <ion-icon name="chevron-down" class="text-sm transition-transform"
                                      :class="showAdminMenu ? 'rotate-180' : ''"></ion-icon>
                        </button>

                        <!-- Admin Dropdown Menu -->
                        <div x-show="showAdminMenu" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="showAdminMenu = false"
                             class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                            
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="text-sm font-semibold text-gray-900">Admin Dashboard</div>
                                <div class="text-xs text-gray-500">Professional management interface</div>
                            </div>
                            
                            <div class="py-2">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-colors group">
                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                        <ion-icon name="analytics" class="text-white"></ion-icon>
                                    </div>
                                    <div>
                                        <div class="font-medium">Professional Dashboard</div>
                                        <div class="text-xs text-gray-500">Advanced admin interface</div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('users.index') }}" 
                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-blue-50 transition-colors group">
                                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                        <ion-icon name="people" class="text-white"></ion-icon>
                                    </div>
                                    <div>
                                        <div class="font-medium">User Management</div>
                                        <div class="text-xs text-gray-500">Manage system users</div>
                                    </div>
                                </a>
                                
                                <button onclick="performBackup()" 
                                        class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 transition-colors group">
                                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-2 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                        <ion-icon name="shield-checkmark" class="text-white"></ion-icon>
                                    </div>
                                    <div>
                                        <div class="font-medium">System Backup</div>
                                        <div class="text-xs text-gray-500">Create system backup</div>
                                    </div>
                                </button>
                                
                                <button onclick="exportData('system_report')" 
                                        class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 transition-colors group">
                                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg mr-3 group-hover:scale-110 transition-transform">
                                        <ion-icon name="download" class="text-white"></ion-icon>
                                    </div>
                                    <div>
                                        <div class="font-medium">Export Reports</div>
                                        <div class="text-xs text-gray-500">Download system data</div>
                                    </div>
                                </button>
                            </div>
                            
                            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50 rounded-b-xl">
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center text-green-600">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                        System Status: Healthy
                                    </div>
                                    <div class="text-gray-500">
                                        Uptime: 99.9%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notifications -->
                    <div class="relative">
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition-colors">
                            <ion-icon name="notifications" class="text-xl"></ion-icon>
                            <span x-show="notifications > 0" 
                                  class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse"
                                  x-text="notifications">
                            </span>
                        </button>
                    </div>

                    <!-- User Menu -->
                    <div class="relative" x-data="{ showUserMenu: false }">
                        <button @click="showUserMenu = !showUserMenu" 
                                class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition-colors">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                                 alt="Profile" class="w-8 h-8 rounded-full ring-2 ring-gray-200">
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-medium text-gray-900" x-text="userName"></div>
                                <div class="text-xs text-gray-500 capitalize" x-text="userRole"></div>
                            </div>
                        </button>

                        <div x-show="showUserMenu" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             @click.away="showUserMenu = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                            
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <ion-icon name="person" class="mr-3 text-gray-400"></ion-icon>
                                Profile Settings
                            </a>
                            
                            <hr class="my-2 border-gray-100">
                            
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <ion-icon name="log-out" class="mr-3"></ion-icon>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation (Hamburger Menu) -->
    <div x-data="{ showMobileMenu: false }" class="md:hidden">
        <button @click="showMobileMenu = !showMobileMenu" 
                class="fixed top-4 right-4 z-50 bg-white p-2 rounded-lg shadow-lg border border-gray-200">
            <ion-icon name="menu" x-show="!showMobileMenu" class="text-xl"></ion-icon>
            <ion-icon name="close" x-show="showMobileMenu" class="text-xl"></ion-icon>
        </button>

        <div x-show="showMobileMenu" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             class="fixed inset-y-0 left-0 z-40 w-64 bg-white shadow-xl border-r border-gray-200 overflow-y-auto">
            
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-lg">
                        <ion-icon name="medical" class="text-xl text-white"></ion-icon>
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">NursingCare</div>
                        <div class="text-xs text-gray-500">Mobile Menu</div>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <ion-icon name="home"></ion-icon>
                    <span>Dashboard</span>
                </a>

                @if(auth()->user()->role !== 'admin')
                <a href="{{ route('patients.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <ion-icon name="people"></ion-icon>
                    <span>Patients</span>
                </a>
                @endif

                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <ion-icon name="analytics"></ion-icon>
                    <span>Admin Dashboard</span>
                </a>
                
                <a href="{{ route('users.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <ion-icon name="settings"></ion-icon>
                    <span>User Management</span>
                </a>
                @endif
            </nav>
        </div>
    </div>
</div>

<!-- JavaScript Functions for Admin Actions -->
@if(auth()->user()->isAdmin())
<script>
    function performBackup() {
        window.showNotification({
            type: 'info',
            title: 'Backup Started',
            message: 'System backup is being created...',
            duration: 3000
        });
        
        fetch('/admin/backup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            window.showNotification({
                type: 'success',
                title: 'Backup Complete',
                message: data.message || 'System backup completed successfully',
                duration: 5000
            });
        })
        .catch(error => {
            window.showNotification({
                type: 'error',
                title: 'Backup Failed',
                message: 'Failed to create system backup',
                duration: 5000
            });
        });
    }

    function exportData(type) {
        window.showNotification({
            type: 'info',
            title: 'Export Started',
            message: 'Preparing data export...',
            duration: 3000
        });
        
        fetch('/admin/export', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            window.showNotification({
                type: 'success',
                title: 'Export Ready',
                message: data.message || 'Data export completed',
                duration: 5000
            });
        })
        .catch(error => {
            window.showNotification({
                type: 'error',
                title: 'Export Failed',
                message: 'Failed to export data',
                duration: 5000
            });
        });
    }
</script>
@endif
