
@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-otl-primary-200 text-start text-base font-medium text-txt-primary bg-bg-primary-50 focus:outline-none focus:text-txt-primary focus:bg-bg-primary-100 focus:border-otl-primary-300 transition-colors duration-150'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-txt-black-600 hover:text-txt-primary hover:bg-bg-gray-50 hover:border-otl-gray-300 focus:outline-none focus:text-txt-primary focus:bg-bg-gray-50 focus:border-otl-gray-300 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
