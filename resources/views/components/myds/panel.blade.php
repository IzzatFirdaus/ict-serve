@props(['variant' => 'default', 'title' => null])

@php
$variantClasses = [
    'default' => 'bg-bg-white-0 border-otl-gray-200',
    'info' => 'bg-primary-25 border-primary-200',
    'warning' => 'bg-warning-25 border-warning-200',
    'danger' => 'bg-danger-25 border-danger-200',
    'success' => 'bg-success-25 border-success-200'
];

$classes = 'rounded-lg border p-6 md:p-8 ' . ($variantClasses[$variant] ?? $variantClasses['default']);
@endphp

<div class="{{ $classes }} {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
    @if($title)
        <h2 class="text-heading-xs font-semibold text-txt-black-900 dark:text-txt-black-900 mb-6">
            {{ $title }}
        </h2>
    @endif

    {{ $slot }}
</div>
