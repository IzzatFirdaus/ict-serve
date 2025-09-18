@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'size' => 'default',
    'showLabel' => true,
    'label' => null,
])
{{--
    MYDS Progress Bar for ICTServe (iServe)
    - Accessible (role=progressbar), token-based colours, sizes.
    - Props:
            value: current value (number)
            max: max value (number)
            variant: primary | success | warning | danger
            size: sm | md | lg
            showLabel: bool
            label: optional custom label
--}}
@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'size' => 'md',
    'showLabel' => true,
    'label' => null,
])

@php
    $safeMax = max(1, (float) $max);
    $pct = max(0, min(100, ($value / $safeMax) * 100));

    $barColor = match($variant) {
        'success' => 'bg-success-600',
        'warning' => 'bg-warning-600',
        'danger' => 'bg-danger-600',
        default => 'bg-primary-600',
    };

    $height = match($size) {
        'sm' => 'h-2',
        'lg' => 'h-4',
        default => 'h-3',
    };

    $trackClass = "bg-black-200 rounded-full {$height}";
    $barClass = "{$barColor} {$height} rounded-full transition-all duration-300 ease-out";
    $displayLabel = $label ?? (number_format($pct, 0) . '%');
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($showLabel)
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium txt-black-900">{{ $displayLabel }}</span>
            @if(!$label)
                <span class="text-sm txt-black-500">{{ number_format($pct, 1) }}%</span>
            @endif
        </div>
    @endif

    <div class="{{ $trackClass }}" aria-hidden="true">
        <div
            class="{{ $barClass }}"
            style="width: {{ number_format($pct, 2) }}%;"
            role="progressbar"
            aria-valuenow="{{ (int) $value }}"
            aria-valuemin="0"
            aria-valuemax="{{ (int) $safeMax }}"
            aria-valuetext="{{ number_format($pct, 1) }} peratus"
        ></div>
    </div>
</div>

@php
    $percentage = min(($value / $max) * 100, 100);

    $variantClasses = match($variant) {
           'primary' => 'bg-bg-primary-600',
           'success' => 'bg-bg-success-600',
           'warning' => 'bg-bg-warning-600',
           'danger' => 'bg-bg-danger-600',
           default => 'bg-bg-primary-600'
    };

    $sizeClasses = match($size) {
        'sm' => 'h-2',
        'default' => 'h-3',
        'lg' => 'h-4',
        default => 'h-3'
    };

    $displayLabel = $label ?? ($percentage . '%');
@endphp

<div {{ $attributes }} x-data="{ pct: {{ round($percentage, 2) }} }">
    @if($showLabel)
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-txt-black-900">{{ $displayLabel }}</span>
            @if(!$label)
                <span class="text-sm text-txt-black-500">{{ round($percentage, 1) }}%</span>
            @endif
        </div>
    @endif

    <div class="w-full bg-black-200 rounded-full {{ $sizeClasses }}">
        <div
            class="{{ $variantClasses }} {{ $sizeClasses }} rounded-full transition-all duration-300 ease-out"
            :style="{ width: pct + '%' }"
            role="progressbar"
            aria-valuenow="{{ $value }}"
            aria-valuemin="0"
            aria-valuemax="{{ $max }}"
            aria-label="Progress: {{ round($percentage, 1) }}%"
        ></div>
    </div>
</div>
