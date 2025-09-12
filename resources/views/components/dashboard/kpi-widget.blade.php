@props([
    'title',
    'value',
    'icon' => 'chart-bar',
    'color' => 'primary',
])

@php
    $colors = [
        'primary' => 'bg-primary-100 text-primary-700',
        'success' => 'bg-success-100 text-success-700',
        'warning' => 'bg-warning-100 text-warning-700',
        'info' => 'bg-blue-100 text-blue-700',
    ];
    $iconMap = [
        'device' => 'device-tablet',
        'clipboard-list' => 'clipboard-list',
        'support' => 'life-buoy',
        'check-circle' => 'check-circle',
        'chart-bar' => 'chart-bar',
    ];
@endphp

<div class="bg-white rounded-lg shadow flex items-center p-6">
    <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center rounded-full {{ $colors[$color] ?? $colors['primary'] }} mr-4">
        <x-icon :name="$iconMap[$icon] ?? 'chart-bar'" class="w-8 h-8" />
    </div>
    <div>
        <div class="text-2xl font-bold">{{ $value }}</div>
        <div class="text-sm text-gray-600">{{ $title }}</div>
    </div>
</div>
