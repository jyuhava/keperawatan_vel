<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - NurseCare Pro</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Admin Styles -->
    <style>
        /* Custom scrollbar for sidebar */
        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(51, 65, 85, 0.1);
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }

        /* Smooth transitions for all elements */
        * {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        }
        
        /* Custom gradient backgrounds */
        .bg-admin-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-admin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Animation classes */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Custom shadows */
        .shadow-admin {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .shadow-admin-lg {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>

    <!-- Additional Scripts -->
    <script>
        // Admin Dashboard specific configurations
        window.adminConfig = {
            autoRefresh: true,
            refreshInterval: 30000, // 30 seconds
            notifications: true,
            realTimeUpdates: true
        };
        
        // Global admin functions
        window.adminUtils = {
            showSuccess: (message) => {
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'success', title: 'Success', message: message }
                }));
            },
            showError: (message) => {
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'error', title: 'Error', message: message }
                }));
            },
            showInfo: (message) => {
                window.dispatchEvent(new CustomEvent('show-notification', {
                    detail: { type: 'info', title: 'Information', message: message }
                }));
            },
            confirmAction: (message, callback) => {
                if (confirm(message)) {
                    callback();
                }
            }
        };
        
        // Auto-refresh dashboard data
        document.addEventListener('DOMContentLoaded', function() {
            if (window.adminConfig.autoRefresh) {
                setInterval(() => {
                    // Refresh dashboard stats
                    console.log('Admin dashboard auto-refresh');
                    // In real implementation, this would update dashboard widgets
                }, window.adminConfig.refreshInterval);
            }
        });
    </script>
</head>

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: true, darkMode: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Enhanced Notification System for Admin -->
        <x-notification-system />
        
        <!-- Admin Sidebar -->
        <x-admin-sidebar :current-route="request()->route()->getName()" />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Page Title & Breadcrumb -->
                        <div class="flex items-center space-x-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">
                                    {{ $title ?? 'Admin Dashboard' }}
                                </h1>
                                @if(isset($breadcrumb))
                                <nav class="flex mt-1" aria-label="Breadcrumb">
                                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                        @foreach($breadcrumb as $item)
                                        <li class="inline-flex items-center">
                                            @if($loop->first)
                                                <a href="{{ $item['url'] ?? '#' }}" class="text-sm font-medium text-gray-500 hover:text-blue-600">
                                                    {{ $item['label'] }}
                                                </a>
                                            @else
                                                <ion-icon name="chevron-forward" class="text-gray-400 mx-1"></ion-icon>
                                                @if($loop->last)
                                                    <span class="text-sm font-medium text-gray-900">{{ $item['label'] }}</span>
                                                @else
                                                    <a href="{{ $item['url'] ?? '#' }}" class="text-sm font-medium text-gray-500 hover:text-blue-600">
                                                        {{ $item['label'] }}
                                                    </a>
                                                @endif
                                            @endif
                                        </li>
                                        @endforeach
                                    </ol>
                                </nav>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Top Bar Actions -->
                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" 
                                       placeholder="Quick search..." 
                                       class="bg-gray-100 border-0 rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-colors">
                                <ion-icon name="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></ion-icon>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="flex items-center space-x-2">
                                <!-- Notifications -->
                                <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                    <ion-icon name="notifications-outline" class="text-xl"></ion-icon>
                                    <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
                                </button>
                                
                                <!-- Messages -->
                                <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                    <ion-icon name="mail-outline" class="text-xl"></ion-icon>
                                    <span class="absolute top-0 right-0 w-3 h-3 bg-blue-500 border-2 border-white rounded-full"></span>
                                </button>
                                
                                <!-- Settings -->
                                <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                    <ion-icon name="settings-outline" class="text-xl"></ion-icon>
                                </button>
                                
                                <!-- User Menu -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="flex items-center space-x-3 p-2 text-sm bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=3b82f6&color=fff&size=32" 
                                             alt="Admin Avatar" class="w-8 h-8 rounded-lg">
                                        <div class="text-left">
                                            <div class="font-medium text-gray-900">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                                            <div class="text-xs text-gray-500">Administrator</div>
                                        </div>
                                        <ion-icon name="chevron-down" class="text-gray-400"></ion-icon>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div x-show="open" 
                                         @click.outside="open = false"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                        <div class="py-1">
                                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <ion-icon name="person-outline" class="mr-3"></ion-icon>
                                                Profile Settings
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <ion-icon name="shield-outline" class="mr-3"></ion-icon>
                                                Security
                                            </a>
                                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <ion-icon name="help-circle-outline" class="mr-3"></ion-icon>
                                                Help & Support
                                            </a>
                                            <hr class="my-1">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                    <ion-icon name="log-out-outline" class="mr-3"></ion-icon>
                                                    Sign Out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="p-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center animate-fade-in">
                        <ion-icon name="checkmark-circle" class="text-xl mr-3"></ion-icon>
                        <div>
                            <div class="font-medium">Success!</div>
                            <div class="text-sm">{{ session('success') }}</div>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center animate-fade-in">
                        <ion-icon name="alert-circle" class="text-xl mr-3"></ion-icon>
                        <div>
                            <div class="font-medium">Error!</div>
                            <div class="text-sm">{{ session('error') }}</div>
                        </div>
                    </div>
                    @endif

                    <!-- Page Content -->
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Overlay (for AJAX operations) -->
    <div x-data="{ loading: false }" 
         @show-loading.window="loading = true" 
         @hide-loading.window="loading = false"
         x-show="loading" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <div class="text-gray-900 font-medium">Processing...</div>
        </div>
    </div>

    <!-- Admin specific scripts -->
    <script>
        // Enhanced admin functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-save functionality
            const forms = document.querySelectorAll('form[data-auto-save]');
            forms.forEach(form => {
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('change', () => {
                        // Auto-save logic here
                        console.log('Auto-saving form data...');
                    });
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S for quick save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    const activeForm = document.querySelector('form:focus-within');
                    if (activeForm) {
                        activeForm.submit();
                    }
                }
                
                // Ctrl/Cmd + K for quick search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    document.querySelector('input[placeholder*="search"]')?.focus();
                }
            });

            // Real-time updates simulation
            if (window.adminConfig.realTimeUpdates) {
                setInterval(() => {
                    // Update stats, notifications, etc.
                    const statsElements = document.querySelectorAll('[data-real-time]');
                    statsElements.forEach(el => {
                        // Simulate real-time data updates
                        if (Math.random() < 0.1) { // 10% chance of update
                            el.classList.add('animate-pulse');
                            setTimeout(() => {
                                el.classList.remove('animate-pulse');
                            }, 1000);
                        }
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>
