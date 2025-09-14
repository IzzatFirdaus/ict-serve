@props([
    'level' => 1,
    'size' => null, // Override automatic sizing
    'weight' => 'semibold',
    'variant' => 'default',
    'spacing' => 'default',
])

@php
    // Default sizes for heading levels following MYDS typography scale
    $defaultSize = match($level) {
        1 => 'text-4xl md:text-5xl lg:text-6xl',
        2 => 'text-3xl md:text-4xl lg:text-5xl',
        3 => 'text-2xl md:text-3xl lg:text-4xl',
        4 => 'text-xl md:text-2xl lg:text-3xl',
        5 => 'text-lg md:text-xl lg:text-2xl',
        6 => 'text-base md:text-lg lg:text-xl',
        default => 'text-2xl md:text-3xl lg:text-4xl'
    };

    $sizeClasses = $size ?? $defaultSize;

    $weightClasses = match($weight) {
        'light' => 'font-light',
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'semibold' => 'font-semibold',
        'bold' => 'font-bold',
        'extrabold' => 'font-extrabold',
        default => 'font-semibold'
    };

    $variantClasses = match($variant) {
        'primary' => 'text-txt-primary',
        'secondary' => 'text-txt-black-700',
        'muted' => 'text-txt-black-500',
        'danger' => 'text-txt-danger',
        'success' => 'text-txt-success',
        'warning' => 'text-txt-warning',
        default => 'text-txt-black-900'
    };

    $spacingClasses = match($spacing) {
        'none' => 'mb-0',
        'tight' => 'mb-2',
        'default' => 'mb-4',
        'loose' => 'mb-6',
        'extra-loose' => 'mb-8',
        default => 'mb-4'
    };

    $headingTag = "h{$level}";
@endphp

<{{ $headingTag }} {{ $attributes->merge(['class' => "font-poppins {$sizeClasses} {$weightClasses} {$variantClasses} {$spacingClasses} leading-tight tracking-tight"]) }}>
    {{ $slot }}
</{{ $headingTag }}>

{{-- Add font loading styles if not already included --}}
@once
<style>
    .font-poppins {
        font-family: 'Poppins', system-ui, -apple-system, sans-serif;
    }
</style>
@endonce
