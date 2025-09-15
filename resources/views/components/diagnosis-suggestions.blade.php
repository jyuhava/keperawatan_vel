@props(['field', 'suggestions' => []])

<div class="relative" x-data="{ 
    showSuggestions: false, 
    selectedIndex: -1,
    suggestions: @js($suggestions),
    filteredSuggestions: @js($suggestions),
    query: '',
    
    filterSuggestions() {
        if (this.query.length === 0) {
            this.filteredSuggestions = this.suggestions;
            return;
        }
        
        this.filteredSuggestions = this.suggestions.filter(item => 
            item.title.toLowerCase().includes(this.query.toLowerCase()) ||
            item.code.toLowerCase().includes(this.query.toLowerCase())
        );
    },
    
    selectSuggestion(suggestion) {
        document.querySelector('input[name=\'{{ $field }}\']').value = suggestion.code;
        if (suggestion.title) {
            const titleField = document.querySelector('textarea[name=\'diagnosis\']');
            if (titleField) titleField.value = suggestion.title;
        }
        if (suggestion.factors) {
            const factorsField = document.querySelector('textarea[name=\'related_factors\']');
            if (factorsField) factorsField.value = suggestion.factors;
        }
        if (suggestion.characteristics) {
            const charField = document.querySelector('textarea[name=\'defining_characteristics\']');
            if (charField) charField.value = suggestion.characteristics;
        }
        this.showSuggestions = false;
        this.selectedIndex = -1;
    }
}">
    
    {{ $slot }}
    
    <!-- Suggestions Dropdown -->
    <div x-show="showSuggestions && filteredSuggestions.length > 0" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-96 overflow-y-auto">
         
        <div class="p-2 border-b border-gray-200 bg-blue-50">
            <div class="flex items-center text-sm text-blue-800">
                <ion-icon name="bulb-outline" class="mr-2"></ion-icon>
                <span class="font-medium">Saran Diagnosis SDKI</span>
            </div>
        </div>
        
        <div class="py-1">
            <template x-for="(suggestion, index) in filteredSuggestions" :key="suggestion.code">
                <div @click="selectSuggestion(suggestion)"
                     :class="{ 'bg-blue-50': selectedIndex === index }"
                     class="px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100">
                    
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs font-mono px-2 py-1 rounded"
                                      x-text="suggestion.code"></span>
                                <span class="ml-2 text-sm font-medium text-gray-900" x-text="suggestion.title"></span>
                            </div>
                            
                            <div class="mt-2 text-xs text-gray-600">
                                <div class="mb-1" x-show="suggestion.definition">
                                    <span class="font-medium">Definisi:</span>
                                    <span x-text="suggestion.definition"></span>
                                </div>
                                <div class="mb-1" x-show="suggestion.factors">
                                    <span class="font-medium">Faktor terkait:</span>
                                    <span x-text="suggestion.factors"></span>
                                </div>
                                <div x-show="suggestion.characteristics">
                                    <span class="font-medium">Karakteristik:</span>
                                    <span x-text="suggestion.characteristics"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="ml-3 flex items-center">
                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded">
                                {{ auth()->user()->isMahasiswa() ? 'Cocok' : 'Disarankan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <div x-show="filteredSuggestions.length === 0" class="p-4 text-center text-gray-500">
            <ion-icon name="search-outline" class="text-2xl mb-2"></ion-icon>
            <p class="text-sm">Tidak ada diagnosis yang sesuai dengan pencarian</p>
        </div>
    </div>
</div>

<script>
// Enhanced SDKI Suggestions with more comprehensive data
window.sdkiSuggestions = [
    {
        code: 'D.0001',
        title: 'Bersihan Jalan Nafas Tidak Efektif',
        definition: 'Ketidakmampuan membersihkan sekret atau obstruksi dari saluran pernafasan untuk mempertahankan jalan nafas tetap paten',
        factors: 'Spasme jalan nafas, hipersekresi jalan nafas, disfungsi neuromuskular, benda asing dalam jalan nafas, adanya jalan nafas buatan, sekresi yang tertahan, hiperplasia dinding jalan nafas, proses infeksi, respon alergi, efek agen farmakologis',
        characteristics: 'Batuk tidak efektif, tidak mampu batuk, sputum berlebih, mengi (wheezing), sulit vokalisasi, ortopnea, cyanosis, gelisah, pola nafas terganggu, bunyi nafas tambahan, frekuensi nafas berubah'
    },
    {
        code: 'D.0002',
        title: 'Pola Nafas Tidak Efektif',
        definition: 'Inspirasi dan/atau ekspirasi yang tidak memberikan ventilasi adekuat',
        factors: 'Depresi pusat pernafasan, hambatan upaya nafas, deformitas dinding dada, deformitas tulang dada, gangguan neuromuskular, gangguan neurologis, imaturitas neurologis, penurunan energi, keletihan otot pernafasan, posisi tubuh yang menghambat ekspansi paru, sindrom hipoventilasi, cedera pada medula spinalis, efek agen farmakologis',
        characteristics: 'Dispnea, nafas pendek, bradipnea, takipnea, pola nafas abnormal, penggunaan otot bantu pernafasan, fase ekspirasi memanjang, pernafasan cuping hidung, diameter thoraks anterior-posterior meningkat, ventilasi semenit menurun, kapasitas vital menurun, tekanan ekspirasi menurun, tekanan inspirasi menurun, ortopnea'
    },
    {
        code: 'D.0005',
        title: 'Risiko Aspirasi',
        definition: 'Berisiko mengalami aspirasi sekret gastrointestinal, sekret orofaring, benda padat atau cairan ke dalam tracheobronchial',
        factors: 'Penurunan tingkat kesadaran, disfagia, gangguan menelan, peningkatan residu lambung, peningkatan tekanan intragastrik, penurunan motilitas gastrointestinal, makanan melalui selang, pemberian makanan melalui selang, incompetent lower esophageal sphincter, peningkatan produksi asam lambung, penurunan refleks batuk, penurunan refleks gag, trauma atau pembedahan mulut, leher atau wajah, situasi yang menghambat elevasi tubuh bagian atas, wiring rahang, tracheostomy atau endotracheal tube, efek agen farmakologis',
        characteristics: 'Faktor risiko'
    },
    {
        code: 'D.0011',
        title: 'Defisit Perawatan Diri',
        definition: 'Ketidakmampuan melakukan atau menyelesaikan aktivitas perawatan diri',
        factors: 'Kelemahan, kelelahan, gangguan muskuloskeletal, gangguan neuromuskular, gangguan kognitif, gangguan perceptual, cemas berat, gangguan motivasi, nyeri, hambatan lingkungan, kerusakan integritas kulit, efek agen farmakologis',
        characteristics: 'Tidak mampu mandi secara mandiri, tidak mampu mengenakan pakaian secara mandiri, tidak mampu merawat tubuh secara mandiri, tidak mampu menggunakan toilet secara mandiri, tidak mampu makan secara mandiri'
    },
    {
        code: 'D.0017',
        title: 'Gangguan Mobilitas Fisik',
        definition: 'Keterbatasan dalam gerakan fisik tubuh atau satu atau lebih ekstremitas secara mandiri dan terarah',
        factors: 'Gangguan metabolisme, gangguan sirkulasi, kekakuan sendi, kontraktur, malnutrisi, kehilangan integritas struktur tulang, gangguan kognitif, indeks massa tubuh diatas persentil ke-75 sesuai usia, kurang terpapar informasi tentang aktivitas fisik, gangguan sensori persepsi, tidak nyaman, nyeri, program pembatasan gerak, kekuatan otot menurun, massa otot menurun, kekakuan otot, gangguan koordinasi, reluctant untuk memulai gerakan, gaya hidup kurang gerak, malaise, keengganan melakukan pergerakan, efek agen farmakologis',
        characteristics: 'Mengeluh sulit menggerakkan ekstremitas, mengeluh tidak nyaman saat bergerak, enggan melakukan pergerakan, membatasi rentang gerak, gerakan tidak terkoordinasi, gerakan terbatas, kekuatan otot menurun, kendali otot menurun, massa otot menurun, tremor yang diinduksi gerakan, gerakan lambat, postural instability'
    },
    {
        code: 'D.0021',
        title: 'Gangguan Pertukaran Gas',
        definition: 'Kelebihan atau kekurangan oksigenasi dan/atau eliminasi karbondioksida pada membran alveolar-kapiler',
        factors: 'Ketidakseimbangan rasio ventilasi-perfusi, perubahan membran alveolar-kapiler',
        characteristics: 'Dispnea, nafas cuping hidung, pola nafas abnormal, warna kulit abnormal, konfusi, diaphoresis, gelisah, somnolen, iritabilitas, headache saat bangun, takikardia, hiperkapnia, hipoksemia, hipoksia, PCO2 meningkat, PO2 menurun, pH arteri abnormal, sianosis'
    },
    {
        code: 'D.0029',
        title: 'Risiko Jatuh',
        definition: 'Berisiko mengalami jatuh yang dapat menyebabkan bahaya fisik',
        factors: 'Usia > 65 tahun, usia < 2 tahun, riwayat jatuh, penggunaan alat bantu, penyakit akut, anemia, arthritis, gangguan pendengaran, gangguan keseimbangan, gangguan mobilitas, hipoglikemia, hipotensi ortostatik, gangguan penglihatan, neuropati, pusing saat miring atau menoleh, kondisi pasca operasi, kehamilan, inkontinensia, gangguan tidur, efek agen farmakologis, penggunaan alas kaki yang tidak tepat, lingkungan tidak familiar, pencahayaan tidak adekuat, lantai basah, lantai licin, ruang terbatas atau berantakan, tempat tidur tinggi, tidak ada pegangan/handrail, kursi roda tidak terkunci',
        characteristics: 'Faktor risiko'
    },
    {
        code: 'D.0056',
        title: 'Nyeri Akut',
        definition: 'Pengalaman sensorik atau emosional yang berkaitan dengan kerusakan jaringan aktual atau fungsional, dengan onset mendadak atau lambat dan berintensitas ringan hingga berat yang berlangsung kurang dari 3 bulan',
        factors: 'Agen pencedera fisiologis, agen pencedera kimiawi, agen pencedera fisik',
        characteristics: 'Mengeluh nyeri, tampak meringis, bersikap protektif/melindungi area nyeri, gelisah, frekuensi nadi meningkat, sulit tidur, diaforesis, nafsu makan menurun, tekanan darah meningkat, pola nafas berubah, proses pikir terganggu, menarik diri, berfokus pada diri sendiri, dielektrik pupil'
    }
];
</script>
