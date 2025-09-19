@props([
  'label' => null,
  'required' => false,
  'error' => null,
  'help' => null,
  'id' => null,
  'name' => null,
  'value' => '',
  'placeholder' => null,
  'rows' => 4,
  'disabled' => false,
])

@php
  $inputId = $id ?? ($name ?? 'textarea-' . uniqid());
  $ariaDescribedBy = [];
  if ($error) {
    $ariaDescribedBy[] = $inputId . '-error';
  }
  if ($help && ! $error) {
    $ariaDescribedBy[] = $inputId . '-help';
  }
  $classes =
    'myds-input w-full resize-y ' .
    ($error ? 'border-danger-600 focus:border-danger-600 focus:ring-fr-danger' : 'border-otl-gray-200 focus:border-primary-600 focus:ring-fr-primary') .
    ($disabled ? ' opacity-60 cursor-not-allowed' : '');
@endphp

<div class="space-y-1">
  @if ($label)
    <label
      for="{{ $inputId }}"
      class="block text-sm font-medium text-txt-black-900"
    >
      {{ $label }}
      @if ($required)
        <span class="text-txt-danger ml-1" aria-label="required">*</span>
      @endif
    </label>
  @endif

  <textarea
    id="{{ $inputId }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
    aria-invalid="{{ $error ? 'true' : 'false' }}"
    @if(count($ariaDescribedBy)) aria-describedby="{{ implode(' ', $ariaDescribedBy) }}" @endif
  >
{{ old($name, $value) }}</textarea
  >

  @if ($error)
    <p
      id="{{ $inputId }}-error"
      class="text-sm text-txt-danger flex items-center gap-1 mt-1"
      role="alert"
    >
      <svg
        class="inline w-4 h-4 text-txt-danger"
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        viewBox="0 0 20 20"
        aria-hidden="true"
      >
        <circle cx="10" cy="10" r="8" />
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M10 6v4m0 4h.01"
        />
      </svg>
      {{ $error }}
    </p>
  @endif

  @if ($help && ! $error)
    <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500 mt-1">
      {{ $help }}
    </p>
  @endif
</div>
