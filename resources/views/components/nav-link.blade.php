{{--
  ICTServe (iServe) Nav Link Component
  MYDS & MyGovEA Compliance:
  - Follows MYDS navigation and link patterns (see MYDS-Design-Overview.md).
  - Typography: Inter, text-sm, font-medium.
  - Colour: Uses MYDS text tokens for normal, active, and hover states (see MYDS-Colour-Reference.md).
  - Focus: Visible focus ring using MYDS focus ring tokens.
  - Accessibility: role="link", aria-current for active, keyboard accessible.
  - Icon support: Optional leading icon slot, sized 20x20 as per MYDS-Icons-Overview.md.
  - Minimal, clear, citizen-centric (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
  'href',
  'active' => false,
  'icon' => null,
  'ariaLabel' => null, // Optional: ARIA label for accessibility
])

@php
  $baseClasses =
    'inline-flex items-center gap-2 px-3 py-2 rounded-md font-medium text-sm transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary';
  $activeClasses = 'bg-primary-50 text-txt-primary';
  $inactiveClasses =
    'text-txt-black-700 hover:text-txt-primary hover:bg-bg-gray-50';
@endphp

<a
  href="{{ $href }}"
  role="link"
  @if($active) aria-current="page" @endif
  @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
  {{
    $attributes->merge([
      'class' => $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses),
    ])
  }}
>
  @if ($icon)
    <span class="inline-flex items-center" aria-hidden="true">
      {!! $icon !!}
    </span>
  @endif

  <span>{{ $slot }}</span>
</a>
