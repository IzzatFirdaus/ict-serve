@props([
    'href' => null,
    'padding' => 'default',
    'shadow' => 'default',
    'rounded' => 'default',
])

@php
    $tag = $href ? 'a' : 'div';

    $paddingClasses = match($padding) {
        'none' => '',
        'sm' => 'p-4',
        'default' => 'p-6',
        'lg' => 'p-8',
        default => 'p-6'
    };

    $shadowClasses = match($shadow) {
        'none' => '',
        'sm' => 'shadow-sm',
        'default' => 'shadow-md',
        'lg' => 'shadow-lg',
        default => 'shadow-md'
    };

    $roundedClasses = match($rounded) {
        'none' => '',
        'sm' => 'rounded-[var(--radius-m)]',
        'default' => 'rounded-[var(--radius-l)]',
        'lg' => 'rounded-[var(--radius-xl)]',
        default => 'rounded-[var(--radius-l)]'
    };

    $baseClasses = 'bg-white border border-otl-gray-200';
    $hoverClasses = $href ? 'hover:shadow-lg hover:border-otl-gray-300 transition-all duration-200' : '';

    $classes = trim($baseClasses . ' ' . $paddingClasses . ' ' . $shadowClasses . ' ' . $roundedClasses . ' ' . $hoverClasses);
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
    @if($href) {{ $attributes->only(['target', 'rel']) }} @endif
>
    {{ $slot }}
</{{ $tag }}>
