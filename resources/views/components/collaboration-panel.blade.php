@props(['patientId' => null])

@php
// Simulasi data kolaborasi - dalam implementasi nyata ini dari database
$collaborativeMessages = [
    [
        'id' => 1,
        'from' => 'Dr. Sarah (Dosen Pembimbing)',
        'message' => 'Perhatikan tanda vital pasien ini. Frekuensi napas 28x/menit menunjukkan kemungkinan gangguan pola napas.',
        'timestamp' => '5 menit yang lalu',
        'type' => 'suggestion',
        'avatar' => 'https://ui-avatars.com/api/?name=Dr.+Sarah&background=3b82f6&color=fff'
    ],
    [
        'id' => 2, 
        'from' => 'Ns. Ahmad (Perawat Senior)',
        'message' => 'Untuk diagnosis risiko jatuh, jangan lupa pertimbangkan riwayat jatuh sebelumnya dan penggunaan obat sedatif.',
        'timestamp' => '12 menit yang lalu',
        'type' => 'reminder',
        'avatar' => 'https://ui-avatars.com/api/?name=Ns.+Ahmad&background=10b981&color=fff'
    ]
];

$pendingReviews = 2;
$activeCollaborators = 3;
@endphp

<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6" 
     x-data="{ 
        showCollaboration: false,
        showMessageInput: false,
        newMessage: '',
        messages: @js($collaborativeMessages),
        
        addMessage() {
            if (this.newMessage.trim()) {
                this.messages.unshift({
                    id: Date.now(),
                    from: '{{ auth()->user()->name }} ({{ auth()->user()->isMahasiswa() ? 'Mahasiswa' : (auth()->user()->isDosen() ? 'Dosen' : 'Admin') }})',
                    message: this.newMessage,
                    timestamp: 'Baru saja',
                    type: 'message',
                    avatar: 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff'
                });
                this.newMessage = '';
                this.showMessageInput = false;
                
                // Simulasi notifikasi real-time
                setTimeout(() => {
                    this.$dispatch('show-notification', {
                        type: 'success',
                        message: 'Pesan berhasil dikirim ke tim kolaborasi'
                    });
                }, 500);
            }
        }
     }">
     
    <!-- Collaboration Header -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <div class="bg-purple-100 p-3 rounded-full mr-4">
                <ion-icon name="people" class="text-2xl text-purple-600"></ion-icon>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Kolaborasi Tim</h3>
                <p class="text-sm text-gray-600">{{ $activeCollaborators }} pembimbing online</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <!-- Pending Reviews Badge -->
            @if($pendingReviews > 0)
            <div class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                {{ $pendingReviews }} menunggu review
            </div>
            @endif
            
            <!-- Toggle Collaboration Panel -->
            <button @click="showCollaboration = !showCollaboration"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <ion-icon name="chatbubbles" class="mr-2"></ion-icon>
                <span x-text="showCollaboration ? 'Tutup' : 'Buka'" class="text-sm"></span>
            </button>
        </div>
    </div>
    
    <!-- Quick Status Indicators -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <ion-icon name="checkmark-circle" class="text-2xl text-green-600 mr-3"></ion-icon>
                <div>
                    <div class="text-sm font-medium text-green-900">Status Bimbingan</div>
                    <div class="text-xs text-green-700">Terbimbing Aktif</div>
                </div>
            </div>
        </div>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <ion-icon name="time" class="text-2xl text-yellow-600 mr-3"></ion-icon>
                <div>
                    <div class="text-sm font-medium text-yellow-900">Waktu Respons</div>
                    <div class="text-xs text-yellow-700">Rata-rata 5 menit</div>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <ion-icon name="school" class="text-2xl text-blue-600 mr-3"></ion-icon>
                <div>
                    <div class="text-sm font-medium text-blue-900">Progress Learning</div>
                    <div class="text-xs text-blue-700">75% Complete</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Collaboration Panel -->
    <div x-show="showCollaboration" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 max-h-0"
         x-transition:enter-end="opacity-100 max-h-96"
         class="border-t border-gray-200 pt-4 overflow-hidden">
         
        <!-- Messages Container -->
        <div class="bg-gray-50 rounded-lg p-4 max-h-64 overflow-y-auto mb-4">
            <template x-for="message in messages" :key="message.id">
                <div class="flex items-start mb-4 last:mb-0">
                    <img :src="message.avatar" :alt="message.from" 
                         class="w-8 h-8 rounded-full mr-3 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <div class="text-sm font-medium text-gray-900" x-text="message.from"></div>
                            <div class="text-xs text-gray-500" x-text="message.timestamp"></div>
                        </div>
                        <div class="text-sm text-gray-700 bg-white rounded-lg p-3 shadow-sm" x-text="message.message"></div>
                        
                        <!-- Message Type Indicator -->
                        <div class="mt-2 flex items-center">
                            <template x-if="message.type === 'suggestion'">
                                <span class="inline-flex items-center text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                    <ion-icon name="bulb" class="mr-1"></ion-icon>
                                    Saran
                                </span>
                            </template>
                            <template x-if="message.type === 'reminder'">
                                <span class="inline-flex items-center text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                    <ion-icon name="alarm" class="mr-1"></ion-icon>
                                    Pengingat
                                </span>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
            
            <div x-show="messages.length === 0" class="text-center text-gray-500 py-8">
                <ion-icon name="chatbubble-outline" class="text-4xl mb-2"></ion-icon>
                <p>Belum ada pesan kolaborasi</p>
            </div>
        </div>
        
        <!-- Message Input -->
        <div class="flex items-center space-x-3">
            <div class="flex-1">
                <div x-show="!showMessageInput">
                    <button @click="showMessageInput = true" 
                            class="w-full text-left bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-3 text-gray-500 transition-colors">
                        Tulis pesan atau ajukan pertanyaan...
                    </button>
                </div>
                
                <div x-show="showMessageInput" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <textarea x-model="newMessage" 
                              x-ref="messageInput"
                              @keydown.enter.prevent="addMessage()"
                              @keydown.escape="showMessageInput = false; newMessage = ''"
                              placeholder="Tulis pesan Anda... (Enter untuk kirim, Esc untuk batal)"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 resize-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                              rows="3"></textarea>
                    
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-xs text-gray-500">
                            Pesan akan dikirim ke semua pembimbing yang online
                        </div>
                        <div class="flex items-center space-x-2">
                            <button @click="showMessageInput = false; newMessage = ''" 
                                    class="text-gray-500 hover:text-gray-700 text-sm">
                                Batal
                            </button>
                            <button @click="addMessage()"
                                    :disabled="!newMessage.trim()"
                                    class="bg-purple-600 hover:bg-purple-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center space-x-4 text-sm text-gray-600">
                <button class="flex items-center hover:text-purple-600 transition-colors">
                    <ion-icon name="help-circle-outline" class="mr-1"></ion-icon>
                    Minta Bantuan
                </button>
                <button class="flex items-center hover:text-purple-600 transition-colors">
                    <ion-icon name="bookmark-outline" class="mr-1"></ion-icon>
                    Save untuk Nanti
                </button>
            </div>
            
            <div class="text-xs text-gray-500">
                {{ $activeCollaborators }} pembimbing siap membantu
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh collaboration messages (simulated) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simulasi incoming messages setiap 30 detik
    setInterval(() => {
        if (Math.random() < 0.3) { // 30% chance of new message
            const event = new CustomEvent('new-collaboration-message', {
                detail: {
                    from: 'Dr. ' + ['Sarah', 'Ahmad', 'Lisa', 'Budi'][Math.floor(Math.random() * 4)] + ' (Pembimbing)',
                    message: [
                        'Diagnosis yang dipilih sudah tepat, coba perhatikan prioritasnya.',
                        'Jangan lupa pertimbangkan faktor risiko yang ada.',
                        'Bagus! Format PES statement sudah benar.',
                        'Coba review kembali data assessment pasien.'
                    ][Math.floor(Math.random() * 4)],
                    type: Math.random() < 0.5 ? 'suggestion' : 'reminder'
                }
            });
            window.dispatchEvent(event);
        }
    }, 30000); // 30 seconds
});
</script>
