<x-admin-dashboard-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="breadcrumb">
        @php
        $breadcrumb = [
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Admin Dashboard']
        ];
        @endphp
        {{ $breadcrumb }}
    </x-slot>

    <!-- Admin Dashboard Content -->
    <div class="space-y-6">
        
        <!-- Welcome Section -->
        <div class="bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 rounded-xl p-8 text-white shadow-admin-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-blue-100 text-lg">
                        Manage your nursing care documentation system with comprehensive admin tools.
                    </p>
                    <div class="mt-4 flex items-center space-x-6 text-sm">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                            <span class="text-blue-100">System Operational</span>
                        </div>
                        <div class="flex items-center">
                            <ion-icon name="time-outline" class="mr-2"></ion-icon>
                            <span class="text-blue-100">Last updated: {{ now()->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="relative">
                        <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <ion-icon name="shield-checkmark" class="text-6xl text-white/80"></ion-icon>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                            <ion-icon name="checkmark" class="text-white font-bold"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users -->
            <div class="bg-white rounded-xl p-6 shadow-admin border border-gray-100 hover:shadow-admin-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" data-real-time>1,247</p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-600 text-sm font-medium flex items-center">
                                <ion-icon name="trending-up" class="mr-1"></ion-icon>
                                +12.5%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">vs last month</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-full group-hover:scale-110 transition-transform duration-300">
                        <ion-icon name="people" class="text-2xl text-white"></ion-icon>
                    </div>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-1000" style="width: 78%"></div>
                </div>
            </div>

            <!-- Active Students -->
            <div class="bg-white rounded-xl p-6 shadow-admin border border-gray-100 hover:shadow-admin-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700">Active Students</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" data-real-time>892</p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-600 text-sm font-medium flex items-center">
                                <ion-icon name="trending-up" class="mr-1"></ion-icon>
                                +8.2%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">this week</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-full group-hover:scale-110 transition-transform duration-300">
                        <ion-icon name="school" class="text-2xl text-white"></ion-icon>
                    </div>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-1000" style="width: 82%"></div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white rounded-xl p-6 shadow-admin border border-gray-100 hover:shadow-admin-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700">Total Patients</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" data-real-time>3,456</p>
                        <div class="flex items-center mt-2">
                            <span class="text-blue-600 text-sm font-medium flex items-center">
                                <ion-icon name="trending-up" class="mr-1"></ion-icon>
                                +15.3%
                            </span>
                            <span class="text-gray-500 text-sm ml-2">this month</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-full group-hover:scale-110 transition-transform duration-300">
                        <ion-icon name="medical" class="text-2xl text-white"></ion-icon>
                    </div>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full transition-all duration-1000" style="width: 92%"></div>
                </div>
            </div>

            <!-- System Health -->
            <div class="bg-white rounded-xl p-6 shadow-admin border border-gray-100 hover:shadow-admin-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-gray-700">System Health</p>
                        <p class="text-3xl font-bold text-green-600 mt-2" data-real-time>99.9%</p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-600 text-sm font-medium flex items-center">
                                <ion-icon name="checkmark-circle" class="mr-1"></ion-icon>
                                Excellent
                            </span>
                            <span class="text-gray-500 text-sm ml-2">uptime</span>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-4 rounded-full group-hover:scale-110 transition-transform duration-300">
                        <ion-icon name="pulse" class="text-2xl text-white"></ion-icon>
                    </div>
                </div>
                <div class="mt-4 w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-1000" style="width: 99%"></div>
                </div>
            </div>
        </div>

        <!-- Dashboard Widgets Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Recent Activity Feed -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-admin border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <ion-icon name="pulse" class="text-blue-600 mr-2"></ion-icon>
                            Real-time Activity
                        </h3>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-green-600 font-medium">Live</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 max-h-96 overflow-y-auto">
                    <div class="space-y-4" x-data="{ activities: [
                        {
                            user: 'Sarah Wijaya',
                            action: 'completed nursing assessment',
                            target: 'Patient ID: #12345',
                            time: '2 minutes ago',
                            type: 'success',
                            avatar: 'SW'
                        },
                        {
                            user: 'Dr. Ahmad',
                            action: 'reviewed diagnosis submission',
                            target: 'Student: Budi Santoso',
                            time: '5 minutes ago',
                            type: 'info',
                            avatar: 'DA'
                        },
                        {
                            user: 'Lisa Chen',
                            action: 'requested help with',
                            target: 'Nursing Intervention Plan',
                            time: '8 minutes ago',
                            type: 'warning',
                            avatar: 'LC'
                        },
                        {
                            user: 'System',
                            action: 'backup completed successfully',
                            target: 'Database & Files',
                            time: '12 minutes ago',
                            type: 'success',
                            avatar: 'SYS'
                        },
                        {
                            user: 'Nurse Rita',
                            action: 'updated patient status',
                            target: 'Patient ID: #12347',
                            time: '15 minutes ago',
                            type: 'info',
                            avatar: 'NR'
                        }
                    ] }">
                        <template x-for="activity in activities" :key="activity.user + activity.time">
                            <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold"
                                         :class="{
                                            'bg-green-100 text-green-600': activity.type === 'success',
                                            'bg-blue-100 text-blue-600': activity.type === 'info',
                                            'bg-yellow-100 text-yellow-600': activity.type === 'warning',
                                            'bg-gray-100 text-gray-600': activity.type === 'system'
                                         }"
                                         x-text="activity.avatar">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-semibold" x-text="activity.user"></span>
                                        <span x-text="activity.action"></span>
                                        <span class="font-medium text-blue-600" x-text="activity.target"></span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1" x-text="activity.time"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <template x-if="activity.type === 'success'">
                                        <ion-icon name="checkmark-circle" class="text-lg text-green-500"></ion-icon>
                                    </template>
                                    <template x-if="activity.type === 'info'">
                                        <ion-icon name="information-circle" class="text-lg text-blue-500"></ion-icon>
                                    </template>
                                    <template x-if="activity.type === 'warning'">
                                        <ion-icon name="warning" class="text-lg text-yellow-500"></ion-icon>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & System Status -->
            <div class="space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-admin border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <ion-icon name="flash" class="text-purple-600 mr-2"></ion-icon>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <button onclick="window.location.href='{{ route('users.create') }}'"
                                    class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <ion-icon name="person-add" class="text-2xl mb-2"></ion-icon>
                                <div>Add User</div>
                            </button>
                            
                            <button class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <ion-icon name="download" class="text-2xl mb-2"></ion-icon>
                                <div>Export Data</div>
                            </button>
                            
                            <button class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-4 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <ion-icon name="shield-checkmark" class="text-2xl mb-2"></ion-icon>
                                <div>System Backup</div>
                            </button>
                            
                            <button class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-4 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <ion-icon name="bar-chart" class="text-2xl mb-2"></ion-icon>
                                <div>View Reports</div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="bg-white rounded-xl shadow-admin border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <ion-icon name="server" class="text-green-600 mr-2"></ion-icon>
                            System Status
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Server Status -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3 animate-pulse"></div>
                                    <span class="text-sm font-medium text-gray-700">Server Status</span>
                                </div>
                                <span class="text-sm text-green-600 font-semibold">Online</span>
                            </div>
                            
                            <!-- Database -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Database</span>
                                </div>
                                <span class="text-sm text-green-600 font-semibold">Healthy</span>
                            </div>
                            
                            <!-- Storage -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Storage</span>
                                </div>
                                <span class="text-sm text-yellow-600 font-semibold">78% Used</span>
                            </div>
                            
                            <!-- Backup -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Last Backup</span>
                                </div>
                                <span class="text-sm text-green-600 font-semibold">2h ago</span>
                            </div>
                        </div>
                        
                        <!-- System Performance Chart -->
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <div class="text-sm font-medium text-gray-700 mb-2">Performance (24h)</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full transition-all duration-1000" style="width: 94%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Excellent</span>
                                <span>94%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users & Notifications -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-admin border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <ion-icon name="people" class="text-blue-600 mr-2"></ion-icon>
                            Recent Users
                        </h3>
                        <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View All →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @for($i = 0; $i < 5; $i++)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=User{{ $i }}&background=random" 
                                     alt="User Avatar" class="w-10 h-10 rounded-full">
                                <div>
                                    <div class="font-medium text-gray-900">User Name {{ $i + 1 }}</div>
                                    <div class="text-sm text-gray-500">user{{ $i + 1 }}@example.com</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ ['Student', 'Teacher', 'Admin'][array_rand(['Student', 'Teacher', 'Admin'])] }}
                                </div>
                                <div class="text-xs text-gray-500">{{ rand(1, 30) }} days ago</div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- System Notifications -->
            <div class="bg-white rounded-xl shadow-admin border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <ion-icon name="notifications" class="text-orange-600 mr-2"></ion-icon>
                            System Notifications
                        </h3>
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">5 New</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <ion-icon name="information-circle" class="text-blue-600 text-xl mt-0.5"></ion-icon>
                            <div>
                                <div class="font-medium text-blue-900">System Update Available</div>
                                <div class="text-sm text-blue-700 mt-1">New features and security improvements are ready.</div>
                                <div class="text-xs text-blue-600 mt-2">2 minutes ago</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <ion-icon name="checkmark-circle" class="text-green-600 text-xl mt-0.5"></ion-icon>
                            <div>
                                <div class="font-medium text-green-900">Backup Completed</div>
                                <div class="text-sm text-green-700 mt-1">Daily backup finished successfully.</div>
                                <div class="text-xs text-green-600 mt-2">2 hours ago</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <ion-icon name="warning" class="text-yellow-600 text-xl mt-0.5"></ion-icon>
                            <div>
                                <div class="font-medium text-yellow-900">Storage Warning</div>
                                <div class="text-sm text-yellow-700 mt-1">Storage usage is above 75%. Consider cleanup.</div>
                                <div class="text-xs text-yellow-600 mt-2">1 day ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh dashboard -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate real-time updates
            setInterval(() => {
                const stats = document.querySelectorAll('[data-real-time]');
                stats.forEach(stat => {
                    if (Math.random() < 0.1) { // 10% chance of update
                        stat.style.transform = 'scale(1.05)';
                        stat.style.color = '#3b82f6';
                        setTimeout(() => {
                            stat.style.transform = 'scale(1)';
                            stat.style.color = '';
                        }, 500);
                    }
                });
            }, 3000);

            // Show welcome notification
            setTimeout(() => {
                window.showNotification({
                    type: 'success',
                    title: 'Welcome Back!',
                    message: 'Admin dashboard loaded successfully. All systems operational.',
                    duration: 5000
                });
            }, 1000);
        });
    </script>
</x-admin-dashboard-layout>
