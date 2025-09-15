@props(['patientId' => null])

<div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-lg p-6 border border-green-200 mb-6" 
     x-data="{ showTutorial: false }">
    
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-3">
                <ion-icon name="school-outline" class="text-2xl text-green-600 mr-3"></ion-icon>
                <h3 class="text-lg font-semibold text-gray-900">Panduan Mahasiswa: Diagnosis Keperawatan</h3>
            </div>
            
            <div class="space-y-3 text-sm text-gray-700">
                <div class="flex items-start">
                    <span class="inline-block w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">1</span>
                    <div>
                        <p class="font-medium">Pilih pasien terlebih dahulu</p>
                        <p class="text-gray-600">Pastikan data assessment pasien sudah lengkap untuk membuat diagnosis yang akurat</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <span class="inline-block w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">2</span>
                    <div>
                        <p class="font-medium">Gunakan kode SDKI yang tepat</p>
                        <p class="text-gray-600">Ketik beberapa huruf untuk mendapat saran diagnosis otomatis berdasarkan SDKI</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <span class="inline-block w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">3</span>
                    <div>
                        <p class="font-medium">Sesuaikan prioritas dengan kondisi klinis</p>
                        <p class="text-gray-600">Tinggi: mengancam jiwa, Sedang: mempengaruhi recovery, Rendah: tidak langsung berbahaya</p>
                    </div>
                </div>
            </div>
        </div>
        
        <button @click="showTutorial = !showTutorial" 
                class="text-blue-600 hover:text-blue-700 transition-colors ml-4">
            <ion-icon name="help-circle-outline" class="text-2xl"></ion-icon>
        </button>
    </div>
    
    <!-- Extended Tutorial -->
    <div x-show="showTutorial" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="mt-4 pt-4 border-t border-green-200">
        
        <h4 class="font-semibold text-gray-900 mb-3">Tutorial Lengkap: Format PES Statement</h4>
        
        <div class="bg-white rounded-lg p-4 space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="bg-red-50 p-3 rounded-lg">
                    <div class="font-semibold text-red-800 mb-2">P - Problem (Masalah)</div>
                    <div class="text-red-700">
                        <p>Diagnosis keperawatan sesuai SDKI</p>
                        <p class="text-xs mt-1 italic">Contoh: "Bersihan Jalan Nafas Tidak Efektif"</p>
                    </div>
                </div>
                
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <div class="font-semibold text-yellow-800 mb-2">E - Etiology (Penyebab)</div>
                    <div class="text-yellow-700">
                        <p>Faktor yang berhubungan dengan masalah</p>
                        <p class="text-xs mt-1 italic">Contoh: "berhubungan dengan spasme jalan nafas"</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-3 rounded-lg">
                    <div class="font-semibold text-blue-800 mb-2">S - Signs/Symptoms (Gejala)</div>
                    <div class="text-blue-700">
                        <p>Karakteristik yang menentukan</p>
                        <p class="text-xs mt-1 italic">Contoh: "ditandai dengan batuk tidak efektif, sputum berlebih"</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-green-50 rounded-lg">
                <div class="font-semibold text-green-800 mb-2">Contoh Diagnosis Lengkap:</div>
                <p class="text-green-700 italic">
                    "Bersihan Jalan Nafas Tidak Efektif berhubungan dengan spasme jalan nafas ditandai dengan batuk tidak efektif, sputum berlebih, dan wheezing."
                </p>
            </div>
        </div>
    </div>
    
    @if($patientId)
    <!-- Patient-Specific Recommendations -->
    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
        <div class="flex items-center mb-2">
            <ion-icon name="person-outline" class="text-blue-600 mr-2"></ion-icon>
            <span class="font-medium text-blue-900">Rekomendasi untuk Pasien Ini</span>
        </div>
        <div class="text-sm text-blue-800">
            <p>Berdasarkan data assessment yang tersedia, pertimbangkan diagnosis berikut:</p>
            <div class="mt-2 space-y-1">
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                    <span>Cek riwayat penyakit dan keluhan utama</span>
                </div>
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                    <span>Analisis data objektif dan subjektif</span>
                </div>
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                    <span>Prioritaskan masalah berdasarkan hierarki Maslow</span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
