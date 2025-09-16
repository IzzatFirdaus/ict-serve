@props([
    'variant' => 'primary', // primary, secondary, secondary-colour, tertiary, tertiary-colour, danger-primary, danger-secondary, danger-tertiary
    'size' => 'medium', // small, medium, large
    'type' => 'button', // button, submit, reset
    'disabled' => false,
    'loading' => false,
    'iconLeading' => null,
    'iconTrailing' => null,
    'counter' => null,
    'iconOnly' => false
])

@php
    $baseClasses = 'myds-button relative inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';

    // Size classes
    $sizeClasses = match($size) {
        'small' => 'px-3 py-1.5 text-sm gap-1.5',
        'large' => 'px-6 py-3 text-lg gap-3',
        'default' => 'px-4 py-2 text-sm',
        default => 'px-4 py-2 text-sm' // medium
    };

    // Icon-only sizing
    if ($iconOnly) {
        $sizeClasses = match($size) {
            'small' => 'p-1.5',
            'large' => 'p-3',
            default => 'p-2'
        };
    }

    // Variant classes based on MYDS specifications using semantic tokens
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-600 text-white border border-primary-600 hover:bg-primary-700 hover:border-primary-700 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5',
        'secondary' => 'bg-white text-gray-900 border border-otl-gray-300 hover:bg-gray-50 hover:border-otl-gray-400 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5',
        'secondary-colour' => 'bg-primary-50 text-primary-700 border border-primary-200 hover:bg-primary-100 hover:border-primary-300 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5',
        'tertiary' => 'bg-transparent text-gray-700 border-0 hover:bg-gray-100 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5',
        'tertiary-colour' => 'bg-transparent text-primary-600 border-0 hover:bg-primary-50 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5',
        'danger-primary' => 'bg-danger-600 text-white border border-danger-600 hover:bg-danger-700 hover:border-danger-700 focus:ring-danger-300 focus:ring-offset-2 active:translate-y-0.5',
        'danger-secondary' => 'bg-white text-danger-700 border border-danger-300 hover:bg-danger-50 hover:border-danger-400 focus:ring-danger-300 focus:ring-offset-2 active:translate-y-0.5',
        'danger-tertiary' => 'bg-transparent text-danger-600 border-0 hover:bg-danger-50 focus:ring-danger-300 focus:ring-offset-2 active:translate-y-0.5',
        'danger' => 'bg-danger-600 text-white hover:bg-danger-700 focus:ring-danger-300 focus:ring-offset-2',
        'success' => 'bg-success-600 text-white hover:bg-success-700 focus:ring-success-300 focus:ring-offset-2',
        'warning' => 'bg-warning-600 text-white hover:bg-warning-700 focus:ring-warning-300 focus:ring-offset-2',
        'outline' => 'border border-otl-gray-300 text-gray-900 hover:bg-gray-50 focus:ring-primary-300 focus:ring-offset-2',
        default => 'bg-primary-600 text-white border border-primary-600 hover:bg-primary-700 hover:border-primary-700 focus:ring-primary-300 focus:ring-offset-2 active:translate-y-0.5'
    };

    // Disabled state
    if ($disabled || $loading) {
        $variantClasses = 'bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed active:translate-y-0';
    }

    $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses);
@endphp

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($iconLeading)
        <span class="myds-button-icon-leading">
            {!! $iconLeading !!}
        </span>
    @endif

    @unless($iconOnly)
        <span class="myds-button-text">{{ $slot }}</span>
    @endunless

    @if($counter)
        <span class="myds-button-counter ml-1 px-1.5 py-0.5 text-xs bg-white/20 rounded-full">
            {{ $counter }}
        </span>
    @endif

    @if($iconTrailing && !$loading)
        <span class="myds-button-icon-trailing">
            {!! $iconTrailing !!}
        </span>
    @endif
</button>

