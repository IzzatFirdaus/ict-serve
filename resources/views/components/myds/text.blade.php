@props([
    'size' => 'base',
    'variant' => 'default',
    'weight' => 'normal',
    'spacing' => 'default',
])

@php
    $sizeClasses = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'base' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-base'
    };

    $variantClasses = match($variant) {
        'primary' => 'text-txt-primary',
        'secondary' => 'text-txt-black-700',
        'muted' => 'text-txt-black-500',
        'danger' => 'text-txt-danger',
        'success' => 'text-txt-success',
        'warning' => 'text-txt-warning',
        'white' => 'text-txt-white',
        default => 'text-txt-black-900'
    };

    $weightClasses = match($weight) {
        'light' => 'font-light',
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'semibold' => 'font-semibold',
        'bold' => 'font-bold',
        default => 'font-normal'
    };

    $spacingClasses = match($spacing) {
        'none' => 'mb-0',
        'tight' => 'mb-2',
        'default' => 'mb-4',
        'loose' => 'mb-6',
        default => 'mb-4'
    };
@endphp

<p {{ $attributes->merge(['class' => "font-inter {$sizeClasses} {$variantClasses} {$weightClasses} {$spacingClasses} leading-relaxed"]) }}>
    {{ $slot }}
</p>

{{-- Add font loading styles if not already included --}}
@once
<style>
    .font-inter {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
</style>
@endonce
