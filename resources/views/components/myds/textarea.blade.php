@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => '',
    'help' => '',
    'rows' => 4,
    'maxlength' => null,
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

    $baseClasses = 'block w-full rounded-md border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 resize-vertical';

    $stateClasses = match(true) {
        $error => 'border-danger-300 text-txt-danger bg-white focus:border-danger-500',
        $disabled => 'border-gray-300 bg-gray-100 text-txt-black-disabled cursor-not-allowed',
        $readonly => 'border-gray-300 bg-gray-50 text-txt-black-700',
        default => 'border-gray-300 bg-white text-txt-black-900 hover:border-gray-400 focus:border-primary-500'
    };
@endphp

<div {{ $attributes->except(['name', 'value', 'placeholder', 'required', 'disabled', 'readonly', 'rows', 'maxlength', 'id']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-txt-black-900 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-txt-danger ml-1">*</span>
            @endif
            @if($maxlength)
                <span class="text-txt-black-500 text-xs ml-2">(Max {{ $maxlength }} characters)</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <textarea
            name="{{ $name }}"
            id="{{ $inputId }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            class="{{ $baseClasses }} {{ $sizeClasses }} {{ $stateClasses }}"
            @if($error)
                aria-invalid="true"
                aria-describedby="{{ $inputId }}-error"
            @endif
            @if($help)
                aria-describedby="{{ $inputId }}-help"
            @endif
        >{{ $value }}</textarea>

        @if($error)
            <div class="absolute top-3 right-3 pointer-events-none">
                <svg class="h-5 w-5 text-txt-danger" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>

    @if($maxlength)
        <div class="flex justify-between mt-1">
            <div class="flex-1">
                @if($error)
                    <p id="{{ $inputId }}-error" class="text-sm text-txt-danger" role="alert">
                        {{ $error }}
                    </p>
                @elseif($help)
                    <p id="{{ $inputId }}-help" class="text-sm text-txt-black-500">
                        {{ $help }}
                    </p>
                @endif
            </div>
            <div class="text-xs text-txt-black-500"
                 x-data="{ count: $refs.textarea ? $refs.textarea.value.length : 0 }"
                 x-init="$watch('count', value => count = $refs.textarea.value.length)">
                <span x-text="count"></span>/{{ $maxlength }}
            </div>
        </div>
    @else
        @if($error)
            <p id="{{ $inputId }}-error" class="mt-2 text-sm text-txt-danger" role="alert">
                {{ $error }}
            </p>
        @elseif($help)
            <p id="{{ $inputId }}-help" class="mt-2 text-sm text-txt-black-500">
                {{ $help }}
            </p>
        @endif
    @endif
</div>
