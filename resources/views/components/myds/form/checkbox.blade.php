@props([
    'label' => null,
    'required' => false,
    'error' => null,
    'help' => null,
    'id' => null,
    'name' => null,
    'value' => '1',
    'checked' => false,
])

@php
    $inputId = $id ?? $name ?? 'checkbox-' . uniqid();
    $isChecked = old($name, $checked);
@endphp

<div class="space-y-1">
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input
                type="checkbox"
                id="{{ $inputId }}"
                name="{{ $name }}"
                value="{{ $value }}"
                {{ $isChecked ? 'checked' : '' }}
                {{ $required ? 'required' : '' }}
                class="w-4 h-4 text-txt-primary bg-bg-white border-otl-gray-200 rounded-[var(--radius-s)] focus:ring-fr-primary focus:ring-2 transition-colors"
                {{ $attributes }}
                @if($error) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif
                @if($help) aria-describedby="{{ $inputId }}-help" @endif
            />
        </div>

        @if($label)
            <div class="ml-3 text-sm">
                <label for="{{ $inputId }}" class="font-medium text-txt-black-900">
                    {{ $label }}
                    @if($required)
                        <span class="text-txt-danger ml-1" aria-label="required">*</span>
                    @endif
                </label>
            </div>
        @endif
    </div>

    @if($error)
        <p id="{{ $inputId }}-error" class="text-sm text-txt-danger ml-7" role="alert">
            <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $error }}
        </p>
    @endif

    @if($help && !$error)
        <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500 ml-7">
            {{ $help }}
        </p>
    @endif
</div>
