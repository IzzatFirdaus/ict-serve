{{--
  MYDS Badge for Status/Category (ICTServe)
  - Props:
      variant: default|primary|success|danger|warning
      size: sm|md|lg
      dot: bool
      pill: bool
--}}
@props([
  'variant' => 'default',
  'size' => 'md',
  'dot' => false,
  'pill' => true,
])

@php
  $vClass = match($variant) {
    'primary' => 'bg-primary-100 txt-primary',
    'success' => 'bg-success-100 txt-success',
    'danger'  => 'bg-danger-100 txt-danger',
    'warning' => 'bg-warning-100 txt-warning',
    default   => 'bg-black-100 txt-black-700',
  };
  $sClass = match($size) {
    'sm' => 'text-xs py-1 px-2',
    'lg' => 'text-base py-2 px-4',
    default => 'text-sm py-1.5 px-3',
  };
  $radius = $pill ? 'radius-full' : 'radius-s';
@endphp

<x-myds.tokens />

<span @class(["inline-flex items-center gap-1 font-medium", $vClass, $sClass, $radius])>
  @if($dot)
    <span class="inline-block radius-full" style="width:8px;height:8px;background:currentColor;"></span>
  @endif
  {{ $slot }}
</span>
