<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="document-text-outline" class="text-2xl text-blue-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">Panduan User</h1>
            </div>
            <p class="text-gray-600">Pelajari cara menggunakan sistem dokumentasi keperawatan</p>
        </div>

        <!-- Guide Sections -->
        <div class="space-y-8">
            @foreach($guides as $guide)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $guide['section'] }}</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($guide['items'] as $index => $item)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                {{ $index + 1 }}
                            </div>
                            <span class="text-gray-900 font-medium">{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Quick Tips -->
        <div class="mt-12 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tips Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mb-4">
                        <ion-icon name="flash" class="text-white text-xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Shortcut Keyboard</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Ctrl + S: Simpan data</li>
                        <li>Ctrl + N: Data baru</li>
                        <li>Ctrl + E: Edit data</li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-lg p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <ion-icon name="shield-checkmark" class="text-white text-xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Keamanan Data</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Logout setelah selesai</li>
                        <li>Jangan share password</li>
                        <li>Update password berkala</li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-lg p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <ion-icon name="checkmark-done" class="text-white text-xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Best Practices</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>Isi data lengkap & akurat</li>
                        <li>Backup data penting</li>
                        <li>Review sebelum submit</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Video Tutorials (Placeholder) -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Video Tutorial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <ion-icon name="play-circle" class="text-6xl text-gray-400"></ion-icon>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Pengenalan Dashboard</h3>
                        <p class="text-gray-600 text-sm">5 menit - Dasar navigasi sistem</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <ion-icon name="play-circle" class="text-6xl text-gray-400"></ion-icon>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Manajemen Pasien</h3>
                        <p class="text-gray-600 text-sm">8 menit - CRUD data pasien</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <ion-icon name="play-circle" class="text-6xl text-gray-400"></ion-icon>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Proses Keperawatan</h3>
                        <p class="text-gray-600 text-sm">12 menit - Workflow lengkap</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
