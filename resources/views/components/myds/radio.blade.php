@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'error' => '',
    'help' => '',
    'size' => 'default',
])

@php
    $inputId = $attributes->get('id', $name . '_' . $value);

      $sizeClasses = match($size) {
        'sm' => 'h-4 w-4',
        'lg' => 'h-6 w-6',
        default => 'h-5 w-5',
      };
      $labelTextSize = match($size) {
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        default => 'text-base',
      };
      $stateClasses = $disabled
        ? 'border-otl-gray-200 bg-black-100 txt-black-500 cursor-not-allowed'
        : ($error ? 'border-otl-danger-300 txt-danger' : 'border-otl-gray-200 txt-primary hover:border-otl-gray-200');

      $a11yDescribed = trim(($error ? "{$inputId}-error " : '') . ($help ? "{$inputId}-help" : ''));

    $baseClasses = 'rounded-full border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2';

    $stateClasses = match(true) {
        $error => 'border-danger-300 text-txt-danger',
        $disabled => 'border-otl-gray-200 bg-gray-100 text-txt-black-500 cursor-not-allowed',
        default => 'border-otl-gray-200 text-txt-primary hover:border-otl-gray-200'
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
                type="radio"
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
