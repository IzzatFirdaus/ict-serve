@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'size' => 'default',
    'showLabel' => true,
    'label' => null,
])

@php
    $percentage = min(($value / $max) * 100, 100);

    $variantClasses = match($variant) {
        'primary' => 'bg-primary-600',
        'success' => 'bg-success-600',
        'warning' => 'bg-warning-600',
        'danger' => 'bg-danger-600',
        default => 'bg-primary-600'
    };

    $sizeClasses = match($size) {
        'sm' => 'h-2',
        'default' => 'h-3',
        'lg' => 'h-4',
        default => 'h-3'
    };

    $displayLabel = $label ?? ($percentage . '%');
@endphp

<div {{ $attributes }}>
    @if($showLabel)
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-txt-black-900">{{ $displayLabel }}</span>
            @if(!$label)
                <span class="text-sm text-txt-black-500">{{ round($percentage, 1) }}%</span>
            @endif
        </div>
    @endif

    <div class="w-full bg-gray-200 rounded-full {{ $sizeClasses }}">
        <div
            class="{{ $variantClasses }} {{ $sizeClasses }} rounded-full transition-all duration-300 ease-out"
            style="width: {{ $percentage }}%"
            role="progressbar"
            aria-valuenow="{{ $value }}"
            aria-valuemin="0"
            aria-valuemax="{{ $max }}"
            aria-label="Progress: {{ round($percentage, 1) }}%"
        ></div>
    </div>
</div>
