@props([
    'field' => null,
])

@if ($field)
    @error($field)
        <p {{ $attributes->merge(['class' => 'mt-1 text-xs text-danger-600 font-inter']) }} role="alert">
            {{ $message }}
        </p>
    @enderror
@else
    <p {{ $attributes->merge(['class' => 'mt-1 text-xs text-danger-600 font-inter']) }} role="alert">
        {{ $slot }}
    </p>
@endif