@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'type' => 'text',
    'placeholder' => null,
    'helpText' => null,
    'disabled' => false,
    'error' => null,
    'id' => null,
])

@php
    $inputId = $id ?? $name ?? 'input-' . Str::random(6);
    $hasError = $error || ($name && $errors->has($name));
    
    // MYDS input styling
    $inputClasses = 'block w-full rounded-lg border font-inter text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    if ($hasError) {
        $inputClasses .= ' border-danger-300 bg-danger-50 text-danger-900 placeholder-danger-400 focus:border-danger-500 focus:ring-danger-300';
    } else {
        $inputClasses .= ' border-gray-300 bg-white text-black-900 placeholder-gray-400 hover:border-gray-400 focus:border-primary-500 focus:ring-primary-300';
    }
    
    if ($disabled) {
        $inputClasses .= ' bg-gray-100 text-gray-500 cursor-not-allowed';
    } else {
        $inputClasses .= ' px-3 py-2.5';
    }
@endphp

<div class="myds-field space-y-1">
    @if($label)
        <x-myds.label :for="$inputId" :required="$required">
            {{ $label }}
        </x-myds.label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $inputId }}"
        @if($name) name="{{ $name }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($disabled) disabled @endif
        @if($required) required aria-required="true" @endif
        @if($hasError) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif
        @if($helpText) aria-describedby="{{ $inputId }}-help" @endif
        class="{{ $inputClasses }}"
        {{ $attributes->except(['class']) }}
    >

    @if($helpText)
        <p id="{{ $inputId }}-help" class="text-xs text-gray-600 font-inter">
            {{ $helpText }}
        </p>
    @endif

    @if($error)
        <x-myds.error id="{{ $inputId }}-error">{{ $error }}</x-myds.error>
    @elseif($name && $errors->has($name))
        <x-myds.error id="{{ $inputId }}-error" :field="$name" />
    @endif
</div>
