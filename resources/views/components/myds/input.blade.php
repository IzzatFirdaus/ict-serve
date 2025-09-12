@props(['name', 'label', 'required' => false, 'type' => 'text', 'placeholder' => null])

<div class="myds-field">
    <label for="{{ $name }}" class="myds-label">
        {{ $label }}
        @if($required)
            <span class="text-danger-600 dark:text-danger-400" aria-label="wajib">*</span>
        @endif
    </label>

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        class="myds-input @error($name) myds-input-error @enderror"
        @if($required) required @endif
        {{ $attributes }}
    >

    @error($name)
        <div class="myds-field-error" role="alert">{{ $message }}</div>
    @enderror
</div>
