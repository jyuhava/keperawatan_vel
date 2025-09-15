@props(['patientData' => null, 'currentField' => ''])

<div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200 mb-6"
     x-data="{ 
        showDetailedHelp: false,
        currentTip: 0,
        tips: @js([
            [
                'title' => 'Analisis Data Assessment',
                'content' => 'Periksa data subjektif (keluhan pasien) dan objektif (tanda vital, pemeriksaan fisik) sebelum menentukan diagnosis.',
                'icon' => 'search-outline'
            ],
            [
                'title' => 'Hierarki Maslow',
                'content' => 'Prioritaskan kebutuhan fisiologis dasar (ABC) sebelum kebutuhan psikososial.',
                'icon' => 'triangle-outline'
            ],
            [
                'title' => 'Validasi dengan Evidence',
                'content' => 'Pastikan setiap diagnosis didukung oleh data yang dapat diamati atau diukur.',
                'icon' => 'checkmark-circle-outline'
            ],
            [
                'title' => 'Kolaborasi dengan Tim',
                'content' => 'Diskusikan dengan dosen pembimbing atau perawat senior jika ragu dengan diagnosis.',
                'icon' => 'people-outline'
            ]
        ])
     }">
     
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="bg-purple-100 p-3 rounded-full mr-4">
                <ion-icon name="school" class="text-2xl text-purple-600"></ion-icon>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-purple-900">Pembelajaran Adaptif</h3>
                <p class="text-purple-700 text-sm">Bantuan kontekstual berdasarkan data pasien</p>
            </div>
        </div>
        
        <button @click="showDetailedHelp = !showDetailedHelp"
                class="text-purple-600 hover:text-purple-800 transition-colors">
            <ion-icon name="help-circle" class="text-2xl"></ion-icon>
        </button>
    </div>
    
    <!-- Contextual Learning Tips based on patient data -->
    @if($patientData)
    <div class="bg-white rounded-lg p-4 mb-4 border border-purple-100">
        <h4 class="font-semibold text-purple-900 mb-3 flex items-center">
            <ion-icon name="bulb" class="mr-2 text-yellow-500"></ion-icon>
            Berdasarkan Data Pasien Ini
        </h4>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <!-- Dynamic suggestions based on patient age -->
            <div class="space-y-2">
                <div class="font-medium text-gray-800">Pertimbangan Usia:</div>
                @if(isset($patientData['age']) && $patientData['age'] > 65)
                <div class="text-orange-800 bg-orange-50 p-2 rounded flex items-start">
                    <ion-icon name="warning" class="mr-2 text-orange-600 mt-0.5 flex-shrink-0"></ion-icon>
                    <div>
                        <strong>Lansia ({{ $patientData['age'] }} tahun):</strong><br>
                        Prioritaskan risiko jatuh, gangguan mobilitas, dan defisit perawatan diri
                    </div>
                </div>
                @elseif(isset($patientData['age']) && $patientData['age'] < 18)
                <div class="text-blue-800 bg-blue-50 p-2 rounded flex items-start">
                    <ion-icon name="happy" class="mr-2 text-blue-600 mt-0.5 flex-shrink-0"></ion-icon>
                    <div>
                        <strong>Pediatrik ({{ $patientData['age'] }} tahun):</strong><br>
                        Fokus pada gangguan pertumbuhan, kecemasan perpisahan, dan ketakutan
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Dynamic suggestions based on medical diagnosis -->
            <div class="space-y-2">
                <div class="font-medium text-gray-800">Berdasarkan Diagnosa Medis:</div>
                @if(isset($patientData['medical_diagnosis']))
                <div class="text-green-800 bg-green-50 p-2 rounded flex items-start">
                    <ion-icon name="medical" class="mr-2 text-green-600 mt-0.5 flex-shrink-0"></ion-icon>
                    <div>
                        <strong>{{ $patientData['medical_diagnosis'] }}:</strong><br>
                        <span class="text-xs">Cari diagnosis keperawatan yang terkait dengan kondisi ini</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    
    <!-- Learning Tips Carousel -->
    <div class="bg-white rounded-lg p-4 border border-purple-100">
        <div class="flex items-center justify-between mb-3">
            <h4 class="font-semibold text-purple-900">💡 Tips Pembelajaran</h4>
            <div class="flex items-center space-x-2">
                <button @click="currentTip = Math.max(0, currentTip - 1)" 
                        :disabled="currentTip === 0"
                        class="p-1 rounded-full bg-purple-100 text-purple-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-purple-200 transition-colors">
                    <ion-icon name="chevron-back" class="text-lg"></ion-icon>
                </button>
                <span class="text-xs text-purple-600 font-medium" x-text="`${currentTip + 1}/${tips.length}`"></span>
                <button @click="currentTip = Math.min(tips.length - 1, currentTip + 1)"
                        :disabled="currentTip === tips.length - 1"
                        class="p-1 rounded-full bg-purple-100 text-purple-600 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-purple-200 transition-colors">
                    <ion-icon name="chevron-forward" class="text-lg"></ion-icon>
                </button>
            </div>
        </div>
        
        <div class="min-h-20">
            <template x-for="(tip, index) in tips" :key="index">
                <div x-show="currentTip === index" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-4"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-4"
                     class="flex items-start">
                    <ion-icon :name="tip.icon" class="text-2xl text-purple-600 mr-3 mt-1 flex-shrink-0"></ion-icon>
                    <div>
                        <div class="font-medium text-purple-900 mb-1" x-text="tip.title"></div>
                        <div class="text-sm text-purple-700" x-text="tip.content"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Detailed Help Modal -->
    <div x-show="showDetailedHelp" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         @click.self="showDetailedHelp = false">
        <div class="bg-white rounded-lg p-6 max-w-2xl max-h-96 overflow-y-auto m-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Panduan Lengkap Diagnosis Keperawatan</h3>
                <button @click="showDetailedHelp = false" 
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <ion-icon name="close" class="text-2xl"></ion-icon>
                </button>
            </div>
            
            <div class="space-y-4 text-sm">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-blue-900 mb-2">🔍 Langkah-langkah Analisis</h4>
                    <ol class="list-decimal list-inside space-y-1 text-blue-800">
                        <li>Kumpulkan dan analisis data assessment</li>
                        <li>Identifikasi pola atau masalah kesehatan</li>
                        <li>Bandingkan dengan karakteristik SDKI</li>
                        <li>Tentukan diagnosis yang paling sesuai</li>
                        <li>Susun dalam format PES statement</li>
                    </ol>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-green-900 mb-2">✅ Kriteria Diagnosis yang Baik</h4>
                    <ul class="list-disc list-inside space-y-1 text-green-800">
                        <li>Spesifik dan jelas (tidak ambigu)</li>
                        <li>Didukung oleh data yang akurat</li>
                        <li>Dapat diintervensi oleh perawat</li>
                        <li>Menggunakan terminologi SDKI yang tepat</li>
                        <li>Mencerminkan respons pasien, bukan penyakit</li>
                    </ul>
                </div>
                
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-yellow-900 mb-2">⚠️ Kesalahan yang Sering Terjadi</h4>
                    <ul class="list-disc list-inside space-y-1 text-yellow-800">
                        <li>Menggunakan diagnosis medis sebagai diagnosis keperawatan</li>
                        <li>Diagnosis terlalu umum atau tidak spesifik</li>
                        <li>Tidak ada data pendukung yang cukup</li>
                        <li>Format PES statement tidak lengkap</li>
                        <li>Prioritas tidak sesuai dengan kondisi klinis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-advance tips every 10 seconds -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        const tipElements = document.querySelectorAll('[x-data*="currentTip"]');
        tipElements.forEach(element => {
            if (element._x_dataStack && element._x_dataStack[0]) {
                const data = element._x_dataStack[0];
                if (data.tips && data.currentTip !== undefined) {
                    data.currentTip = (data.currentTip + 1) % data.tips.length;
                }
            }
        });
    }, 10000); // 10 seconds
});
</script>
