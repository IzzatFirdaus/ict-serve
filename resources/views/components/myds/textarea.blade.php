@props([
    "name" => null,
    "label" => null,
    "required" => false,
    "maxlength" => null,
    "rows" => 4,
    "placeholder" => null,
    "helpText" => null,
    "disabled" => false,
    "error" => null,
    "id" => null,
])

@php
  $textareaId = $id ?? ($name ?? "textarea-" . str()->random(6));
  $hasError = $error || ($name && $errors->has($name));

  // MYDS textarea styling
  $textareaClasses = "block w-full rounded-lg border font-inter text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 resize-y";

  if ($hasError) {
      $textareaClasses .= " border-danger-300 bg-danger-50 text-danger-900 placeholder-danger-400 focus:border-danger-500 focus:ring-danger-300";
  } else {
      $textareaClasses .= " border-gray-300 bg-white text-black-900 placeholder-gray-400 hover:border-gray-400 focus:border-primary-500 focus:ring-primary-300";
  }

  if ($disabled) {
      $textareaClasses .= " bg-gray-100 text-gray-500 cursor-not-allowed";
  } else {
      $textareaClasses .= " px-3 py-2.5";
  }
@endphp

<div
  class="myds-field space-y-1"
  @if($maxlength) x-data="{ count: 0, max: {{ $maxlength }} }" @endif
>
  @if ($label)
    <x-myds.label :for="$textareaId" :required="$required">
      {{ $label }}
    </x-myds.label>
  @endif

  <textarea
    id="{{ $textareaId }}"
    @if($name) name="{{ $name }}" @endif
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
    @if($disabled) disabled @endif
    @if($required) required aria-required="true" @endif
    @if($hasError) aria-invalid="true" aria-describedby="{{ $textareaId }}-error" @endif
    @if($helpText) aria-describedby="{{ $textareaId }}-help" @endif
    @if ($maxlength)
        maxlength="{{ $maxlength }}"
        x-on:input="count = $event.target.value.length"
        aria-describedby="{{ $textareaId }}-counter"
    @endif
    rows="{{ $rows }}"
    class="{{ $textareaClasses }}"
    {{ $attributes->except(["class"]) }}
  >
{{ $slot }}</textarea
  >

  @if ($maxlength)
    <div
      id="{{ $textareaId }}-counter"
      class="flex justify-end text-xs text-gray-600 font-inter"
    >
      <span x-text="count">0</span>
      /
      <span>{{ $maxlength }}</span>
      aksara
    </div>
  @endif

  @if ($helpText)
    <p id="{{ $textareaId }}-help" class="text-xs text-gray-600 font-inter">
      {{ $helpText }}
    </p>
  @endif

  @if ($error)
    <x-myds.error id="{{ $textareaId }}-error">{{ $error }}</x-myds.error>
  @elseif ($name && $errors->has($name))
    <x-myds.error id="{{ $textareaId }}-error" :field="$name" />
  @endif
</div>
