@props([
    'label' => null,
    'required' => false,
    'error' => null,
    'help' => null,
    'id' => null,
    'name' => null,
    'value' => '',
    'placeholder' => 'Sila pilih...',
    'options' => [],
    'disabled' => false,
])

@php
    $inputId = $id ?? $name ?? 'select-' . uniqid();
    $ariaDescribedBy = [];
    if ($error) $ariaDescribedBy[] = $inputId . '-error';
    if ($help && !$error) $ariaDescribedBy[] = $inputId . '-help';
    $classes = 'myds-input w-full appearance-none pr-8 bg-bg-white ' .
        ($error ? 'border-danger-600 focus:border-danger-600 focus:ring-fr-danger' : 'border-otl-gray-200 focus:border-primary-600 focus:ring-fr-primary') .
        ($disabled ? ' opacity-60 cursor-not-allowed' : '');
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-txt-black-900">
            {{ $label }}
            @if($required)
                <span class="text-txt-danger ml-1" aria-label="required">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select
            id="{{ $inputId }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $classes]) }}
            aria-invalid="{{ $error ? 'true' : 'false' }}"
            @if(count($ariaDescribedBy)) aria-describedby="{{ implode(' ', $ariaDescribedBy) }}" @endif
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach

            {{ $slot }}
        </select>
        {{-- MYDS dropdown chevron icon (SVG, 20x20, 1.5px stroke) --}}
        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
            <svg class="w-5 h-5 text-txt-black-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 8l4 4 4-4"/>
            </svg>
        </div>
    </div>

    @if($error)
        <p id="{{ $inputId }}-error" class="text-sm text-txt-danger flex items-center gap-1 mt-1" role="alert">
            <svg class="inline w-4 h-4 text-txt-danger" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                <circle cx="10" cy="10" r="8"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6v4m0 4h.01"/>
            </svg>
            {{ $error }}
        </p>
    @endif

    @if($help && !$error)
        <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500 mt-1">
            {{ $help }}
        </p>
    @endif
</div>
