@props(['currentStep' => 1])

<div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 mb-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Proses Keperawatan</h3>
        <div class="text-sm text-gray-500">Step {{ $currentStep }} of 5</div>
    </div>
    
    <div class="flex items-center">
        <!-- Step 1: Assessment -->
        <div class="flex items-center {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
            <div class="flex items-center justify-center w-10 h-10 {{ $currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full">
                @if($currentStep > 1)
                    <ion-icon name="checkmark" class="text-lg"></ion-icon>
                @else
                    1
                @endif
            </div>
            <span class="ml-3 text-sm font-medium">Pengkajian</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 1 ? 'bg-blue-600' : 'bg-gray-300' }} mx-4"></div>
        
        <!-- Step 2: Diagnosis -->
        <div class="flex items-center {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
            <div class="flex items-center justify-center w-10 h-10 {{ $currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full">
                @if($currentStep > 2)
                    <ion-icon name="checkmark" class="text-lg"></ion-icon>
                @else
                    2
                @endif
            </div>
            <span class="ml-3 text-sm font-medium">Diagnosis</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 2 ? 'bg-blue-600' : 'bg-gray-300' }} mx-4"></div>
        
        <!-- Step 3: Planning -->
        <div class="flex items-center {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
            <div class="flex items-center justify-center w-10 h-10 {{ $currentStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full">
                @if($currentStep > 3)
                    <ion-icon name="checkmark" class="text-lg"></ion-icon>
                @else
                    3
                @endif
            </div>
            <span class="ml-3 text-sm font-medium">Perencanaan</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 3 ? 'bg-blue-600' : 'bg-gray-300' }} mx-4"></div>
        
        <!-- Step 4: Implementation -->
        <div class="flex items-center {{ $currentStep >= 4 ? 'text-blue-600' : 'text-gray-400' }}">
            <div class="flex items-center justify-center w-10 h-10 {{ $currentStep >= 4 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full">
                @if($currentStep > 4)
                    <ion-icon name="checkmark" class="text-lg"></ion-icon>
                @else
                    4
                @endif
            </div>
            <span class="ml-3 text-sm font-medium">Implementasi</span>
        </div>
        
        <!-- Connector -->
        <div class="flex-1 h-0.5 {{ $currentStep > 4 ? 'bg-blue-600' : 'bg-gray-300' }} mx-4"></div>
        
        <!-- Step 5: Evaluation -->
        <div class="flex items-center {{ $currentStep >= 5 ? 'text-blue-600' : 'text-gray-400' }}">
            <div class="flex items-center justify-center w-10 h-10 {{ $currentStep >= 5 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} rounded-full">
                @if($currentStep > 5)
                    <ion-icon name="checkmark" class="text-lg"></ion-icon>
                @else
                    5
                @endif
            </div>
            <span class="ml-3 text-sm font-medium">Evaluasi</span>
        </div>
    </div>
    
    <!-- Progress Bar -->
    <div class="mt-4">
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ ($currentStep / 5) * 100 }}%"></div>
        </div>
        <div class="mt-2 text-sm text-gray-600 text-center">
            {{ round(($currentStep / 5) * 100) }}% selesai
        </div>
    </div>
</div>
