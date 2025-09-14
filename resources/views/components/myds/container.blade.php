@props([
    'variant' => 'default', // default, narrow, wide, full
    'padding' => 'default', // none, sm, default, lg, xl
    'centered' => false,
])

@php
    $variantClasses = match($variant) {
        'narrow' => 'max-w-3xl',
        'wide' => 'max-w-6xl',
        'full' => 'max-w-full',
        default => 'max-w-7xl'
    };

    $paddingClasses = match($padding) {
        'none' => '',
        'sm' => 'px-4 py-2',
        'default' => 'px-6 py-4',
        'lg' => 'px-8 py-6',
        'xl' => 'px-12 py-8',
        default => 'px-6 py-4'
    };

    $centeredClasses = $centered ? 'mx-auto' : '';
@endphp

<div {{ $attributes->merge(['class' => "w-full {$variantClasses} {$paddingClasses} {$centeredClasses}"]) }}>
    {{ $slot }}
</div>
