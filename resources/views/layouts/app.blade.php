<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Ionicons -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Admin Styles -->
        <style>
            .shadow-admin { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
            .shadow-admin-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        </style>

        <!-- Global Notification System -->
        <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
        <script>
            window.showNotification = function(options) {
                const container = document.getElementById('notification-container');
                const notification = document.createElement('div');
                
                const typeColors = {
                    success: 'bg-green-500',
                    error: 'bg-red-500',
                    warning: 'bg-yellow-500',
                    info: 'bg-blue-500'
                };
                
                const typeIcons = {
                    success: 'checkmark-circle',
                    error: 'close-circle',
                    warning: 'warning',
                    info: 'information-circle'
                };
                
                notification.className = `${typeColors[options.type]} text-white p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 opacity-0 translate-x-full`;
                notification.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <ion-icon name="${typeIcons[options.type]}" class="text-xl flex-shrink-0 mt-0.5"></ion-icon>
                        <div>
                            <div class="font-semibold">${options.title}</div>
                            <div class="text-sm opacity-90">${options.message}</div>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-white opacity-70 hover:opacity-100">
                            <ion-icon name="close"></ion-icon>
                        </button>
                    </div>
                `;
                
                container.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.classList.remove('opacity-0', 'translate-x-full');
                }, 100);
                
                // Auto remove
                if (options.duration) {
                    setTimeout(() => {
                        notification.classList.add('opacity-0', 'translate-x-full');
                        setTimeout(() => notification.remove(), 300);
                    }, options.duration);
                }
            };
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Professional Navigation -->
        @include('components.professional-navigation')

        <div class="min-h-screen">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
