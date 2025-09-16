@props(['striped' => true, 'responsive' => true, 'variant' => 'default'])

@php
$tableClasses = 'min-w-full font-inter';

$wrapperVariants = [
    'default' => 'bg-white dark:bg-dialog border border-divider rounded-lg overflow-hidden',
    'plain' => 'overflow-hidden',
    'card' => 'bg-white dark:bg-dialog border border-divider rounded-lg shadow-sm overflow-hidden',
];

$wrapperClass = $wrapperVariants[$variant] ?? $wrapperVariants['default'];
@endphp

<div class="{{ $wrapperClass }} {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
    @if($responsive)
        <div class="overflow-x-auto">
    @endif

    <table class="{{ $tableClasses }}" role="table">
        {{ $slot }}
    </table>

    @if($responsive)
        </div>
    @endif
</div>

{{-- Table Header Component --}}
@php
if (!function_exists('mydsTableHeader')) {
    function mydsTableHeader($slot, $variant = 'default') {
        $classes = match($variant) {
            'dark' => 'bg-black-100 dark:bg-black-800',
            'light' => 'bg-washed dark:bg-black-50',
            default => 'bg-gray-50 dark:bg-black-100'
        };
        
        return "<thead class=\"{$classes}\"><tr class=\"border-b border-divider\">{$slot}</tr></thead>";
    }
}
@endphp

{{-- Table Header Cell Component (th) --}}
@php
if (!function_exists('mydsTableHeaderCell')) {
    function mydsTableHeaderCell($content, $align = 'left', $sortable = false) {
        $alignClass = match($align) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => 'text-left'
        };

        $baseClasses = "px-6 py-3 {$alignClass} font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider";
        
        if ($sortable) {
            $baseClasses .= " cursor-pointer hover:text-primary-600 dark:hover:text-primary-400 select-none";
        }

        return "<th class=\"{$baseClasses}\" scope=\"col\">{$content}</th>";
    }
}
@endphp

{{-- Table Body Component --}}
@php
if (!function_exists('mydsTableBody')) {
    function mydsTableBody($slot, $striped = true) {
        $classes = 'bg-white dark:bg-dialog';
        if ($striped) {
            $classes .= ' divide-y divide-divider';
        }
        return "<tbody class=\"{$classes}\">{$slot}</tbody>";
    }
}
@endphp

{{-- Table Row Component --}}
@php
if (!function_exists('mydsTableRow')) {
    function mydsTableRow($slot, $hoverable = true, $clickable = false) {
        $classes = '';
        
        if ($hoverable) {
            $classes .= 'hover:bg-washed dark:hover:bg-black-100 transition-colors duration-150';
        }
        
        if ($clickable) {
            $classes .= ' cursor-pointer';
        }
        
        return "<tr class=\"{$classes}\">{$slot}</tr>";
    }
}
@endphp

{{-- Table Cell Component (td) --}}
@php
if (!function_exists('mydsTableCell')) {
    function mydsTableCell($content, $align = 'left', $variant = 'default') {
        $alignClass = match($align) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => 'text-left'
        };

        $textClass = match($variant) {
            'primary' => 'font-inter text-sm font-medium text-black-900 dark:text-white',
            'secondary' => 'font-inter text-sm text-black-500 dark:text-black-400',
            'muted' => 'font-inter text-xs text-black-400 dark:text-black-500',
            default => 'font-inter text-sm text-black-700 dark:text-black-300'
        };

        return "<td class=\"px-6 py-4 {$alignClass} {$textClass}\">{$content}</td>";
    }
}
@endphp
