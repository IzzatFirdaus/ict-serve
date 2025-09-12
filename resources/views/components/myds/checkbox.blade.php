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
    'variant' => 'default',
])

@php
    $inputId = $attributes->get('id', $name . '_' . $value);

    $sizeClasses = match($size) {
        'sm' => 'h-4 w-4',
        'default' => 'h-5 w-5',
        'lg' => 'h-6 w-6',
        default => 'h-5 w-5'
    };

    $baseClasses = 'rounded border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2';

    $stateClasses = match(true) {
        $error => 'border-danger-300 text-danger-600 focus:border-danger-500',
        $disabled => 'border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed',
        default => 'border-gray-300 text-primary-600 hover:border-gray-400 focus:border-primary-500'
    };

    $labelSizeClasses = match($size) {
        'sm' => 'text-sm',
        'default' => 'text-base',
        'lg' => 'text-lg',
        default => 'text-base'
    };
@endphp

<div {{ $attributes->except(['name', 'value', 'checked', 'required', 'disabled', 'id']) }}>
    <div class="flex items-start">
        <div class="flex items-center h-6">
            <input
                type="checkbox"
                name="{{ $name }}"
                id="{{ $inputId }}"
                value="{{ $value }}"
                @if($checked) checked @endif
                @if($required) required @endif
                @if($disabled) disabled @endif
                class="{{ $baseClasses }} {{ $sizeClasses }} {{ $stateClasses }}"
                @if($error)
                    aria-invalid="true"
                    aria-describedby="{{ $inputId }}-error"
                @endif
                @if($help)
                    aria-describedby="{{ $inputId }}-help"
                @endif
            />
        </div>

        @if($label)
            <div class="ml-3 {{ $labelSizeClasses }}">
                <label for="{{ $inputId }}" class="font-medium text-txt-black-900 cursor-pointer">
                    {{ $label }}
                    @if($required)
                        <span class="text-txt-danger ml-1">*</span>
                    @endif
                </label>

                @if($help && !$error)
                    <p id="{{ $inputId }}-help" class="mt-1 text-sm text-txt-black-500">
                        {{ $help }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    @if($error)
        <p id="{{ $inputId }}-error" class="mt-2 text-sm text-txt-danger" role="alert">
            {{ $error }}
        </p>
    @endif
</div>
