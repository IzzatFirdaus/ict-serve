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

    // MYDS button base classes with proper typography and focus ring
    $baseClasses = 'myds-button inline-flex items-center justify-center rounded-lg font-inter font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-40 disabled:cursor-not-allowed';

    // MYDS size classes with proper spacing scale
    $sizeClasses = match($normalizedSize) {
        'small' => $iconOnly ? 'p-2 text-xs' : 'px-3 py-1.5 text-xs gap-1.5',
        'large' => $iconOnly ? 'p-4 text-base' : 'px-6 py-3 text-base gap-3',
        default => $iconOnly ? 'p-3 text-sm' : 'px-4 py-2.5 text-sm gap-2',
    };

    // MYDS semantic tokens (corrected)
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-300',
        'secondary' => 'bg-white text-black-900 border border-gray-300 hover:bg-gray-50 focus:ring-gray-300',
        'outline' => 'bg-transparent text-black-900 border border-gray-300 hover:bg-gray-50 focus:ring-gray-300',
        'danger' => 'bg-danger-600 text-white hover:bg-danger-700 focus:ring-danger-300',
        'success' => 'bg-success-600 text-white hover:bg-success-700 focus:ring-success-300',
        'warning' => 'bg-warning-600 text-white hover:bg-warning-700 focus:ring-warning-300',
        'ghost' => 'bg-transparent text-black-700 hover:bg-gray-50 focus:ring-gray-300',
        default => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-300',
    };

    if ($disabled || $loading) {
        $variantClasses = 'bg-black-100 text-black-500 border border-gray-200 cursor-not-allowed';
    }

    $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses);
@endphp

@if($href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => $classes]) }}
       role="button"
       @if($disabled || $loading) aria-disabled="true" tabindex="-1" @endif
       @if($loading) aria-busy="true" @endif>
        @if($loading)
            <svg class="animate-spin h-4 w-4 @unless($iconOnly) mr-2 @endunless" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && !$iconOnly)
            <span class="mr-2" aria-hidden="true">{!! $icon !!}</span>
        @elseif($icon && $iconOnly)
            <span aria-hidden="true">{!! $icon !!}</span>
        @endif
        @unless($iconOnly)
            <span>{{ $slot }}</span>
        @endunless
    </a>
@else
    <button type="{{ $type }}"
            {{ $attributes->merge(['class' => $classes]) }}
            @if($disabled) disabled @endif
            @if($loading) aria-busy="true" disabled @endif>
        @if($loading)
            <svg class="animate-spin h-4 w-4 @unless($iconOnly) mr-2 @endunless" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && !$iconOnly)
            <span class="mr-2" aria-hidden="true">{!! $icon !!}</span>
        @elseif($icon && $iconOnly)
            <span aria-hidden="true">{!! $icon !!}</span>
        @endif
        @unless($iconOnly)
            <span>{{ $slot }}</span>
        @endunless
    </button>
@endif
