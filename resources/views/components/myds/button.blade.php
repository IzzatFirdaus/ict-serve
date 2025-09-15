@props([
    'variant' => 'primary',
    'size' => 'medium', // small|medium|large or sm|default|md|lg
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'icon' => null, // optional leading icon character/SVG
    'iconOnly' => false,
    'href' => null, // if set, render as anchor
])

@php
    // Normalize size aliases
    $normalizedSize = match($size) {
        'sm', 'small' => 'small',
        'lg', 'large' => 'large',
        'default', 'md', 'medium' => 'medium',
        default => 'medium',
    };

    $baseClasses = 'myds-button inline-flex items-center justify-center rounded-[var(--radius-m)] font-medium transition-colors focus:outline-none focus:ring focus:ring-primary-300 disabled:opacity-60 disabled:cursor-not-allowed';

    $sizeClasses = match($normalizedSize) {
        'small' => $iconOnly ? 'p-2 text-xs' : 'px-3 py-1.5 text-xs gap-1.5',
        'large' => $iconOnly ? 'p-3 text-base' : 'px-6 py-3 text-base gap-3',
        default => $iconOnly ? 'p-2.5 text-sm' : 'px-4 py-2 text-sm gap-2',
    };

    // MYDS semantic tokens
    $variantClasses = match($variant) {
        'primary' => 'bg-bg-primary-600 text-txt-white hover:bg-bg-primary-700',
        'secondary' => 'bg-bg-white text-txt-black-900 border border-otl-gray-300 hover:bg-bg-gray-50',
        'outline' => 'bg-transparent text-txt-black-900 border border-otl-gray-300 hover:bg-bg-gray-50',
        'danger' => 'bg-bg-danger-600 text-txt-white hover:bg-bg-danger-700',
        'success' => 'bg-bg-success-600 text-txt-white hover:bg-bg-success-700',
        'ghost' => 'bg-transparent text-txt-black-700 hover:bg-bg-gray-50',
        default => 'bg-bg-primary-600 text-txt-white hover:bg-bg-primary-700',
    };

    if ($disabled || $loading) {
        $variantClasses = 'bg-bg-black-100 text-txt-black-500 border border-otl-gray-200';
    }

    $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses);
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}
       role="button"
       @if($disabled || $loading) aria-disabled="true" tabindex="-1" @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <span class="mr-2" aria-hidden="true">{!! $icon !!}</span>
        @endif
        @unless($iconOnly)
            <span>{{ $slot }}</span>
        @endunless
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @if($disabled || $loading) disabled aria-disabled="true" aria-busy="true" @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon)
            <span class="mr-2" aria-hidden="true">{!! $icon !!}</span>
        @endif
        @unless($iconOnly)
            <span>{{ $slot }}</span>
        @endunless
    </button>
@endif
