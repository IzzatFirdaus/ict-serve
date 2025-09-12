@props(['striped' => true, 'responsive' => true])

@php
$tableClasses = 'min-w-full';
$wrapperClasses = '';

if ($responsive) {
    $wrapperClasses .= ' overflow-x-auto';
}
@endphp

<div class="myds-card overflow-hidden {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
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
    function mydsTableHeader($slot) {
        return "<thead><tr class=\"border-b border-otl-gray-200 dark:border-otl-gray-200\">{$slot}</tr></thead>";
    }
}
@endphp

{{-- Table Header Cell Component (th) --}}
@php
if (!function_exists('mydsTableHeaderCell')) {
    function mydsTableHeaderCell($content, $align = 'left') {
        $alignClass = match($align) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => 'text-left'
        };

        return "<th class=\"px-6 py-4 {$alignClass} text-body-xs font-medium text-txt-black-500 dark:text-txt-black-500 uppercase tracking-wider\" scope=\"col\">{$content}</th>";
    }
}
@endphp

{{-- Table Body Component --}}
@php
if (!function_exists('mydsTableBody')) {
    function mydsTableBody($slot, $striped = true) {
        $classes = $striped ? 'divide-y divide-otl-gray-200 dark:divide-otl-gray-200' : '';
        return "<tbody class=\"{$classes}\">{$slot}</tbody>";
    }
}
@endphp

{{-- Table Row Component --}}
@php
if (!function_exists('mydsTableRow')) {
    function mydsTableRow($slot, $hoverable = true) {
        $classes = $hoverable ? 'hover:bg-bg-white-50 dark:hover:bg-bg-white-50 transition-colors' : '';
        return "<tr class=\"{$classes}\">{$slot}</tr>";
    }
}
@endphp

{{-- Table Cell Component (td) --}}
@php
if (!function_exists('mydsTableCell')) {
    function mydsTableCell($content, $align = 'left') {
        $alignClass = match($align) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => 'text-left'
        };

        return "<td class=\"px-6 py-4 {$alignClass}\">{$content}</td>";
    }
}
@endphp
