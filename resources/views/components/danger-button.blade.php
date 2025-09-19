{{--
  ICTServe (iServe) Danger Button Component
  MYDS & MyGovEA Compliance:
  - Uses MYDS "Danger Primary" button style (see MYDS-Design-Overview.md, Button Component).
  - Colours: bg-danger-600, txt-white, hover/focus states (see MYDS-Colour-Reference.md).
  - Radius: 8px (rounded-md/radius-m), consistent with MYDS.
  - Accessible: Visible focus ring, role, and keyboard navigation.
  - Icon: Leading/trailing icon slot support (see MYDS-Icons-Overview.md).
  - Minimal, consistent, accessible (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
  'type' => 'submit',
  'icon' => null, // Optional: Pass Blade component or SVG for leading icon
  'iconRight' => null, // Optional: Pass Blade component or SVG for trailing icon
  'disabled' => false,
  'ariaLabel' => null,
])

<button
  type="{{ $type }}"
  @if($disabled) disabled aria-disabled="true" @endif
  @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
  {{
    $attributes->merge([
      'class' => 'inline-flex items-center gap-2 px-4 py-2 bg-danger-600 text-white font-semibold text-sm rounded-md shadow-button
                            hover:bg-danger-700 focus:bg-danger-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-danger
                            transition-colors duration-150 disabled:bg-danger-200 disabled:text-white disabled:cursor-not-allowed',
    ])
  }}
>
  @if ($icon)
    <span class="inline-flex items-center mr-2" aria-hidden="true">
      {!! $icon !!}
    </span>
  @endif

  <span>{{ $slot }}</span>
  @if ($iconRight)
    <span class="inline-flex items-center ml-2" aria-hidden="true">
      {!! $iconRight !!}
    </span>
  @endif
</button>
