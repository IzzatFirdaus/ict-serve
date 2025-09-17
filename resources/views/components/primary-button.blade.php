{{--
  ICTServe (iServe) Primary Button Component
  MYDS & MyGovEA Compliance:
    - Uses MYDS "Primary" button style (see MYDS-Design-Overview.md, Button Component).
    - Colours: bg-primary-600, txt-white, hover/focus states, focus ring (see MYDS-Colour-Reference.md).
    - Radius: 8px (rounded-md/radius-m), as per MYDS.
    - Accessible: Visible focus ring, keyboard navigation, role, ARIA where needed.
    - Icon: Optional leading/trailing icon slot (see MYDS-Icons-Overview.md, 20x20, 1.5px stroke).
    - Only semantic tokens, no hardcoded colours.
    - Minimal, clear, consistent, and accessible as per prinsip-reka-bentuk-mygovea.md.
--}}

@props([
    'type' => 'submit',
    'disabled' => false,
    'icon' => null,           // Optional: Blade component or SVG for leading icon
    'iconRight' => null,      // Optional: Blade component or SVG for trailing icon
    'ariaLabel' => null,
])

<button
    type="{{ $type }}"
    @if($disabled) disabled aria-disabled="true" @endif
    @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white font-semibold text-sm rounded-md shadow-button
                    hover:bg-primary-700 focus:bg-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary
                    transition-colors duration-150 disabled:bg-primary-200 disabled:text-white disabled:cursor-not-allowed'
    ]) }}
>
    @if($icon)
        <span class="inline-flex items-center mr-2" aria-hidden="true">
            {!! $icon !!}
        </span>
    @endif
    <span>{{ $slot }}</span>
    @if($iconRight)
        <span class="inline-flex items-center ml-2" aria-hidden="true">
            {!! $iconRight !!}
        </span>
    @endif
</button>
