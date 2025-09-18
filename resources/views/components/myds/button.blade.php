@props([
    /**
     * Button visual style (MYDS standard).
     * Options: primary, secondary, secondary-colour, tertiary, tertiary-colour, danger-primary, danger-secondary, danger-tertiary
     */
    'variant' => 'primary',

    /**
     * Button size
     * Options: small, medium, large
     */
    'size' => 'medium',

    /**
     * Button type (button, submit, reset)
     */
    'type' => 'button',

    /**
     * Disabled state
     */
    'disabled' => false,

    /**
     * Loading state (shows spinner, disables interaction)
     */
    'loading' => false,

    /**
     * Icon (SVG or HTML) before button text
     */
    'iconLeading' => null,

    /**
     * Icon (SVG or HTML) after button text
     */
    'iconTrailing' => null,

    /**
     * Show only the icon (no text)
     */
    'iconOnly' => false,

    /**
     * Small numeric counter badge (e.g. filter count)
     */
    'counter' => null,
])

@php
/**
 * MYDS Button base classes: rounded, focus, transition, font.
 * Always use semantic tokens for bg/txt/otl.
 */
$baseClasses = 'myds-button relative inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-fr-primary';

/**
 * MYDS variant classes (colours from MYDS-Colour-Reference.md)
 */
$variantClasses = match($variant) {
    'primary' => 'myds-button-primary',
    'secondary' => 'myds-button-secondary',
    'secondary-colour' => 'myds-button-secondary-colour',
    'tertiary' => 'myds-button-tertiary',
    'tertiary-colour' => 'myds-button-tertiary-colour',
    'danger-primary' => 'myds-button-danger-primary',
    'danger-secondary' => 'myds-button-danger-secondary',
    'danger-tertiary' => 'myds-button-danger-tertiary',
    default => 'myds-button-primary',
};

/**
 * MYDS size classes (padding, font, gap)
 */
$sizeClasses = match($size) {
    'small' => 'myds-btn-sm px-3 py-1.5 text-xs gap-1.5',
    'large' => 'myds-btn-lg px-6 py-3 text-lg gap-3',
    default => 'myds-btn-md px-4 py-2 text-base gap-2',
};

/**
 * Icon-only variant (button is a circle/rounded, no text)
 */
if ($iconOnly) {
    $sizeClasses = match($size) {
        'small' => 'p-1.5',
        'large' => 'p-3',
        default => 'p-2',
    };
}

/**
 * Disabled/Loading state
 * - Always use semantic tokens for disabled
 * - Pointer and opacity muted, focus ring
 */
if ($disabled || $loading) {
    $variantClasses = 'myds-button-disabled bg-bg-white-disabled text-txt-black-disabled border border-otl-divider cursor-not-allowed opacity-50 pointer-events-none';
}

/**
 * Merge all classes
 */
$classes = trim("$baseClasses $variantClasses $sizeClasses");
@endphp

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes, 'aria-disabled' => ($disabled || $loading) ? 'true' : 'false']) }}
>
    {{-- Loading Spinner (MYDS spec: left, always visible, icon takes place of iconLeading) --}}
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 w-4 h-4 text-current" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($iconLeading)
        <span class="myds-button-icon-leading flex items-center mr-2">
            {!! $iconLeading !!}
        </span>
    @endif

    {{-- Button text slot, only if not iconOnly --}}
    @unless($iconOnly)
        <span class="myds-button-text">{{ $slot }}</span>
    @endunless

    {{-- Counter badge (MYDS: right of text, small, rounded) --}}
    @if($counter)
        <span class="myds-button-counter ml-1 px-1.5 py-0.5 text-xs bg-white/20 rounded-full">
            {{ $counter }}
        </span>
    @endif

    {{-- Trailing icon, if present and not loading --}}
    @if($iconTrailing && !$loading)
        <span class="myds-button-icon-trailing flex items-center ml-2">
            {!! $iconTrailing !!}
        </span>
    @endif
</button>

{{--
    === MYDS Button Component Reference ===
    - Variant: primary, secondary, secondary-colour, tertiary, tertiary-colour, danger-primary, danger-secondary, danger-tertiary
    - Size: small, medium, large
    - Supports: leading/trailing icon, counter, loading spinner, icon-only
    - Follows: MYDS colour & spacing tokens, focus ring, accessible disabled state
    - ARIA: aria-disabled when disabled/loading
    - Icon: SVG, 20x20, 1.5px stroke, in line with MYDS-Icons-Overview.md
--}}
