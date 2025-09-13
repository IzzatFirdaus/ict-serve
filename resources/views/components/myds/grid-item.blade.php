@props([
    'span' => 'auto', // auto, 1-12 for desktop, supports responsive: sm:6 md:8 lg:12
    'offset' => null, // 0-11, supports responsive
    'order' => null, // 1-12, supports responsive
])

@php
    // Handle span classes (responsive grid columns)
    $spanClasses = match($span) {
        'auto' => 'col-span-full md:col-span-4 lg:col-span-6',
        '1' => 'col-span-1 md:col-span-1 lg:col-span-1',
        '2' => 'col-span-2 md:col-span-1 lg:col-span-2',
        '3' => 'col-span-3 md:col-span-2 lg:col-span-3',
        '4' => 'col-span-4 md:col-span-2 lg:col-span-4',
        '5' => 'col-span-full md:col-span-3 lg:col-span-5',
        '6' => 'col-span-full md:col-span-3 lg:col-span-6',
        '7' => 'col-span-full md:col-span-4 lg:col-span-7',
        '8' => 'col-span-full md:col-span-4 lg:col-span-8',
        '9' => 'col-span-full md:col-span-5 lg:col-span-9',
        '10' => 'col-span-full md:col-span-5 lg:col-span-10',
        '11' => 'col-span-full md:col-span-6 lg:col-span-11',
        '12' => 'col-span-full md:col-span-6 lg:col-span-12',
        'full' => 'col-span-full md:col-span-full lg:col-span-full',
        default => is_string($span) ? $span : 'col-span-full md:col-span-4 lg:col-span-6'
    };

    // Handle offset classes
    $offsetClasses = $offset ? (is_string($offset) ? $offset : "col-start-" . ($offset + 1)) : '';

    // Handle order classes
    $orderClasses = $order ? (is_string($order) ? $order : "order-{$order}") : '';
@endphp

<div {{ $attributes->merge(['class' => "{$spanClasses} {$offsetClasses} {$orderClasses}"]) }}>
    {{ $slot }}
</div>
