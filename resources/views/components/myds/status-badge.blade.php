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
  'variant' => 'filled', // filled | outline | subtle
  'icon' => null,
  'dismissible' => false,
])

@php
  $base = 'inline-flex items-center justify-center font-medium rounded-full';
  $sizeCls = match ($size) {
    'small' => 'px-2 py-0.5 text-xs gap-1',
    'large' => 'px-4 py-2 text-base gap-2',
    default => 'px-3 py-1 text-sm gap-1.5',
  };

  // Token set mapping
  $tone = match ($status) {
    'success' => ['txt' => 'txt-success', 'bg' => 'bg-success-600', 'bgSubtle' => 'bg-success-50', 'bd' => 'border-otl-success-300'],
    'warning' => ['txt' => 'txt-warning', 'bg' => 'bg-warning-600', 'bgSubtle' => 'bg-warning-50', 'bd' => 'border-otl-warning-300'],
    'danger' => ['txt' => 'txt-danger', 'bg' => 'bg-danger-600', 'bgSubtle' => 'bg-danger-50', 'bd' => 'border-otl-danger-300'],
    'primary' => ['txt' => 'txt-primary', 'bg' => 'bg-primary-600', 'bgSubtle' => 'bg-primary-50', 'bd' => 'border-otl-primary-300'],
    default => ['txt' => 'txt-black-700', 'bg' => 'bg-black-300', 'bgSubtle' => 'bg-black-100', 'bd' => 'border-otl-gray-300'],
  };

  $modeCls = match ($variant) {
    'outline' => "bg-white {$tone['txt']} border {$tone['bd']}",
    'subtle' => "{$tone['bgSubtle']} {$tone['txt']}",
    default => "{$tone['bg']} txt-white",
  };

  $classes = trim("$base $sizeCls $modeCls");
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
  @if ($icon)
    <span class="inline-flex items-center" aria-hidden="true">
      {!! $icon !!}
    </span>
  @endif

  <span class="myds-badge-text">{{ $slot }}</span>
  @if ($dismissible)
    <button
      type="button"
      class="ml-1 hover:opacity-80 transition-opacity"
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
