
@props([
    'value' => null,
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-txt-black-900']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-txt-danger ml-1" aria-label="required">*</span>
    @endif
</label>
