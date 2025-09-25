<x-ictserve.label {{ $attributes->merge([]) }}>
    {{ $slot }}
</x-ictserve.label>
<x-ictserve.label {{ $attributes->merge([]) }}>
    {{ $slot }}
</x-ictserve.label>
{{--
  ICTServe Label component (iServe)
  - Complies with project design tokens and accessibility principles (citizen-centric, clear hierarchy, minimal, accessible).
  - Props:
  for: string|null (id of the associated input)
  required: bool (show required indicator)
  hint: string|null (optional hint below label)
  size: 'sm'|'md'|'lg' (default: md)
  class: string|null
  sr: bool (screen reader only)
--}}

@props([
  'for' => null,
  'required' => false,
  'hint' => null,
  'size' => 'md',
  'class' => '',
  'sr' => false,
])

@php
  // Label sizes (Design/Develop overview)
  $sizeClass = match ($size) {
    'sm' => 'text-sm leading-[20px] font-medium mb-1',
    'lg' => 'text-lg leading-[28px] font-semibold mb-2',
    default => 'text-base leading-[24px] font-semibold mb-1',
  };
  $srClass = $sr ? 'sr-only' : '';
@endphp

<label
  @if($for) for="{{ $for }}" @endif
  class="ictserve-label font-poppins txt-black-900 {{ $sizeClass }} {{ $srClass }} {{ $class }}"
>
  {{ $slot }}
  @if ($required)
    <span class="txt-danger" aria-hidden="true">*</span>
    <span class="sr-only">(wajib)</span>
  @endif
</label>

@if ($hint)
  <p class="ictserve-label-hint text-xs txt-black-500 mt-1">{{ $hint }}</p>
@endif
