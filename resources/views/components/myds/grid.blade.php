@props([
    'container' => true, // Whether to include MYDS container wrapper
    'type' => 'content', // content, article, full-width
])

@php
    $containerClasses = $container ? 'myds-container' : '';

    $gridClasses = match($type) {
        'article' => 'myds-article', // Max 640px for readability
        'full-width' => 'w-full',
        default => 'myds-grid' // Standard 12-8-4 grid
    };

    $classes = trim($containerClasses . ' ' . $gridClasses);
@endphp

@if($container)
    <div class="{{ $containerClasses }}">
        <div {{ $attributes->merge(['class' => $gridClasses]) }}>
            {{ $slot }}
        </div>
    </div>
@else
    <div {{ $attributes->merge(['class' => $gridClasses]) }}>
        {{ $slot }}
    </div>
@endif
