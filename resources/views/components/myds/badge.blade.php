@props([
    'variant' => 'default',
    'size' => 'default',
    'pill' => false,
])

@php
    $variantClasses = match($variant) {
        'primary' => 'bg-primary-100 text-txt-primary border-otl-primary-200',
        'secondary' => 'bg-gray-100 text-txt-black-700 border-otl-gray-200',
        'success' => 'bg-success-100 text-txt-success border-otl-success-200',
        'warning' => 'bg-warning-100 text-txt-warning border-otl-warning-200',
        'danger' => 'bg-danger-100 text-txt-danger border-otl-danger-200',
        'default' => 'bg-gray-100 text-txt-black-700 border-otl-gray-200',
        default => 'bg-gray-100 text-txt-black-700 border-otl-gray-200'
    };

    $sizeClasses = match($size) {
        'sm' => 'px-2 py-1 text-xs',
        'default' => 'px-2.5 py-1.5 text-sm',
        'lg' => 'px-3 py-2 text-base',
        default => 'px-2.5 py-1.5 text-sm'
    };

    $shapeClasses = $pill ? 'rounded-full' : 'rounded-[var(--radius-m)]';

    $classes = 'inline-flex items-center font-medium border ' . $variantClasses . ' ' . $sizeClasses . ' ' . $shapeClasses;
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
