{{--
  ICTServe (iServe) Responsive Nav Link Component
  MYDS & MyGovEA Compliance:
    - Follows MYDS navigation, mobile nav, and link patterns (see MYDS-Design-Overview.md).
    - Typography: Inter, text-base (16px), font-medium, line-height-tight.
    - Colours: Uses MYDS semantic tokens for normal, active, hover, and focus states (see MYDS-Colour-Reference.md).
    - Focus: Visible focus ring using MYDS focus ring token.
    - Accessibility: role="link", aria-current for active, keyboard accessible, ARIA label option.
    - Icon support: Optional slot for leading icon, 20x20 as per MYDS-Icons-Overview.md.
    - Minimal, touch-friendly, accessible, and clear (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
    'href',
    'active' => false,
    'icon' => null,      // Optional: Blade component or SVG for leading icon
    'ariaLabel' => null, // Optional ARIA label for accessibility
])

@php
    $baseClasses = 'flex items-center gap-2 w-full px-4 py-3 rounded-md text-base font-medium transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary';
    $activeClasses = 'bg-primary-50 text-txt-primary';
    $inactiveClasses = 'text-txt-black-900 hover:text-txt-primary hover:bg-bg-gray-50';
@endphp

<a
    href="{{ $href }}"
    role="link"
    @if($active) aria-current="page" @endif
    @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    {{ $attributes->merge([
        'class' => $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses)
    ]) }}
>
    @if($icon)
        <span class="inline-flex items-center w-5 h-5" aria-hidden="true">
            {!! $icon !!}
        </span>
    @endif
    <span class="truncate">{{ $slot }}</span>
</a>
