@props([
    'responsive' => true,
    'container' => true,
    'maxWidth' => 'full', // xs, sm, md, lg, xl, 2xl, full
    'padding' => 'default', // none, sm, default, lg
    'variant' => 'default', // default, narrow, wide
])

@php
    $responsiveClasses = $responsive ? 'grid-cols-4 md:grid-cols-8 lg:grid-cols-12' : 'grid-cols-12';

    $containerClasses = $container ? 'container mx-auto' : '';

    $maxWidthClasses = match($maxWidth) {
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        'full' => 'max-w-full',
        default => 'max-w-full'
    };

    $paddingClasses = match($padding) {
        'none' => '',
        'sm' => 'px-4 py-2',
        'default' => 'px-6 py-4',
        'lg' => 'px-8 py-6',
        default => 'px-6 py-4'
    };

    $variantClasses = match($variant) {
        'narrow' => 'max-w-4xl',
        'wide' => 'max-w-full',
        default => 'max-w-7xl'
    };
@endphp

<div {{ $attributes->merge(['class' => "grid gap-6 {$responsiveClasses} {$containerClasses} {$maxWidthClasses} {$paddingClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</div>
