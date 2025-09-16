{{--
  MYDS Alert for ICTServe (iServe)
  - Compliant with MYDS: colour tokens, icon, grid, accessible, dismissible.
  - Props:
      variant: info|success|warning|danger
      title?: string
      description?: string
      icon?: bool (show icon)
      dismissible?: bool
--}}
@props([
  'variant' => 'info',
  'title' => '',
  'description' => '',
  'icon' => true,
  'dismissible' => false,
])

@php
  $variantClass = match($variant) {
    'success' => 'bg-success-50 border-success-200 txt-success',
    'warning' => 'bg-warning-50 border-warning-200 txt-warning',
    'danger'  => 'bg-danger-50 border-danger-200 txt-danger',
    default   => 'bg-primary-50 border-primary-200 txt-primary',
  };
  $iconMap = [
    'success' => 'check-circle',
    'warning' => 'alert-triangle',
    'danger'  => 'x-circle',
    'info'    => 'info',
  ];
@endphp

<x-myds.tokens />

<div @class(["myds-callout", $variantClass, "grid", "gap-3", "radius-m", "border", "p-4", "items-center"]) role="alert">
  @if($icon)
    <div>
      <x-myds.icons :name="$iconMap[$variant]" class="myds-icon {{ $variantClass }}" />
    </div>
  @endif
  <div>
    @if($title)
      <div class="font-semibold text-base">{{ $title }}</div>
    @endif
    @if($description)
      <div class="text-sm font-inter mt-1">{{ $description }}</div>
    @endif
    {{ $slot }}
  </div>
  @if($dismissible)
    <div>
      <button type="button" class="myds-btn btn-tertiary btn-sm" aria-label="Tutup makluman" onclick="this.closest('.myds-callout')?.remove()">
        <x-myds.icons name="x" class="myds-icon" />
      </button>
    </div>
  @endif
</div>
