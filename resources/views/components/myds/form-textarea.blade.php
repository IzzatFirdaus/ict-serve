<x-ictserve.form-textarea {{ $attributes->merge([]) }}>
    {{ $slot }}
</x-ictserve.form-textarea>
{{--
  Textarea Field for ICTServe (iServe)
  - Standards: tokens, label, error/hint, a11y, citizen-centric principles
  - Props:
  id: string (required)
  label: string
  hint: string|null
  error: string|null
  value: string|null
  required: bool
  disabled: bool
  size: 'sm'|'md'|'lg'
  rows: int
  placeholder: string|null
  autocomplete: string|null
--}}

@props([
  'id',
  'label' => null,
  'hint' => null,
  'error' => null,
  'value' => null,
  'required' => false,
  'disabled' => false,
  'size' => 'md',
  'rows' => 4,
  'placeholder' => null,
  'autocomplete' => null,
])

@php
  $sizeClass = match ($size) {
    'sm' => 'textarea-sm',
    'lg' => 'textarea-lg',
    default => 'textarea-md',
  };
  $invalid = ! empty($error);
  $invalidClass = $invalid ? 'invalid' : '';
  $hintId = $hint ? $id . '-hint' : null;
  $errorId = $invalid ? $id . '-error' : null;
@endphp

<x-ictserve.tokens />

@if ($label)
  <label for="{{ $id }}" class="label">
    {{ $label }}
    @if ($required)
      <span class="txt-danger">*</span>
    @endif
  </label>
@endif

<textarea
  id="{{ $id }}"
  name="{{ $id }}"
  rows="{{ $rows }}"
  @class(['textarea', $sizeClass, $invalidClass])
  placeholder="{{ $placeholder }}"
  @if($disabled) disabled @endif
  @if($required) aria-required="true" required @endif
  @if($invalid) aria-invalid="true" aria-describedby="{{ $errorId }}" @elseif($hint) aria-describedby="{{ $hintId }}" @endif
  @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
>
{{ old($id, $value) }}</textarea
>

@if ($invalid)
  <p id="{{ $errorId }}" class="hint error mt-1">{{ $error }}</p>
@elseif ($hint)
  <p id="{{ $hintId }}" class="hint mt-1">{{ $hint }}</p>
@endif
