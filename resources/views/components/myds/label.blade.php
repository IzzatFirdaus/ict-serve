@props([
    'for' => null,
    'required' => false,
])

<label 
    {{ $attributes->merge([
        'class' => 'block font-inter text-xs font-medium text-black-700 mb-1'
    ]) }}
    @if($for) for="{{ $for }}" @endif
>
    {{ $slot }}
    @if($required)
        <span class="text-danger-600 ml-1" aria-label="required">*</span>
    @endif
</label>