@props([
    'title',
    'value',
    'icon' => 'chart', // Default icon type
    'color' => 'primary', // Semantic color: primary, success, warning, danger
])

@php
    // Semantic colour tokens (MYDS, light/dark handled by CSS framework/theme)
    $colorVariants = [
        'primary' => 'bg-primary-100 text-primary-700',
        'success' => 'bg-success-100 text-success-700',
        'warning' => 'bg-warning-100 text-warning-700',
        'danger'  => 'bg-danger-100 text-danger-700',
    ];

    // Accessible icon map (MYDS outline style, 20x20 grid, 1.5px stroke)
    $iconMap = [
        'device' => '<svg aria-hidden="true" focusable="false" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="14" height="10" rx="2"/><path d="M8 17h4"/><path d="M10 14v3"/></svg>',
        'clipboard' => '<svg aria-hidden="true" focusable="false" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="4" width="10" height="12" rx="2"/><path d="M9 3h2a1 1 0 0 1 1 1v2H8V4a1 1 0 0 1 1-1z"/></svg>',
        'support' => '<svg aria-hidden="true" focusable="false" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="8"/><circle cx="10" cy="10" r="4"/></svg>',
        'check' => '<svg aria-hidden="true" focusable="false" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle cx="10" cy="10" r="8"/><path d="M7 11l2 2 4-4"/></svg>',
        'chart' => '<svg aria-hidden="true" focusable="false" class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="11" width="3" height="6" rx="1"/><rect x="8.5" y="7" width="3" height="10" rx="1"/><rect x="14" y="4" width="3" height="13" rx="1"/></svg>',
        // Add more icons as needed (use MYDS outline, 20x20 grid, 1.5 stroke)
    ];

    // Fallbacks
    $colorClass = $colorVariants[$color] ?? $colorVariants['primary'];
    $iconSvg = $iconMap[$icon] ?? $iconMap['chart'];
@endphp

<!-- KPI Widget: Accessible, semantic, responsive, MYDS-compliant -->
<div
    class="bg-white rounded-lg border border-otl-divider p-6 flex items-center gap-4 shadow-card"
    role="region"
    aria-label="{{ $title }}"
>
    <!-- Icon Circle: Ensures sufficient color contrast and focus ring on keyboard tab -->
    <div
        class="flex-shrink-0 w-14 h-14 flex items-center justify-center rounded-full {{ $colorClass }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-fr-primary transition-shadow"
        tabindex="0"
        aria-hidden="true"
    >
        {!! $iconSvg !!}
    </div>
    <!-- KPI Value and Label -->
    <div class="flex flex-col">
        <span class="font-poppins text-2xl font-semibold text-txt-black-900 leading-tight" aria-live="polite">
            {{ $value }}
        </span>
        <span class="font-inter text-sm text-txt-black-700 mt-1">
            {{ $title }}
        </span>
    </div>
</div>
