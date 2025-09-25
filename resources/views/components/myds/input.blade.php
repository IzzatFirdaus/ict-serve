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
  'id' => null,
  'name' => null,
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
  // Determine the id to use - use explicit id if provided, otherwise use name, or generate random
  $fieldId = $id ?? ($name ?? 'input-' . uniqid());
  // Sizing and spacing tokens per MYDS
  $sizeClass = match ($size) {
    'sm' => 'myds-input-sm',
    'lg' => 'myds-input-lg',
    default => 'myds-input-md',
  };
  $isInvalid = filled($error);
  $invalidClass = $isInvalid ? 'invalid' : '';
  $hintId = $hint ? $fieldId . '-hint' : null;
  $errorId = $isInvalid ? $fieldId . '-error' : null;
  $describedBy = $isInvalid ? $errorId : ($hint ? $hintId : null);
  $inputPaddingLeft = $icon ? 'pl-10' : '';
  $inputPaddingRight = $trailingIcon ? 'pr-10' : '';
@endphp

<x-myds.tokens />

<div class="myds-input-wrapper">
  @if ($label)
    <label for="{{ $fieldId }}" class="myds-label">
      {{ $label }}
      @if ($required)
        <span class="text-danger-600">*</span>
      @endif
    </label>
  @endif
  <div class="relative">
    @if ($icon)
      <span class="absolute inset-y-0 left-0 flex items-center pl-3">
        {{ $icon }}
      </span>
    @endif
    <input
      id="{{ $fieldId }}"
      name="{{ $name }}"
      type="{{ $type }}"
      value="{{ $value }}"
      placeholder="{{ $placeholder }}"
      autocomplete="{{ $autocomplete }}"
      inputmode="{{ $inputmode }}"
      {{ $attributes->merge([
        'class' => "myds-input $sizeClass $class",
        'aria-invalid' => $error ? 'true' : 'false',
        'aria-describedby' => $hint ? "$fieldId-hint" : null,
      ]) }}
    />
    @if ($trailingIcon)
      <span class="absolute inset-y-0 right-0 flex items-center pr-3">
        {{ $trailingIcon }}
      </span>
    @endif
  </div>
  @if ($hint)
    <p id="{{ $fieldId }}-hint" class="myds-hint">{{ $hint }}</p>
  @endif
  @if ($error)
    <p class="myds-error" role="alert">{{ $error }}</p>
  @endif
</div>
