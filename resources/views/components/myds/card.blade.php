@props([
    'title' => null,
    'variant' => 'default', // default, bordered, elevated
    'padding' => 'normal' // none, small, normal, large
])

@php
    $baseClasses = 'myds-card bg-white';
    
    // Variant classes
    $variantClasses = match($variant) {
        'bordered' => 'border border-gray-200 rounded-lg',
        'elevated' => 'rounded-lg shadow-md',
        default => 'rounded-lg shadow-sm border border-gray-100'
    };
    
    // Padding classes
    $paddingClasses = match($padding) {
        'none' => '',
        'small' => 'p-4',
        'large' => 'p-8',
        default => 'p-6' // normal
    };
    
    $classes = trim($baseClasses . ' ' . $variantClasses . ' ' . $paddingClasses);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($title)
        <div class="myds-card-header mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="myds-card-body">
        {{ $slot }}
    </div>
</div>
