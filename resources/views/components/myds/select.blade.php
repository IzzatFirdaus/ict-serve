@props(['name', 'label', 'required' => false, 'options' => []])

<div class="myds-field">
    <label for="{{ $name }}" class="myds-label">
        {{ $label }}
        @if($required)
            <span class="text-danger-600 dark:text-danger-400" aria-label="wajib">*</span>
        @endif
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        class="myds-input @error($name) myds-input-error @enderror"
        @if($required) required @endif
        {{ $attributes }}
    >
        <option value="">Sila Pilih</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @error($name)
        <div class="myds-field-error" role="alert">{{ $message }}</div>
    @enderror
</div>
