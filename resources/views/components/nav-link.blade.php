
@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center border-b-2 border-otl-primary-200 text-sm font-medium text-txt-primary focus:outline-none focus:border-otl-primary-300 transition-colors duration-150'
        : 'inline-flex items-center border-b-2 border-transparent text-sm font-medium text-txt-black-500 hover:text-txt-primary hover:border-otl-primary-200 focus:outline-none focus:text-txt-primary focus:border-otl-primary-200 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
