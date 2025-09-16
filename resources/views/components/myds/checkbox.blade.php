
{{-- Komponen Checkbox MYDS (BM, Aksesibiliti, Token, Ralat) --}}
@props([
    'label' => '',
    'name' => '',
    'value' => '1',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'error' => '',
    'help' => '',
    'size' => 'default',
    'id' => null,
])

@php
    $checkboxId = $id ?? $name . '_' . str()->slug($value);
    $hasError = $error || ($name && $errors->has($name));
    $sizeClasses = match($size) {
        'sm' => 'h-4 w-4',
        'lg' => 'h-6 w-6',
        default => 'h-5 w-5'
    };
    $baseClasses = 'rounded border-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-300';
    $stateClasses = match(true) {
        $hasError => 'border-danger-300 text-danger-600 bg-danger-50',
        $disabled => 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed',
        default => 'border-gray-300 text-primary-600 bg-white hover:border-gray-400 checked:bg-primary-600 checked:border-primary-600'
    };
    $labelSizeClasses = match($size) {
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        default => 'text-base'
    };
@endphp

<div {{ $attributes->except(['name', 'value', 'checked', 'required', 'disabled', 'id']) }}>
    <div class="flex items-start gap-3">
        <div class="flex items-center h-6">
            <input
                type="checkbox"
                name="{{ $name }}"
                id="{{ $checkboxId }}"
                value="{{ $value }}"
                @if($checked) checked @endif
                @if($required) required aria-required="true" @endif
                @if($disabled) disabled @endif
                @if($hasError) aria-invalid="true" aria-describedby="{{ $checkboxId }}-error" @endif
                @if($help) aria-describedby="{{ $checkboxId }}-help" @endif
                class="{{ $baseClasses }} {{ $sizeClasses }} {{ $stateClasses }}"
            />
        </div>

        @if($label)
            <div class="flex-1 {{ $labelSizeClasses }}">
                <label for="{{ $checkboxId }}" class="font-inter font-medium text-black-900 cursor-pointer select-none">
                    {{ $label }}
                    @if($required)
                        <span class="text-danger-600 ml-1" aria-label="required">*</span>
                    @endif
                </label>

                @if($help && !$hasError)
                    <p id="{{ $checkboxId }}-help" class="mt-1 text-sm text-gray-600 font-inter">
                        {{ $help }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    @if($error)
        <x-myds.error id="{{ $checkboxId }}-error" class="mt-2">{{ $error }}</x-myds.error>
    @elseif($name && $errors->has($name))
        <x-myds.error id="{{ $checkboxId }}-error" :field="$name" class="mt-2" />
    @endif
</div>
