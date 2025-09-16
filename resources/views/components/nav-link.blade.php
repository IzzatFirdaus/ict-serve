
@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center border-b-2 border-primary-600 text-sm font-inter font-medium text-primary-600 focus:outline-none focus:border-primary-300 transition-colors duration-150'
        : 'inline-flex items-center border-b-2 border-transparent text-sm font-inter font-medium text-black-500 hover:text-primary-600 hover:border-primary-300 focus:outline-none focus:text-primary-600 focus:border-primary-300 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
