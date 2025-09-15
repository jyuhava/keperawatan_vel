@props(['type' => 'info', 'dismissible' => true])

@php
$typeClasses = [
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800', 
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    'collaboration' => 'bg-purple-50 border-purple-200 text-purple-800'
];

$iconMap = [
    'success' => 'checkmark-circle',
    'warning' => 'warning',
    'error' => 'alert-circle', 
    'info' => 'information-circle',
    'collaboration' => 'people'
];
@endphp

<div x-data="{ show: true }" 
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"  
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="border rounded-lg p-4 mb-4 {{ $typeClasses[$type] ?? $typeClasses['info'] }}">
     
    <div class="flex items-start justify-between">
        <div class="flex items-start flex-1">
            <ion-icon name="{{ $iconMap[$type] ?? $iconMap['info'] }}" class="text-xl mr-3 mt-0.5 flex-shrink-0"></ion-icon>
            <div class="flex-1">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
        <button @click="show = false" class="ml-4 text-current opacity-50 hover:opacity-75 transition-opacity">
            <ion-icon name="close" class="text-lg"></ion-icon>
        </button>
        @endif
    </div>
</div>
