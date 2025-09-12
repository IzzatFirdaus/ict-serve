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
])

@php
    $inputId = $id ?? $name ?? 'textarea-' . uniqid();
    $classes = 'myds-input w-full resize-y' . ($error ? ' border-danger-300 focus:border-danger-300 focus:ring-fr-danger' : '');
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

    <textarea
        id="{{ $inputId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}
        @if($error) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif
        @if($help) aria-describedby="{{ $inputId }}-help" @endif
    >{{ old($name, $value) }}</textarea>

    @if($error)
        <p id="{{ $inputId }}-error" class="text-sm text-txt-danger" role="alert">
            <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $error }}
        </p>
    @endif

    @if($help && !$error)
        <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500">
            {{ $help }}
        </p>
    @endif
</div>
