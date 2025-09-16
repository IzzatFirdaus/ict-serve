{{--
  MYDS Card Component for ICTServe (iServe)
  - Props:
      title?: string
      subtitle?: string
      icon?: string (icon name)
      actions?: slot
      border?: bool
      shadow?: bool
      radius?: string (xs|s|m|l|xl|full)
      bg?: string (use MYDS tokens)
--}}
@props([
  'title' => null,
  'subtitle' => null,
  'icon' => null,
  'actions' => null,
  'border' => true,
  'shadow' => true,
  'radius' => 'l',
  'bg' => 'bg-white',
])

<x-myds.tokens />

<div @class([
    $bg,
    $border ? 'border border-divider' : '',
    $shadow ? 'shadow-card' : '',
    "radius-$radius",
    "p-6",
    "relative"
  ])>
  @if($icon)
    <div class="mb-3">
      <x-myds.icons :name="$icon" class="myds-icon txt-primary" />
    </div>
  @endif
  @if($title)
    <h2 class="font-poppins font-semibold text-xl txt-black-900 mb-2">{{ $title }}</h2>
  @endif
  @if($subtitle)
    <p class="text-sm txt-black-500 mb-3">{{ $subtitle }}</p>
  @endif
  <div>
    {{ $slot }}
  </div>
  @if($actions)
    <div class="absolute top-4 right-4 flex gap-2">
      {{ $actions }}
    </div>
  @endif
</div>
