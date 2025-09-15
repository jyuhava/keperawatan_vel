@props(['type' => 'info', 'icon' => 'information-circle-outline'])

@php
$classes = match($type) {
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'tip' => 'bg-blue-50 border-blue-200 text-blue-800',
    default => 'bg-gray-50 border-gray-200 text-gray-800'
};

$iconClasses = match($type) {
    'success' => 'text-green-600',
    'warning' => 'text-yellow-600',
    'error' => 'text-red-600',
    'tip' => 'text-blue-600',
    default => 'text-gray-600'
};
@endphp

<div class="border rounded-lg p-4 {{ $classes }}">
    <div class="flex items-start">
        <ion-icon name="{{ $icon }}" class="text-xl {{ $iconClasses }} mr-3 mt-0.5 flex-shrink-0"></ion-icon>
        <div class="flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
