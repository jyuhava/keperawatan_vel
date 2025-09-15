@props(['field', 'rules' => []])

<div x-data="{ 
    isValid: null, 
    message: '', 
    isValidating: false,
    
    async validateField(value) {
        if (!value) {
            this.isValid = null;
            this.message = '';
            return;
        }
        
        this.isValidating = true;
        
        // Simulate real-time validation (in real app, this would be an API call)
        await new Promise(resolve => setTimeout(resolve, 300));
        
        const rules = @js($rules);
        
        // SDKI Code validation
        if ('{{ $field }}' === 'sdki_code') {
            const sdkiPattern = /^D\.\d{4}$/;
            if (!sdkiPattern.test(value)) {
                this.isValid = false;
                this.message = 'Format kode SDKI harus: D.0001 (D diikuti titik dan 4 digit angka)';
            } else if (!window.sdkiSuggestions?.find(s => s.code === value)) {
                this.isValid = false;
                this.message = 'Kode SDKI tidak ditemukan dalam database';
            } else {
                this.isValid = true;
                this.message = 'Kode SDKI valid dan tersedia';
            }
        }
        
        // Diagnosis validation
        if ('{{ $field }}' === 'diagnosis') {
            if (value.length < 10) {
                this.isValid = false;
                this.message = 'Diagnosis terlalu singkat. Gunakan format PES statement yang lengkap.';
            } else if (!value.includes('berhubungan dengan') && !value.includes('ditandai dengan')) {
                this.isValid = false;
                this.message = 'Gunakan format PES: Problem + berhubungan dengan + ditandai dengan';
            } else {
                this.isValid = true;
                this.message = 'Format diagnosis sudah sesuai dengan PES statement';
            }
        }
        
        // Priority validation
        if ('{{ $field }}' === 'priority') {
            const validPriorities = ['tinggi', 'sedang', 'rendah'];
            if (!validPriorities.includes(value)) {
                this.isValid = false;
                this.message = 'Prioritas harus dipilih: Tinggi, Sedang, atau Rendah';
            } else {
                this.isValid = true;
                this.message = 'Prioritas telah dipilih dengan tepat';
            }
        }
        
        this.isValidating = false;
    }
}"
@validation-field-changed.window="
    if ($event.detail.field === '{{ $field }}') {
        validateField($event.detail.value);
    }
">
    
    {{ $slot }}
    
    <!-- Real-time Validation Feedback -->
    <div class="mt-2" x-show="isValidating || isValid !== null">
        <!-- Loading State -->
        <div x-show="isValidating" class="flex items-center text-sm text-gray-600">
            <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-600 border-t-transparent mr-2"></div>
            <span>Memvalidasi...</span>
        </div>
        
        <!-- Success State -->
        <div x-show="!isValidating && isValid === true" 
             class="flex items-center text-sm text-green-600 bg-green-50 px-3 py-2 rounded-lg">
            <ion-icon name="checkmark-circle" class="text-lg mr-2"></ion-icon>
            <span x-text="message"></span>
        </div>
        
        <!-- Error State -->
        <div x-show="!isValidating && isValid === false" 
             class="flex items-center text-sm text-red-600 bg-red-50 px-3 py-2 rounded-lg">
            <ion-icon name="alert-circle" class="text-lg mr-2"></ion-icon>
            <span x-text="message"></span>
        </div>
    </div>
</div>

<script>
// Helper function to trigger validation across components
function triggerValidation(field, value) {
    window.dispatchEvent(new CustomEvent('validation-field-changed', {
        detail: { field: field, value: value }
    }));
}
</script>
