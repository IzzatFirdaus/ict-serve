{{--
  MYDS Status Badge for ICTServe (iServe)
  - Variants: info | success | warning | danger | primary
  - Modes: filled | outline | subtle
  - Sizes: small | medium | large
  - Props: status, size, variant, icon (Blade/SVG), dismissible
  - A11y: Non-colour indicators via optional icon and clear text
--}}

@props([
  'status' => 'info',
  'size' => 'medium',
  'variant' => null, // optional override for badge variant
  'icon' => null,
  'dismissible' => false,
])

@php
  // Map incoming status to x-myds.badge variant names
  $variantMap = match (strtolower($status)) {
    'success' => 'success',
    'warning' => 'warning',
    'danger', 'error' => 'danger',
    'primary' => 'primary',
    'info' => 'info',
    default => 'secondary',
  };

  $sizeMap = match (strtolower($size)) {
    'small' => 'sm',
    'large' => 'lg',
    default => null,
  };

  $badgeVariant = $variant ?? $variantMap;
  $badgeSize = $sizeMap;
@endphp

<span {{ $attributes->only('class')->merge([]) }}>
  <x-myds.badge @if($badgeVariant) variant="{{ $badgeVariant }}" @endif @if($badgeSize) size="{{ $badgeSize }}" @endif>
    @if ($icon)
      <span class="inline-flex items-center mr-1" aria-hidden="true">{!! $icon !!}</span>
    @endif

    <span class="myds-badge-text">{{ $slot }}</span>
  </x-myds.badge>

  @if ($dismissible)
    <button
      type="button"
      class="ml-2 inline-flex items-center p-1 rounded hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
      aria-label="Tutup"
      onclick="this.closest('span').remove()"
    >
      <svg
        class="w-3 h-3"
        viewBox="0 0 20 20"
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        aria-hidden="true"
      >
        <line x1="5" y1="5" x2="15" y2="15"></line>
        <line x1="15" y1="5" x2="5" y2="15"></line>
      </svg>
    </button>
  @endif
</span>
