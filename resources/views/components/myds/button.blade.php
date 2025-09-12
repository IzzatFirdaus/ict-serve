@props([
    'variant' => 'primary',
    'size' => 'default',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
])

@php
    $baseClasses = 'myds-button inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variantClasses = match($variant) {
        'primary' => 'myds-button-primary',
        'secondary' => 'myds-button-secondary',
    'danger' => 'bg-danger-600 text-white hover:bg-danger-700 focus:ring-fr-danger',
    'success' => 'bg-success-600 text-white hover:bg-success-700 focus:ring-fr-success',
        'outline' => 'border border-otl-gray-300 text-txt-black-900 hover:bg-gray-50 focus:ring-fr-primary',
        default => 'myds-button-primary'
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'default' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm'
    };

    $classes = $baseClasses . ' ' . $variantClasses . ' ' . $sizeClasses;
@endphp

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif

    {{ $slot }}
</button>
