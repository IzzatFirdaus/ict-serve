{{--
  MYDS Radio Group for ICTServe (iServe)
  - Accessible, semantic, responsive, MYDS tokens, hints, labels, error handling.
  - Props:
      name: string (required)
      options: array of [ ['id'=>'','label'=>'','hint'=>null,'value'=>'','disabled'=>false], ... ]
      value?: string
      required?: bool
      label?: string
@props([
  'name',
  'options' => [],
  'value' => null,
  'required' => false,
  'label' => null,
])

{{--
  MYDS Radio Group for ICTServe (iServe)
  - Uses fieldset/legend semantics for accessibility.
  - Props:
      name: string (required)
      options: array of [ ['id'=>'','label'=>'','hint'=>null,'value'=>'','disabled'=>false], ... ]
      value?: string
      required?: bool
      label?: string
      hint?: string (group-level hint)
--}}
@props([
  'name',
  'options' => [],
  'value' => null,
  'required' => false,
  'label' => null,
  'hint' => null,
])

@php
  $legendId = $label ? ($name.'-legend') : null;
  $hintId = $hint ? ($name.'-hint') : null;
@endphp

<fieldset class="grid gap-3" @if($legendId) aria-labelledby="{{ $legendId }}" @endif @if($hintId) aria-describedby="{{ $hintId }}" @endif>
  @if ($label)
    <legend id="{{ $legendId }}" class="myds-label font-poppins txt-black-900 mb-1">
      {{ $label }} @if($required) <span class="txt-danger">*</span> @endif
    </legend>
  @endif
  @if($hint)
    <div id="{{ $hintId }}" class="myds-hint text-sm txt-black-500 mb-1">{{ $hint }}</div>
  @endif

  @foreach ($options as $opt)
    @php
      $id = $opt['id'] ?? ($name.'_'.$loop->index);
      $hintOpt = $opt['hint'] ?? null;
      $hintOptId = $hintOpt ? $id.'-hint' : null;
    @endphp

    <div class="flex items-start gap-3">
      <input
        id="{{ $id }}"
        type="radio"
        class="h-5 w-5 rounded-full border border-otl-gray-200 txt-primary focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2"
        name="{{ $name }}"
        value="{{ $opt['value'] }}"
        @checked($value === ($opt['value']))
        @if($opt['disabled'] ?? false) disabled aria-disabled="true" @endif
        @if($required) aria-required="true" @endif
        @if($hintOpt) aria-describedby="{{ $hintOptId }}" @endif
      />
      <div>
        <label for="{{ $id }}" class="txt-black-900 font-medium cursor-pointer">{{ $opt['label'] }}</label>
        @if ($hintOpt)
          <div id="{{ $hintOptId }}" class="myds-hint text-sm txt-black-500">{{ $hintOpt }}</div>
        @endif
      </div>
    </div>
  @endforeach
</fieldset>

<x-myds.tokens />

@if ($label)
  <div class="myds-label" id="{{ $name }}-legend">{{ $label }} @if($required) <span class="txt-danger">*</span>@endif</div>
@endif

<div role="radiogroup" aria-labelledby="{{ $label ? $name.'-legend' : null }}" class="grid gap-3">
  @foreach ($options as $opt)
    @php
      $id = $opt['id'] ?? ($name.'_'.$loop->index);
      $hint = $opt['hint'] ?? null;
      $hintId = $hint ? $id.'-hint' : null;
    @endphp
    <div class="myds-radio-container">
      <input
        id="{{ $id }}"
        type="radio"
        class="myds-radio"
        name="{{ $name }}"
        value="{{ $opt['value'] }}"
        @checked($value === ($opt['value']))
        @if($opt['disabled'] ?? false) disabled @endif
        @if($required) aria-required="true" @endif
        @if($hint) aria-describedby="{{ $hintId }}" @endif
      />
      <div>
        <label for="{{ $id }}" class="txt-black-900 font-medium" style="cursor:pointer;">{{ $opt['label'] }}</label>
        @if ($hint)
          <div id="{{ $hintId }}" class="myds-hint">{{ $hint }}</div>
        @endif
      </div>
    </div>
  @endforeach
</div>
