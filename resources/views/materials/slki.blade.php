<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="library-outline" class="text-2xl text-green-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">Materi SLKI</h1>
            </div>
            <p class="text-gray-600">Standar Luaran Keperawatan Indonesia</p>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($materials as $material)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                <div class="p-6">
                    <!-- Icon based on type -->
                    <div class="mb-4">
                        @if($material['type'] === 'foundation')
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="library" class="text-white text-2xl"></ion-icon>
                            </div>
                        @elseif($material['type'] === 'indicator')
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="analytics" class="text-white text-2xl"></ion-icon>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                <ion-icon name="checkmark-circle" class="text-white text-2xl"></ion-icon>
                            </div>
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $material['title'] }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $material['description'] }}</p>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-gray-700 text-sm leading-relaxed">{{ $material['content'] }}</p>
                    </div>

                    <x-learning-hint type="success" icon="checkmark-circle-outline">
                        <strong>Penting:</strong> SLKI membantu mengukur keberhasilan asuhan keperawatan secara objektif dan terstandar.
                    </x-learning-hint>
                </div>
            </div>
            @endforeach
        </div>

        <!-- SLKI Categories -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kategori Luaran SLKI</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg p-6 text-white">
                    <ion-icon name="heart" class="text-3xl mb-2"></ion-icon>
                    <h3 class="font-semibold">Fisiologis</h3>
                    <p class="text-sm text-blue-100">Luaran terkait fungsi tubuh</p>
                </div>
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg p-6 text-white">
                    <ion-icon name="happy" class="text-3xl mb-2"></ion-icon>
                    <h3 class="font-semibold">Psikologis</h3>
                    <p class="text-sm text-purple-100">Luaran kesehatan mental</p>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg p-6 text-white">
                    <ion-icon name="people" class="text-3xl mb-2"></ion-icon>
                    <h3 class="font-semibold">Perilaku</h3>
                    <p class="text-sm text-green-100">Luaran perubahan perilaku</p>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg p-6 text-white">
                    <ion-icon name="school" class="text-3xl mb-2"></ion-icon>
                    <h3 class="font-semibold">Pengetahuan</h3>
                    <p class="text-sm text-orange-100">Luaran edukasi pasien</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
