{{--
  MYDS Button Component for ICTServe (iServe)
  - MYDS Design, Tokens, Icon, Colour, Motion, Accessible, Citizen-centric.
  - Props:
      variant: primary|secondary|tertiary|danger
      size: sm|md|lg
      disabled: bool
      as: button|a
      href: for <a>
      type: button|submit|reset
      iconOnly: bool
      ariaLabel: string|null
      counter: int|null (shows numeric badge)
      leadingIcon: string|null (MYDS icon name)
      trailingIcon: string|null (MYDS icon name)
      class: string|null (additional classes)
--}}
@props([
  'variant' => 'primary',
  'size' => 'md',
  'disabled' => false,
  'as' => 'button',
  'href' => null,
  'type' => 'button',
  'iconOnly' => false,
  'ariaLabel' => null,
  'counter' => null,
  'leadingIcon' => null,
  'trailingIcon' => null,
  'class' => '',
])

@php
  $base = 'myds-btn focus-ring-primary font-inter transition-all';
  $vClass = match($variant) {
    'secondary' => 'btn-secondary',
    'tertiary' => 'btn-tertiary',
    'danger' => 'btn-danger',
    default => 'btn-primary',
  };
  $sClass = match($size) {
    'sm' => 'btn-sm',
    'lg' => 'btn-lg',
    default => 'btn-md',
  };
  $classes = trim("{$base} {$vClass} {$sClass} {$class}");
@endphp

<x-myds.tokens />

@if ($as === 'a')
  <a
    href="{{ $href ?? '#' }}"
    class="{{ $classes }}"
    @if($disabled) aria-disabled="true" tabindex="-1" @endif
    @if($iconOnly && $ariaLabel) aria-label="{{ $ariaLabel }}" @endif
  >
    @if($leadingIcon)
      <x-myds.icons :name="$leadingIcon" class="myds-icon mr-1" />
    @endif
    @if(!$iconOnly)
      {{ $slot }}
      @if($counter)
  {{-- Komponen Butang MYDS (BM, Aksesibiliti, Ikon, Token) --}}
  @props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, success, warning
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'iconPosition' => 'leading', // leading, trailing
    'disabled' => false,
    'block' => false,
    'ariaLabel' => null,
  ])

  @php
    $base = 'inline-flex items-center justify-center font-inter font-medium transition focus:outline-none focus:ring focus:ring-primary-300';
    $sizes = [
      'sm' => 'text-xs px-3 py-1.5 rounded',
      'md' => 'text-sm px-4 py-2 rounded-md',
      'lg' => 'text-base px-6 py-3 rounded-lg',
    ];
    $variants = [
      'primary' => 'bg-primary-600 text-white hover:bg-primary-700',
      'secondary' => 'bg-secondary-600 text-white hover:bg-secondary-700',
      'danger' => 'bg-danger-600 text-white hover:bg-danger-700',
      'success' => 'bg-success-600 text-white hover:bg-success-700',
      'warning' => 'bg-warning-500 text-black hover:bg-warning-600',
    ];
    $disabledClass = 'opacity-50 cursor-not-allowed';
    $blockClass = $block ? 'w-full' : '';
    $iconSize = $size === 'lg' ? 'w-6 h-6' : ($size === 'sm' ? 'w-4 h-4' : 'w-5 h-5');
  @endphp

  <button
    type="{{ $type }}"
    @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    {{ $disabled ? 'disabled' : '' }}
    class="{{ $base }} {{ $sizes[$size] }} {{ $variants[$variant] }} {{ $blockClass }} {{ $disabled ? $disabledClass : '' }}"
  >
    @if($icon && $iconPosition === 'leading')
      <span class="mr-2 {{ $iconSize }} flex-shrink-0" aria-hidden="true">{!! $icon !!}</span>
    @endif
    <span>{{ $slot }}</span>
    @if($icon && $iconPosition === 'trailing')
      <span class="ml-2 {{ $iconSize }} flex-shrink-0" aria-hidden="true">{!! $icon !!}</span>
    @endif
  </button>
      @endif
    @endif
    @if($trailingIcon)
      <x-myds.icons :name="$trailingIcon" class="myds-icon ml-1" />
    @endif
  </a>
@else
  <button
    type="{{ $type }}"
    class="{{ $classes }}"
    @if($disabled) disabled @endif
    @if($iconOnly && $ariaLabel) aria-label="{{ $ariaLabel }}" @endif
  >
    @if($leadingIcon)
      <x-myds.icons :name="$leadingIcon" class="myds-icon mr-1" />
    @endif
    @if(!$iconOnly)
      {{ $slot }}
      @if($counter)
        <span class="bg-black-100 txt-black-900 radius-full px-2 py-0.5 ml-1 text-xs align-middle">{{ $counter }}</span>
      @endif
    @endif
    @if($trailingIcon)
      <x-myds.icons :name="$trailingIcon" class="myds-icon ml-1" />
    @endif
  </button>
@endif
