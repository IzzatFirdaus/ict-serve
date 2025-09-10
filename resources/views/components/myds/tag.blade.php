@props(['variant' => 'gray'])

@php
$variantClasses = [
    'gray' => 'myds-tag-gray',
    'primary' => 'myds-tag-primary',
    'success' => 'myds-tag-success',
    'warning' => 'myds-tag-warning',
    'danger' => 'myds-tag-danger'
];
@endphp

<span class="myds-tag {{ $variantClasses[$variant] ?? 'myds-tag-gray' }}">
    {{ $slot }}
</span>
