<x-dashboard-layout>
    <x-slot name="title">Dashboard Dosen - Monitoring Pembelajaran</x-slot>

    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->name }}!</h2>
                        <p class="mt-2 text-indigo-100">
                            Monitor progress pembelajaran mahasiswa dan berikan bimbingan real-time
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <ion-icon name="school" class="text-6xl text-indigo-200"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Stats Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Active Students -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <ion-icon name="people" class="text-2xl text-green-600"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Mahasiswa Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">24</p>
                        <p class="text-xs text-green-600">↑ 12% dari minggu lalu</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-xs text-gray-500">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                        <span>18 online sekarang</span>
                    </div>
                </div>
            </div>

            <!-- Pending Reviews -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <ion-icon name="hourglass" class="text-2xl text-yellow-600"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Menunggu Review</p>
                        <p class="text-2xl font-bold text-gray-900">8</p>
                        <p class="text-xs text-yellow-600">Rata-rata 15 menit</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="text-xs bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full transition-colors">
                        Review Sekarang
                    </button>
                </div>
            </div>

            <!-- Collaboration Messages -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <ion-icon name="chatbubbles" class="text-2xl text-purple-600"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pesan Kolaborasi</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                        <p class="text-xs text-purple-600">3 baru</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-xs text-gray-500">
                        <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                        <span>Respons rata-rata 5 menit</span>
                    </div>
                </div>
            </div>

            <!-- Learning Progress -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <ion-icon name="trending-up" class="text-2xl text-blue-600"></ion-icon>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Progress</p>
                        <p class="text-2xl font-bold text-gray-900">78%</p>
                        <p class="text-xs text-blue-600">↑ 5% minggu ini</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Student Activity -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Mahasiswa Real-time</h3>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center text-green-600">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                            <span class="text-sm">Live</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Activity Stream -->
                <div class="space-y-4" x-data="{ activities: [
                    {
                        student: 'Sarah Wijaya',
                        action: 'mengerjakan diagnosis keperawatan',
                        patient: 'Tn. Ahmad (RM: 12345)',
                        status: 'in-progress',
                        time: '2 menit lalu',
                        avatar: 'SW'
                    },
                    {
                        student: 'Budi Santoso',
                        action: 'menyelesaikan assessment',
                        patient: 'Ny. Sari (RM: 12346)',
                        status: 'completed',
                        time: '5 menit lalu',
                        avatar: 'BS'
                    },
                    {
                        student: 'Lisa Chen',
                        action: 'membutuhkan bantuan pada',
                        patient: 'An. Riko (RM: 12347)',
                        status: 'help-needed',
                        time: '8 menit lalu',
                        avatar: 'LC'
                    },
                    {
                        student: 'Ahmad Fadli',
                        action: 'mengirim pesan kolaborasi',
                        patient: 'Ny. Indah (RM: 12348)',
                        status: 'message',
                        time: '12 menit lalu',
                        avatar: 'AF'
                    }
                ] }">
                    
                    <template x-for="activity in activities" :key="activity.student + activity.time">
                        <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-indigo-600" x-text="activity.avatar"></span>
                                </div>
                            </div>
                            
                            <!-- Activity Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium" x-text="activity.student"></span>
                                        <span x-text="activity.action"></span>
                                        <span class="font-medium" x-text="activity.patient"></span>
                                    </p>
                                    <p class="text-xs text-gray-500" x-text="activity.time"></p>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="mt-1">
                                    <template x-if="activity.status === 'in-progress'">
                                        <span class="inline-flex items-center text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                            Sedang dikerjakan
                                        </span>
                                    </template>
                                    <template x-if="activity.status === 'completed'">
                                        <span class="inline-flex items-center text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            <ion-icon name="checkmark-circle" class="mr-1"></ion-icon>
                                            Selesai
                                        </span>
                                    </template>
                                    <template x-if="activity.status === 'help-needed'">
                                        <span class="inline-flex items-center text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                            <ion-icon name="help-circle" class="mr-1"></ion-icon>
                                            Perlu bantuan
                                        </span>
                                    </template>
                                    <template x-if="activity.status === 'message'">
                                        <span class="inline-flex items-center text-xs text-purple-600 bg-purple-100 px-2 py-1 rounded-full">
                                            <ion-icon name="chatbubble" class="mr-1"></ion-icon>
                                            Pesan
                                        </span>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="flex items-center space-x-2">
                                <template x-if="activity.status === 'help-needed'">
                                    <button class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-colors">
                                        <ion-icon name="chatbubble-outline"></ion-icon>
                                    </button>
                                </template>
                                <button class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Load More -->
                <div class="text-center mt-6">
                    <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Lihat aktivitas lainnya
                    </button>
                </div>
            </div>
        </div>

        <!-- Learning Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Progress Overview -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Progress Pembelajaran</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Assessment Progress -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Assessment</span>
                                <span class="font-medium">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        
                        <!-- Diagnosis Progress -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Diagnosis</span>
                                <span class="font-medium">72%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>
                        
                        <!-- Planning Progress -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Planning</span>
                                <span class="font-medium">68%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 68%"></div>
                            </div>
                        </div>
                        
                        <!-- Implementation Progress -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Implementation</span>
                                <span class="font-medium">63%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 63%"></div>
                            </div>
                        </div>
                        
                        <!-- Evaluation Progress -->
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700">Evaluation</span>
                                <span class="font-medium">58%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-600 h-2 rounded-full" style="width: 58%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Performance -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Performa Terbaik</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-yellow-600">1</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Sarah Wijaya</p>
                                    <p class="text-sm text-gray-600">95% completion</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">Excellent</p>
                                <p class="text-xs text-gray-500">24 cases</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-gray-600">2</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Ahmad Fadli</p>
                                    <p class="text-sm text-gray-600">89% completion</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-blue-600">Very Good</p>
                                <p class="text-xs text-gray-500">21 cases</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-yellow-600">3</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Lisa Chen</p>
                                    <p class="text-sm text-gray-600">84% completion</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-blue-600">Good</p>
                                <p class="text-xs text-gray-500">19 cases</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Lihat semua mahasiswa →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Tindakan Cepat</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <button class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 text-center transition-colors">
                        <ion-icon name="eye" class="text-3xl text-blue-600 mb-2"></ion-icon>
                        <div class="text-sm font-medium text-blue-900">Review Submissions</div>
                        <div class="text-xs text-blue-600 mt-1">8 menunggu</div>
                    </button>
                    
                    <button class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 text-center transition-colors">
                        <ion-icon name="chatbubbles" class="text-3xl text-purple-600 mb-2"></ion-icon>
                        <div class="text-sm font-medium text-purple-900">Join Collaboration</div>
                        <div class="text-xs text-purple-600 mt-1">12 pesan baru</div>
                    </button>
                    
                    <button class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 text-center transition-colors">
                        <ion-icon name="trending-up" class="text-3xl text-green-600 mb-2"></ion-icon>
                        <div class="text-sm font-medium text-green-900">View Analytics</div>
                        <div class="text-xs text-green-600 mt-1">Detail progress</div>
                    </button>
                    
                    <button class="bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg p-4 text-center transition-colors">
                        <ion-icon name="settings" class="text-3xl text-yellow-600 mb-2"></ion-icon>
                        <div class="text-sm font-medium text-yellow-900">Settings</div>
                        <div class="text-xs text-yellow-600 mt-1">Konfigurasi sistem</div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-refresh dashboard -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh every 30 seconds
        setInterval(() => {
            // In real implementation, this would fetch fresh data
            console.log('Dashboard auto-refresh');
        }, 30000);
    });
    </script>
</x-dashboard-layout>
