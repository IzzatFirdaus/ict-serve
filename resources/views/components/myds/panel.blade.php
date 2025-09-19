{{--
  MYDS Panel Component for ICTServe (iServe)
  - Follows MYDS standards (Design, Develop, Icons, Colour) and MyGovEA principles.
  - Variants: default | info | warning | danger | success
  - Accessible, responsive, and clear visual hierarchy for citizen-centric UI.
  - Props:
  variant: panel colour/status (default: 'default')
  title:   optional panel heading (string)
  icon:    optional Blade/SVG icon (defaults to MYDS icon by variant)
  compact: bool, if true uses less padding
  id:      optional id for ARIA labelling
  class:   additional CSS classes
--}}

@props([
  'variant' => 'default',
  'title' => null,
  'icon' => null,
  'compact' => false,
  'id' => null,
  'class' => '',
])

@php
  // Panel background & border tokens per MYDS/Colour Reference
  $variantClasses = [
    'info' => 'bg-primary-50 border-otl-primary-200',
    'success' => 'bg-success-50 border-otl-success-200',
    'warning' => 'bg-warning-50 border-otl-warning-200',
    'danger' => 'bg-danger-50 border-otl-danger-200',
    'default' => 'bg-white border-otl-divider',
  ];
  $panelClass = $variantClasses[$variant] ?? $variantClasses['default'];

  // Responsive padding (MYDS: 24px/32px on desktop, 16px/24px on mobile)
  $padding = $compact ? 'p-4 md:p-5' : 'p-6 md:p-8';

  // Fallback icon by variant (MYDS icons, see MYDS-Icons-Overview.md)
  $fallbackIcon = match ($variant) {
    'success' => '<x-myds.icons.check-circle class="w-5 h-5 txt-success" aria-hidden="true"/>',
    'warning' => '<x-myds.icons.alert-triangle class="w-5 h-5 txt-warning" aria-hidden="true"/>',
    'danger' => '<x-myds.icons.alert-triangle class="w-5 h-5 txt-danger" aria-hidden="true"/>',
    'info' => '<x-myds.icons.info class="w-5 h-5 txt-primary" aria-hidden="true"/>',
    default => null,
  };

  // ARIA role for status panels
  $role = in_array($variant, ['info', 'success', 'warning', 'danger']) ? 'status' : null;
  $panelId = $id ?? 'myds-panel-' . uniqid();
@endphp

<div
  id="{{ $panelId }}"
  class="rounded-l border {{ $padding }} {{ $panelClass }} {{ $class }}"
  {{ $attributes->except('class') }}
  @if($role) role="{{ $role }}" aria-live="polite" @endif
>
  @if ($title)
    <div class="flex items-start gap-3 mb-4">
      @if ($icon || $fallbackIcon)
        <span class="inline-flex items-center justify-center mt-0.5">
          {!! $icon ?? $fallbackIcon !!}
        </span>
      @endif

      <h2 class="font-poppins text-lg md:text-xl font-semibold txt-black-900">
        {{ $title }}
      </h2>
    </div>
  @endif

  <div class="font-inter text-base txt-black-900">
    {{ $slot }}
  </div>
</div>
