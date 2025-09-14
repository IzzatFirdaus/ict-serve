@props([
    'status' => 'info', // info, success, warning, danger, primary
    'size' => 'medium', // small, medium, large
    'variant' => 'filled', // filled, outline, subtle
    'icon' => null,
    'dismissible' => false
])

@php
    $baseClasses = 'myds-status-badge inline-flex items-center justify-center font-medium rounded-full';
    
    // Size classes
    $sizeClasses = match($size) {
        'small' => 'px-2 py-0.5 text-xs gap-1',
        'large' => 'px-4 py-2 text-base gap-2',
        default => 'px-3 py-1 text-sm gap-1.5' // medium
    };
    
    // Status and variant classes
    $statusClasses = match($status) {
        'success' => match($variant) {
            'outline' => 'text-green-700 bg-white border border-green-300',
            'subtle' => 'text-green-800 bg-green-50',
            default => 'text-white bg-green-600' // filled
        },
        'warning' => match($variant) {
            'outline' => 'text-yellow-700 bg-white border border-yellow-300',
            'subtle' => 'text-yellow-800 bg-yellow-50',
            default => 'text-yellow-900 bg-yellow-400' // filled
        },
        'danger' => match($variant) {
            'outline' => 'text-red-700 bg-white border border-red-300',
            'subtle' => 'text-red-800 bg-red-50',
            default => 'text-white bg-red-600' // filled
        },
        'primary' => match($variant) {
            'outline' => 'text-blue-700 bg-white border border-blue-300',
            'subtle' => 'text-blue-800 bg-blue-50',
            default => 'text-white bg-blue-600' // filled
        },
        default => match($variant) { // info
            'outline' => 'text-gray-700 bg-white border border-gray-300',
            'subtle' => 'text-gray-800 bg-gray-50',
            default => 'text-gray-800 bg-gray-200' // filled
        }
    };
    
    $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $statusClasses);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span class="myds-badge-icon">
            {!! $icon !!}
        </span>
    @endif
    
    <span class="myds-badge-text">{{ $slot }}</span>
    
    @if($dismissible)
        <button type="button" class="ml-1 hover:opacity-70 transition-opacity" onclick="this.parentElement.remove()">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</span>
