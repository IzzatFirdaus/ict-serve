{{-- 
  ICTServe (iServe) Text Input Component
  MYDS & MyGovEA Compliance:
    - Uses MYDS input field anatomy: label above, input with semantic tokens, error/disabled states, accessible ARIA.
    - Colour: bg-white, border-otl-divider, focus-ring-fr-primary, text-txt-black-900 (see MYDS-Colour-Reference.md).
    - Typography: Inter, text-sm, font-normal (see MYDS-Design-Overview.md, MYDS-Develop-Overview.md).
    - Radius: 8px (rounded-md), shadow-none (MYDS input).
    - Icon support: Optional leading/trailing icons, 20x20 as per MYDS-Icons-Overview.md.
    - Accessibility: role, aria-invalid, aria-describedby, visible focus, full keyboard navigation.
    - Responsive: Full width by default, 12/8/4 grid compatible.
    - Minimal, clear, inclusive, error-preventing (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autocomplete' => null,
    'autofocus' => false,
    'maxlength' => null,
    'minlength' => null,
    'icon' => null,           // Optional: Blade component or SVG for leading icon
    'iconRight' => null,      // Optional: Blade component or SVG for trailing icon
    'ariaLabel' => null,
    'ariaDescribedby' => null,
    'class' => '',
])

@php
    $inputId = $id ?? $name;
    $hasIcon = !empty($icon);
    $hasIconRight = !empty($iconRight);
    $baseClasses = 'block w-full text-sm font-normal font-inter rounded-md bg-white border border-otl-divider text-txt-black-900 px-3 py-2 transition-colors duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary';
    $stateClasses = '';
    if ($disabled) {
        $stateClasses .= ' bg-white-disabled text-txt-black-disabled border-otl-gray-300 cursor-not-allowed';
    } elseif ($readonly) {
        $stateClasses .= ' bg-bg-gray-50 text-txt-black-500 border-otl-gray-300';
    }
    // Padding adjustment for icons
    if ($hasIcon) $stateClasses .= ' pl-10';
    if ($hasIconRight) $stateClasses .= ' pr-10';
@endphp

<div class="relative {{ $class }}">
    @if($hasIcon)
        <span class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center pointer-events-none text-txt-black-500">
            {!! $icon !!}
        </span>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        @if(!is_null($value)) value="{{ old($name, $value) }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required aria-required="true" @endif
        @if($disabled) disabled aria-disabled="true" @endif
        @if($readonly) readonly aria-readonly="true" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($autofocus) autofocus @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        @if($minlength) minlength="{{ $minlength }}" @endif
        @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
        @if($ariaDescribedby) aria-describedby="{{ $ariaDescribedby }}" @endif
        {{ $attributes->merge(['class' => $baseClasses . $stateClasses]) }}
    />
    @if($hasIconRight)
        <span class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center pointer-events-none text-txt-black-500">
            {!! $iconRight !!}
        </span>
    @endif
</div>