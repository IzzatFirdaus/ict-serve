{{--
  MYDS Input Field for ICTServe (iServe)
  - Conforms to MYDS standards (Design, Develop, Icons, Colour) and MyGovEA (Citizen-Centric, Hierarki, Minimalis, Seragam).
  - Features: label on top, error/hint below, semantic tokens, leading/trailing icon support, clear focus, a11y.
  - Props:
      id: string (required)
      label: string|null
      hint: string|null
      error: string|null
      value: string|null
      required: bool
      disabled: bool
      type: string ('text', 'email', etc.)
      placeholder: string|null
      size: 'sm'|'md'|'lg'
      icon: Blade/SVG|null (leading icon)
      trailingIcon: Blade/SVG|null (trailing icon)
      autocomplete: string|null
      inputmode: string|null
      class: string|null
--}}

@props([
  'id',
  'label' => null,
  'hint' => null,
  'error' => null,
  'value' => null,
  'required' => false,
  'disabled' => false,
  'type' => 'text',
  'placeholder' => null,
  'size' => 'md',
  'icon' => null,
  'trailingIcon' => null,
  'autocomplete' => null,
  'inputmode' => null,
  'class' => '',
])

@php
  // Sizing and spacing tokens per MYDS
  $sizeClass = match($size) {
    'sm' => 'myds-input-sm',
    'lg' => 'myds-input-lg',
    default => 'myds-input-md',
  };
  $isInvalid = filled($error);
  $invalidClass = $isInvalid ? 'invalid' : '';
  $hintId = $hint ? $id.'-hint' : null;
  $errorId = $isInvalid ? $id.'-error' : null;
  $describedBy = $isInvalid ? $errorId : ($hint ? $hintId : null);
  $inputPaddingLeft = $icon ? 'pl-10' : '';
  $inputPaddingRight = $trailingIcon ? 'pr-10' : '';
@endphp

<x-myds.tokens />

@if($label)
  <label for="{{ $id }}" class="myds-label">
    {{ $label }} @if($required)<span class="txt-danger">*</span>@endif
  </label>
@endif

<div class="relative">
  @if ($icon)
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      {!! $icon !!}
    </span>
  @endif
  <input
    id="{{ $id }}"
    name="{{ $id }}"
    type="{{ $type }}"
    @if(!is_null($value)) value="{{ old($id, $value) }}" @endif
    @class([
      'myds-input', $sizeClass, $invalidClass, $inputPaddingLeft, $inputPaddingRight, $class,
      // For a11y, always show pointer unless disabled
      'cursor-not-allowed opacity-60' => $disabled,
    ])
    placeholder="{{ $placeholder }}"
    @if($disabled) disabled @endif
    @if($required) aria-required="true" required @endif
    @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
    @if($isInvalid) aria-invalid="true" @endif
    @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @if($inputmode) inputmode="{{ $inputmode }}" @endif
  />
  @if ($trailingIcon)
    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
      {!! $trailingIcon !!}
    </span>
  @endif
</div>

@if($isInvalid)
  <p id="{{ $errorId }}" class="myds-hint error mt-1" role="alert">{{ $error }}</p>
@elseif($hint)
  <p id="{{ $hintId }}" class="myds-hint mt-1">{{ $hint }}</p>
@endif
