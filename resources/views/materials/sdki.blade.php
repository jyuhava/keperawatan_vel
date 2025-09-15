<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="book-outline" class="text-2xl text-blue-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">Panduan SDKI</h1>
            </div>
            <p class="text-gray-600">Standar Diagnosis Keperawatan Indonesia</p>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($materials as $material)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <!-- Icon based on type -->
                    <div class="mb-4">
                        @if($material['type'] === 'introduction')
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="information-circle" class="text-white text-2xl"></ion-icon>
                            </div>
                        @elseif($material['type'] === 'category')
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="list" class="text-white text-2xl"></ion-icon>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="document-text" class="text-white text-2xl"></ion-icon>
                            </div>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $material['title'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $material['description'] }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $material['content'] }}</p>
                    </div>

                    <x-learning-hint type="tip" icon="bulb-outline">
                        <strong>Tips:</strong> Pelajari setiap bagian secara bertahap dan praktikkan dengan kasus nyata untuk pemahaman yang lebih baik.
                    </x-learning-hint>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Additional Resources -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Sumber Referensi Tambahan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Buku Panduan Resmi SDKI</h3>
                    <p class="text-gray-600 text-sm">Unduh panduan lengkap SDKI dari sumber resmi</p>
                    <button class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <ion-icon name="download" class="mr-2"></ion-icon>
                        Download PDF
                    </button>
                </div>
                <div class="bg-white rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Video Tutorial</h3>
                    <p class="text-gray-600 text-sm">Tonton video penjelasan tentang penerapan SDKI</p>
                    <button class="mt-3 inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <ion-icon name="play" class="mr-2"></ion-icon>
                        Tonton Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
