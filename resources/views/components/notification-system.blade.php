<div x-data="notificationSystem" 
     x-init="init()"
     class="fixed top-4 right-4 z-50 space-y-2"
     @show-notification.window="showNotification($event.detail)">
     
    <template x-for="notification in notifications" :key="notification.id">
        <div x-show="notification.show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full scale-95"
             x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 transform translate-x-full scale-95"
             :class="{
                'bg-green-50 border-green-200 text-green-800': notification.type === 'success',
                'bg-red-50 border-red-200 text-red-800': notification.type === 'error',
                'bg-yellow-50 border-yellow-200 text-yellow-800': notification.type === 'warning',
                'bg-blue-50 border-blue-200 text-blue-800': notification.type === 'info',
                'bg-purple-50 border-purple-200 text-purple-800': notification.type === 'collaboration'
             }"
             class="max-w-sm w-full border rounded-lg shadow-lg p-4 relative">
             
            <div class="flex items-start">
                <!-- Icon -->
                <div class="flex-shrink-0 mr-3">
                    <template x-if="notification.type === 'success'">
                        <ion-icon name="checkmark-circle" class="text-xl text-green-600"></ion-icon>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <ion-icon name="alert-circle" class="text-xl text-red-600"></ion-icon>
                    </template>
                    <template x-if="notification.type === 'warning'">
                        <ion-icon name="warning" class="text-xl text-yellow-600"></ion-icon>
                    </template>
                    <template x-if="notification.type === 'info'">
                        <ion-icon name="information-circle" class="text-xl text-blue-600"></ion-icon>
                    </template>
                    <template x-if="notification.type === 'collaboration'">
                        <ion-icon name="people" class="text-xl text-purple-600"></ion-icon>
                    </template>
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm" x-text="notification.title"></div>
                    <div class="text-sm mt-1" x-text="notification.message"></div>
                    
                    <!-- Action buttons if provided -->
                    <div x-show="notification.actions && notification.actions.length > 0" class="mt-3 flex space-x-2">
                        <template x-for="action in (notification.actions || [])" :key="action.label">
                            <button @click="handleAction(action, notification)"
                                    :class="{
                                        'bg-green-600 hover:bg-green-700 text-white': notification.type === 'success',
                                        'bg-red-600 hover:bg-red-700 text-white': notification.type === 'error',
                                        'bg-yellow-600 hover:bg-yellow-700 text-white': notification.type === 'warning',
                                        'bg-blue-600 hover:bg-blue-700 text-white': notification.type === 'info',
                                        'bg-purple-600 hover:bg-purple-700 text-white': notification.type === 'collaboration'
                                    }"
                                    class="px-3 py-1 text-xs font-medium rounded transition-colors"
                                    x-text="action.label">
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- Close button -->
                <button @click="hideNotification(notification.id)" 
                        class="flex-shrink-0 ml-2 text-gray-400 hover:text-gray-600 transition-colors">
                    <ion-icon name="close" class="text-lg"></ion-icon>
                </button>
            </div>
            
            <!-- Progress bar for auto-dismiss -->
            <div x-show="notification.duration && notification.duration > 0"
                 class="absolute bottom-0 left-0 h-1 bg-current opacity-30 transition-all"
                 :style="`width: ${((notification.duration - notification.elapsed) / notification.duration) * 100}%`">
            </div>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('notificationSystem', () => ({
        notifications: [],
        nextId: 1,
        
        init() {
            // Listen for global notification events
            window.addEventListener('show-notification', (event) => {
                this.showNotification(event.detail);
            });
            
            // Listen for collaboration messages
            window.addEventListener('new-collaboration-message', (event) => {
                this.showNotification({
                    type: 'collaboration',
                    title: 'Pesan Kolaborasi Baru',
                    message: `Dari ${event.detail.from}: ${event.detail.message.substring(0, 50)}...`,
                    duration: 8000,
                    actions: [
                        { label: 'Lihat', action: 'view-message', data: event.detail },
                        { label: 'Balas', action: 'reply-message', data: event.detail }
                    ]
                });
            });
            
            // Simulate real-time notifications for demo
            this.startSimulation();
        },
        
        showNotification({ type = 'info', title = '', message = '', duration = 5000, actions = [] }) {
            const id = this.nextId++;
            const notification = {
                id,
                type,
                title,
                message,
                duration,
                actions,
                show: true,
                elapsed: 0
            };
            
            this.notifications.push(notification);
            
            // Auto-dismiss if duration is set
            if (duration > 0) {
                const startTime = Date.now();
                const interval = setInterval(() => {
                    notification.elapsed = Date.now() - startTime;
                    if (notification.elapsed >= duration) {
                        this.hideNotification(id);
                        clearInterval(interval);
                    }
                }, 100);
            }
        },
        
        hideNotification(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.show = false;
                // Remove from array after animation
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 300);
            }
        },
        
        handleAction(action, notification) {
            switch (action.action) {
                case 'view-message':
                    // Open collaboration panel or message details
                    console.log('View message:', action.data);
                    break;
                case 'reply-message':
                    // Focus on message input
                    console.log('Reply to message:', action.data);
                    break;
                case 'review-submission':
                    // Navigate to review page
                    window.location.href = '/reviews/' + action.data.submissionId;
                    break;
            }
            this.hideNotification(notification.id);
        },
        
        startSimulation() {
            // Demo: Simulate various notifications
            setTimeout(() => {
                this.showNotification({
                    type: 'success',
                    title: 'Diagnosis Tersimpan',
                    message: 'Diagnosis keperawatan berhasil disimpan dan siap untuk review',
                    duration: 4000
                });
            }, 3000);
            
            setTimeout(() => {
                this.showNotification({
                    type: 'collaboration',
                    title: 'Bantuan Tersedia',
                    message: 'Dr. Sarah tersedia untuk membantu dengan diagnosis',
                    duration: 8000,
                    actions: [
                        { label: 'Chat', action: 'start-chat', data: { teacher: 'Dr. Sarah' } }
                    ]
                });
            }, 8000);
            
            setTimeout(() => {
                this.showNotification({
                    type: 'info',
                    title: 'Tips Pembelajaran',
                    message: 'Jangan lupa gunakan format PES untuk diagnosis yang tepat',
                    duration: 6000
                });
            }, 15000);
        }
    }));
});

// Helper function to show notifications from anywhere
window.showNotification = function(options) {
    window.dispatchEvent(new CustomEvent('show-notification', { detail: options }));
};

// Quick notification helpers
window.showSuccess = (message, title = 'Berhasil') => {
    window.showNotification({ type: 'success', title, message });
};

window.showError = (message, title = 'Error') => {
    window.showNotification({ type: 'error', title, message });
};

window.showWarning = (message, title = 'Peringatan') => {
    window.showNotification({ type: 'warning', title, message });
};

window.showInfo = (message, title = 'Informasi') => {
    window.showNotification({ type: 'info', title, message });
};
</script>
