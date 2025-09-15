<x-dashboard-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-2">
                <ion-icon name="mail-outline" class="text-2xl text-blue-600 mr-3"></ion-icon>
                <h1 class="text-3xl font-bold text-gray-900">Hubungi Kami</h1>
            </div>
            <p class="text-gray-600">Dapatkan bantuan dan dukungan dari tim kami</p>
        </div>

        <!-- Contact Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($contacts as $contact)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <ion-icon name="person" class="text-white text-2xl"></ion-icon>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $contact['type'] }}</h3>
                    <p class="text-blue-600 font-medium mb-2">{{ $contact['name'] }}</p>
                    <p class="text-gray-600 text-sm mb-4">{{ $contact['description'] }}</p>
                    
                    <div class="space-y-2">
                        <a href="mailto:{{ $contact['email'] }}" class="flex items-center justify-center text-gray-600 hover:text-blue-600 transition-colors">
                            <ion-icon name="mail" class="mr-2"></ion-icon>
                            {{ $contact['email'] }}
                        </a>
                        <a href="tel:{{ $contact['phone'] }}" class="flex items-center justify-center text-gray-600 hover:text-blue-600 transition-colors">
                            <ion-icon name="call" class="mr-2"></ion-icon>
                            {{ $contact['phone'] }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Kirim Pesan</h2>
                <p class="text-gray-600 text-sm">Kami akan merespon dalam 24 jam</p>
            </div>
            <div class="p-6">
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan email">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Masukkan nomor telepon">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>Masalah Teknis</option>
                                <option>Pertanyaan Umum</option>
                                <option>Saran & Masukan</option>
                                <option>Permintaan Fitur</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Subjek pesan">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="urgent" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="urgent" class="ml-2 text-sm text-gray-700">Tandai sebagai urgent</label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <ion-icon name="paper-plane" class="mr-2"></ion-icon>
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Operating Hours -->
        <div class="mt-12 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Jam Operasional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <ion-icon name="time" class="text-3xl text-green-600 mb-2"></ion-icon>
                    <h3 class="font-semibold text-gray-900">Support Email</h3>
                    <p class="text-gray-600 text-sm">24/7</p>
                </div>
                <div class="text-center">
                    <ion-icon name="call" class="text-3xl text-blue-600 mb-2"></ion-icon>
                    <h3 class="font-semibold text-gray-900">Telepon</h3>
                    <p class="text-gray-600 text-sm">Sen-Jum, 08:00-17:00</p>
                </div>
                <div class="text-center">
                    <ion-icon name="chatbubbles" class="text-3xl text-purple-600 mb-2"></ion-icon>
                    <h3 class="font-semibold text-gray-900">Live Chat</h3>
                    <p class="text-gray-600 text-sm">Sen-Jum, 08:00-17:00</p>
                </div>
                <div class="text-center">
                    <ion-icon name="location" class="text-3xl text-orange-600 mb-2"></ion-icon>
                    <h3 class="font-semibold text-gray-900">Kunjungan</h3>
                    <p class="text-gray-600 text-sm">Berdasarkan jadwal</p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
