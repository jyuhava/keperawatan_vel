<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="clipboard-outline" class="text-2xl text-purple-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">Panduan SIKI</h1>
            </div>
            <p class="text-gray-600">Standar Intervensi Keperawatan Indonesia</p>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($materials as $material)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <!-- Icon based on type -->
                    <div class="mb-4">
                        @if($material['type'] === 'introduction')
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="clipboard" class="text-white text-2xl"></ion-icon>
                            </div>
                        @elseif($material['type'] === 'observation')
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="eye" class="text-white text-2xl"></ion-icon>
                            </div>
                        @elseif($material['type'] === 'therapeutic')
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="medical" class="text-white text-2xl"></ion-icon>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="school" class="text-white text-2xl"></ion-icon>
                            </div>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $material['title'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $material['description'] }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $material['content'] }}</p>
                    </div>

                    @if($material['type'] === 'observation')
                        <x-learning-hint type="info" icon="eye-outline">
                            <strong>Observasi:</strong> Kumpulkan data objektif dan subjektif secara sistematis.
                        </x-learning-hint>
                    @elseif($material['type'] === 'therapeutic')
                        <x-learning-hint type="success" icon="medical-outline">
                            <strong>Terapeutik:</strong> Tindakan langsung untuk mengatasi masalah keperawatan.
                        </x-learning-hint>
                    @else
                        <x-learning-hint type="warning" icon="school-outline">
                            <strong>Edukasi:</strong> Berikan informasi yang jelas dan mudah dipahami pasien.
                        </x-learning-hint>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- SIKI Structure -->
        <div class="mt-12 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Struktur Intervensi SIKI</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="eye" class="text-white text-2xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Observasi</h3>
                    <p class="text-gray-600 text-sm">Monitor, identifikasi, observasi kondisi pasien</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="medical" class="text-white text-2xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Terapeutik</h3>
                    <p class="text-gray-600 text-sm">Tindakan keperawatan langsung</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="school" class="text-white text-2xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Edukasi</h3>
                    <p class="text-gray-600 text-sm">Memberikan informasi dan pengajaran</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="people" class="text-white text-2xl"></ion-icon>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Kolaborasi</h3>
                    <p class="text-gray-600 text-sm">Kerjasama dengan tim kesehatan</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
