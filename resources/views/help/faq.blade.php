<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="chatbubble-outline" class="text-2xl text-blue-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">FAQ</h1>
            </div>
            <p class="text-gray-600">Pertanyaan yang sering diajukan tentang sistem dokumentasi keperawatan</p>
        </div>

        <!-- Search Box -->
        <div class="mb-8">
            <div class="relative">
                <ion-icon name="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></ion-icon>
                <input type="text" placeholder="Cari pertanyaan..." class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <!-- FAQ Categories -->
        <div class="space-y-8">
            @foreach($faqs as $category)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $category['category'] }}</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($category['questions'] as $faq)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between" onclick="toggleFaq(this)">
                                <span class="font-medium text-gray-900">{{ $faq['question'] }}</span>
                                <ion-icon name="chevron-down" class="transform transition-transform text-gray-500"></ion-icon>
                            </button>
                            <div class="px-6 py-4 bg-white border-t border-gray-200 hidden">
                                <p class="text-gray-700 leading-relaxed">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact Support -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white text-center">
            <ion-icon name="headset" class="text-5xl mb-4 mx-auto"></ion-icon>
            <h2 class="text-2xl font-bold mb-2">Masih Butuh Bantuan?</h2>
            <p class="text-blue-100 mb-6">Tim support kami siap membantu Anda 24/7</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('help.contact') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors">
                    <ion-icon name="mail" class="mr-2"></ion-icon>
                    Hubungi Support
                </a>
                <button class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-400 transition-colors">
                    <ion-icon name="chatbubbles" class="mr-2"></ion-icon>
                    Live Chat
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('ion-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-dashboard-layout>
