@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'loading' => false])

@php
$baseClasses = 'myds-btn';
$sizeClasses = [
    'sm' => 'myds-btn-sm',
    'md' => 'myds-btn-md',
    'lg' => 'myds-btn-lg'
];
$variantClasses = [
    'primary' => 'myds-btn-primary',
    'secondary' => 'myds-btn-secondary',
    'tertiary' => 'myds-btn-tertiary',
    'danger' => 'myds-btn-danger',
    'success' => 'myds-btn-success'
];

$classes = $baseClasses . ' ' . ($sizeClasses[$size] ?? 'myds-btn-md') . ' ' . ($variantClasses[$variant] ?? 'myds-btn-primary');
@endphp

<button
    type="{{ $type }}"
    class="{{ $classes }} {{ $attributes->get('class') }}"
    {{ $attributes->except('class') }}
    @if($loading) disabled @endif
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Processing...</span>
    @else
        {{ $slot }}
    @endif
</button>
