@props([
    'options' => [],
    'placeholder' => 'Pilih...',
    'multiple' => false,
    'required' => false,
    'disabled' => false,
    'label' => '',
    'name' => '',
    'value' => '',
    'error' => '',
    'help' => '',
    'size' => 'default',
])

@php
    $inputId = $attributes->get('id', $name);

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'default' => 'px-4 py-3 text-base',
        'lg' => 'px-6 py-4 text-lg',
        default => 'px-4 py-3 text-base'
    };

    $baseClasses = 'block w-full rounded-md border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2';

    $stateClasses = match(true) {
        $error => 'border-danger-300 text-txt-danger bg-bg-white',
    $disabled => 'border-otl-gray-200 bg-gray-100 text-txt-black-500 cursor-not-allowed',
        default => 'border-otl-gray-200 bg-bg-white text-txt-black-900 hover:border-otl-gray-200'
    };
@endphp

<div {{ $attributes->except(['options', 'placeholder', 'multiple', 'required', 'disabled', 'name', 'value', 'id']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-txt-black-900 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-txt-danger ml-1">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $inputId }}"
            @if($multiple) multiple @endif
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
        >
            @if(!$multiple && $placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $optionValue => $label)
                <option
                    value="{{ $optionValue }}"
                    @if($value == $optionValue) selected @endif
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @if($error)
            <div class="absolute inset-y-0 right-8 pr-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-txt-danger" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @if($error)
        <p id="{{ $inputId }}-error" class="mt-2 text-sm text-txt-danger" role="alert">
            {{ $error }}
        </p>
    @endif

    @if($help && !$error)
        <p id="{{ $inputId }}-help" class="mt-2 text-sm text-txt-black-500">
            {{ $help }}
        </p>
    @endif
</div>
