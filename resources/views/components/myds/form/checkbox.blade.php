@props([
  'label' => null,
  'required' => false,
  'error' => null,
  'help' => null,
  'id' => null,
  'name' => null,
  'value' => '1',
  'checked' => false,
  'indeterminate' => false,
  'disabled' => false,
])

@php
  $inputId = $id ?? ($name ?? 'checkbox-' . uniqid());
  $isChecked = old($name, $checked);
  $ariaDescribedBy = [];
  if ($error) {
    $ariaDescribedBy[] = $inputId . '-error';
  }
  if ($help && ! $error) {
    $ariaDescribedBy[] = $inputId . '-help';
  }
@endphp

<div class="space-y-1">
  <div class="flex items-start">
    <div class="flex items-center h-5">
      <input
        type="checkbox"
        id="{{ $inputId }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($isChecked) checked @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($indeterminate) x-init="$el.indeterminate = true" @endif
        class="myds-checkbox w-5 h-5 text-primary-600 bg-bg-white border-otl-gray-200 rounded-[var(--radius-s)] focus:ring-2 focus:ring-fr-primary focus:ring-offset-0 transition-colors duration-200 {{ $error ? 'border-danger-600 focus:ring-fr-danger' : '' }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
        aria-invalid="{{ $error ? 'true' : 'false' }}"
        @if(count($ariaDescribedBy)) aria-describedby="{{ implode(' ', $ariaDescribedBy) }}" @endif
        {{ $attributes }}
      />
    </div>

    @if ($label)
      <div class="ml-3 text-sm leading-5 select-none">
        <label
          for="{{ $inputId }}"
          class="font-medium text-txt-black-900 cursor-pointer"
        >
          {{ $label }}
          @if ($required)
            <span class="text-txt-danger ml-1" aria-label="required">*</span>
          @endif
        </label>
      </div>
    @endif
  </div>

  @if ($error)
    <p
      id="{{ $inputId }}-error"
      class="text-sm text-txt-danger ml-7 flex items-center gap-1"
      role="alert"
    >
      {{-- MYDS error icon (20x20, 1.5px stroke) --}}
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
    <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500 ml-7">
      {{ $help }}
    </p>
  @endif
</div>
