{{--
  ICTServe (iServe) Dropdown Link Component
  MYDS & MyGovEA Compliance:
  - Uses MYDS Dropdown Menu Item pattern (see MYDS-Design-Overview.md, Dropdown Component).
  - Colours: bg-white (default), bg-gray-50 (hover/focus), txt-black-700 (default), txt-primary (active/focus) [see MYDS-Colour-Reference.md].
  - Typography: Inter, text-sm, font-medium, line-height-tight (MYDS body text).
  - Radius: rounded-md (8px, MYDS radius-m).
  - Spacing: px-4 py-2 (MYDS spacing system).
  - Accessibility: focus-visible ring, role="menuitem", tab focus, clear hover/focus state.
  - Minimal, clear, accessible following MYGOVEA (prinsip-reka-bentuk-mygovea.md).
--}}

@props(['active' => false])

@php
  $baseClasses =
    'block w-full px-4 py-2 text-start text-sm font-medium leading-tight rounded-md transition-colors duration-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary';
  $stateClasses = $active
    ? 'bg-primary-100 text-txt-primary'
    : 'text-txt-black-700 hover:bg-gray-50 focus:bg-gray-50 hover:text-txt-primary focus:text-txt-primary';
@endphp

<a
  role="menuitem"
  tabindex="0"
  {{ $attributes->merge(['class' => $baseClasses . ' ' . $stateClasses]) }}
>
  {{ $slot }}
</a>
