@props(['name', 'label', 'required' => false, 'maxlength' => null])

<div class="myds-field" x-data="{ count: 0, max: {{ $maxlength ?? 'null' }} }">
    <label for="{{ $name }}" class="myds-label">
        {{ $label }}
        @if($required)
            <span class="text-danger-600 dark:text-danger-400" aria-label="wajib">*</span>
        @endif
    </label>

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        x-on:input="count = $event.target.value.length"
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        class="myds-input myds-textarea @error($name) myds-input-error @enderror"
        rows="4"
        @if($required) required @endif
        {{ $attributes }}
    ></textarea>

    @if($maxlength)
    <div class="mt-1 text-txt-black-500 dark:text-txt-black-400 text-body-sm flex justify-end">
        <span x-text="count"></span>/<span x-text="max"></span> characters
    </div>
    @endif

    @error($name)
        <div class="myds-field-error" role="alert">{{ $message }}</div>
    @enderror
</div>
