<x-ictserve.form-select {{ $attributes->merge([]) }}>
    {{ $slot }}
</x-ictserve.form-select>
{{--
  Select Field for ICTServe (iServe)
  - Standards: project tokens, visible label, error/hint, semantic a11y, citizen-centric principles
  - Props:
  id: string (required)
  label: string
  hint: string|null
  error: string|null
  value: string|int|null
  required: bool
  disabled: bool
  size: 'sm'|'md'|'lg'
  placeholder: string|null
  options: array [['value'=>..., 'label'=>..., 'disabled'=>bool]]
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
  'placeholder' => 'Sila Pilih',
  'options' => [],
])

@php
  $sizeClass = match ($size) {
    'sm' => 'select-sm',
    'lg' => 'select-lg',
    default => 'select-md',
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

<div class="relative">
  <select
    id="{{ $id }}"
    name="{{ $id }}"
  @class(['select', $sizeClass, $invalidClass, 'appearance-none pr-10'])
    @if($disabled) disabled @endif
    @if($required) aria-required="true" required @endif
    @if($invalid) aria-invalid="true" aria-describedby="{{ $errorId }}" @elseif($hint) aria-describedby="{{ $hintId }}" @endif
  >
    <option value="" disabled @selected(empty($value))>
      {{ $placeholder }}
    </option>
    @foreach ($options as $opt)
      <option
        value="{{ $opt['value'] }}"
        @disabled($opt['disabled'] ?? false)
        @selected((string) $value === (string) $opt['value'])
      >
        {{ $opt['label'] }}
      </option>
    @endforeach
  </select>
  <span
    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"
  >
  <x-ictserve.icons.chevron-down class="icon txt-black-500" />
  </span>
</div>

@if ($invalid)
  <p id="{{ $errorId }}" class="hint error mt-1">{{ $error }}</p>
@elseif ($hint)
  <p id="{{ $hintId }}" class="hint mt-1">{{ $hint }}</p>
@endif
