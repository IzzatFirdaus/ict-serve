@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'type' => 'text',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'placeholder' => '',
    'error' => null,
    'hint' => null,
    'prefix' => null,
    'suffix' => null
])

@php
    $inputId = $id ?? $name ?? uniqid('input_');
    $baseClasses = 'myds-form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150';
    
    if ($error) {
        $baseClasses .= ' border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500';
    }
    
    if ($disabled) {
        $baseClasses .= ' bg-gray-50 text-gray-500 cursor-not-allowed';
    }
    
    $inputClasses = $baseClasses . ' text-base px-3 py-2';
@endphp

<div class="myds-form-field">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif
    
    @if($hint)
        <p class="text-sm text-gray-600 mb-2">{{ $hint }}</p>
    @endif
    
    <div class="myds-input-wrapper relative">
        @if($prefix)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $prefix }}</span>
            </div>
        @endif
        
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => $inputClasses . ($prefix ? ' pl-10' : '') . ($suffix ? ' pr-10' : '')]) }}
        />
        
        @if($suffix)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <span class="text-gray-500 text-sm">{{ $suffix }}</span>
            </div>
        @endif
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
