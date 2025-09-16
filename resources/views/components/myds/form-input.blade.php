{{--
  MYDS Input Field for ICTServe (iServe)
  - Adheres to MYDS standards (Design, Develop, Icons, Colour) and MyGovEA citizen-centric, error-preventive principles.
  - Features: visible top label, hint/error below, semantic tokens, a11y, responsive, icon support.
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
      autocomplete: string|null
      inputmode: string|null
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
  'autocomplete' => null,
  'inputmode' => null,
])

@php
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
      'myds-input', $sizeClass, $invalidClass, $inputPaddingLeft,
      // For a11y, always show pointer unless disabled
      'cursor-not-allowed opacity-60' => $disabled,
    ])
    placeholder="{{ $placeholder }}"
    @if($disabled) disabled @endif
    @if($required) aria-required="true" required @endif
    @if($isInvalid) aria-invalid="true" aria-describedby="{{ $errorId }}" @elseif($hintId) aria-describedby="{{ $hintId }}" @endif
    @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @if($inputmode) inputmode="{{ $inputmode }}" @endif
  />
</div>

@if($isInvalid)
  <p id="{{ $errorId }}" class="myds-hint error mt-1" role="alert">{{ $error }}</p>
@elseif($hint)
  <p id="{{ $hintId }}" class="myds-hint mt-1">{{ $hint }}</p>
@endif
