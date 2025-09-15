@props([
    'name' => null,
    'label' => null,
    'required' => false,
    'options' => [],
    'placeholder' => 'Sila Pilih',
    'helpText' => null,
    'disabled' => false,
    'error' => null,
    'id' => null,
])

@php
    $selectId = $id ?? $name ?? 'select-' . str()->random(6);
    $hasError = $error || ($name && $errors->has($name));
    
    // MYDS select styling
    $selectClasses = 'block w-full rounded-lg border font-inter text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 pr-10';
    
    if ($hasError) {
        $selectClasses .= ' border-danger-300 bg-danger-50 text-danger-900 focus:border-danger-500 focus:ring-danger-300';
    } else {
        $selectClasses .= ' border-gray-300 bg-white text-black-900 hover:border-gray-400 focus:border-primary-500 focus:ring-primary-300';
    }
    
    if ($disabled) {
        $selectClasses .= ' bg-gray-100 text-gray-500 cursor-not-allowed';
    } else {
        $selectClasses .= ' px-3 py-2.5';
    }
@endphp

<div class="myds-field space-y-1">
    @if($label)
        <x-myds.label :for="$selectId" :required="$required">
            {{ $label }}
        </x-myds.label>
    @endif

    <div class="relative">
        <select
            id="{{ $selectId }}"
            @if($name) name="{{ $name }}" @endif
            @if($disabled) disabled @endif
            @if($required) required aria-required="true" @endif
            @if($hasError) aria-invalid="true" aria-describedby="{{ $selectId }}-error" @endif
            @if($helpText) aria-describedby="{{ $selectId }}-help" @endif
            class="{{ $selectClasses }}"
            {{ $attributes->except(['class']) }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            
            @if(is_array($options))
                @foreach($options as $value => $optionLabel)
                    <option value="{{ $value }}">{{ $optionLabel }}</option>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </select>
        
        <!-- MYDS dropdown arrow -->
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    @if($helpText)
        <p id="{{ $selectId }}-help" class="text-xs text-gray-600 font-inter">
            {{ $helpText }}
        </p>
    @endif

    @if($error)
        <x-myds.error id="{{ $selectId }}-error">{{ $error }}</x-myds.error>
    @elseif($name && $errors->has($name))
        <x-myds.error id="{{ $selectId }}-error" :field="$name" />
    @endif
</div>
