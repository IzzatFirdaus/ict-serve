{{--
    MYDS Tag for ICTServe (iServe)
    - Variants: gray | primary | success | warning | danger
    - Sizes: sm|md|lg (via class override if needed)
--}}
@props(['variant' => 'gray'])

@php
    $variantClasses = [
        'gray' => 'bg-black-100 txt-black-700',
        'primary' => 'bg-primary-100 txt-primary',
        'success' => 'bg-success-100 txt-success',
        'warning' => 'bg-warning-100 txt-warning',
        'danger' => 'bg-danger-100 txt-danger',
    ];
    $classes = $variantClasses[$variant] ?? $variantClasses['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-s px-2 py-0.5 text-xs font-medium $classes"]) }}>
    {{ $slot }}
</span>
