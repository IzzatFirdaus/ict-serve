{{--
  ICTServe (iServe) Secondary Button Component
  MYDS & MyGovEA Compliance:
    - Uses MYDS "Secondary" button style (MYDS-Design-Overview.md, Button Component).
    - Colour: bg-white, text-txt-primary, border-otl-primary-300, with MYDS-compliant hover/focus/disabled states (MYDS-Colour-Reference.md).
    - Radius: 8px (rounded-md/radius-m).
    - Shadow: shadow-button for subtle elevation.
    - Accessible: Visible focus ring, keyboard navigation, role, ARIA where needed.
    - Icon: Optional leading/trailing icon slot (MYDS-Icons-Overview.md, 20x20, 1.5px stroke).
    - Only semantic tokens, no hardcoded colours.
    - Minimal, clear, consistent, and accessible as per prinsip-reka-bentuk-mygovea.md.
--}}

@props([
    'type' => 'button',
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
        'class' => 'inline-flex items-center gap-2 px-4 py-2 bg-white text-txt-primary font-semibold text-sm rounded-md border border-otl-primary-300 shadow-button
                    hover:bg-primary-50 hover:text-txt-primary focus:bg-primary-50 focus-visible:ring-2 focus-visible:ring-fr-primary
                    transition-colors duration-150 disabled:bg-white-disabled disabled:text-txt-primary-disabled disabled:border-otl-primary-disabled disabled:cursor-not-allowed'
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
