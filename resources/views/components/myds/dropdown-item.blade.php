{{--
  MYDS Dropdown Item for ICTServe (iServe)
  - Compliant with MYDS: semantic tokens, icons, focus ring, ARIA, citizen-centric.
  - Props:
  href: string|null (URL for link)
  icon: Blade/SVG|null (icon slot)
  disabled: bool
  variant: default|danger
--}}

@props([
  'href' => null,
  'icon' => null,
  'disabled' => false,
  'variant' => 'default',
])

@php
  $tag = $href && ! $disabled ? 'a' : 'button';
  $baseClasses = 'block w-full text-left radius-s px-4 py-2 text-sm font-inter transition-colors duration-150 focus-ring-primary';
  $variantClasses = $variant === 'danger' ? 'txt-danger hover:bg-danger-50 focus:bg-danger-50' : 'txt-black-700 hover:bg-gray-50 focus:bg-gray-50 hover:txt-primary focus:txt-primary';
  $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '';
@endphp

<{{ $tag }}
  @if($href && !$disabled) href="{{ $href }}" @endif
  @if($tag === 'button') type="button" @endif
  class="{{ $baseClasses }} {{ $variantClasses }} {{ $disabledClasses }}"
  role="menuitem"
  tabindex="-1"
  aria-disabled="{{ $disabled ? 'true' : 'false' }}"
  {{ $disabled ? 'disabled' : '' }}
  {{ $attributes }}
>
  <div class="flex items-center gap-3">
    @if ($icon)
      <span class="flex-shrink-0">
        {!! $icon !!}
      </span>
    @endif

    <span>{{ $slot }}</span>
  </div>
</{{ $tag }}>
