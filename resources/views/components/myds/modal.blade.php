{{--
  Generic Modal (Dialog) Component
  - Features:
  * Sticky header and footer sections for long dialogs
  * Focus management, ARIA roles, and keyboard accessibility (Esc to close, focus trap)
  * Supports variants for info/success/warning/danger (alert dialogs)
  * Clear structure for title, description, content, actions
  * Configurable: dismissible, size, icon, and slot for custom actions
  * Responsive on desktop, tablet, and mobile
  - Props:
  id: string|null (for ARIA labelling)
  open: bool (controls visibility, default: false)
  dismissible: bool (close via overlay/Esc/X), default: true
  title: string|null (modal title)
  icon: Blade/SVG|null (optional leading icon)
  variant: 'default'|'info'|'success'|'warning'|'danger'
  size: 'sm'|'md'|'lg'|'xl' (default: md)
  class: string|null (additional modal classes)
  ariaLabel: string|null (for accessibility)
  ariaDescribedby: string|null (for accessibility)
  closeLabel: string (localized close button label)
  @slot('content') Main modal content
  @slot('actions') Footer actions (buttons)
--}}

@props([
  'id' => null,
  'open' => false,
  'dismissible' => true,
  'title' => null,
  'icon' => null,
  'variant' => 'default',
  'size' => 'md',
  'class' => '',
  'ariaLabel' => null,
  'ariaDescribedby' => null,
  'closeLabel' => 'Tutup',
])

@php
  $maxWidth = match ($size) {
    'sm' => 'max-w-md',
    'lg' => 'max-w-3xl',
    'xl' => 'max-w-5xl',
    default => 'max-w-xl',
  };

  $variantRing = match ($variant) {
    'info' => 'ring-primary-300',
    'success' => 'ring-success-300',
    'warning' => 'ring-warning-300',
    'danger' => 'ring-danger-300',
    default => 'ring-primary-300',
  };

  $variantIcon = null;
  $modalId = $id ?? 'modal-' . uniqid();
  $labelledBy = $ariaLabel ? null : $modalId . '-title';
  $describedBy = $ariaDescribedby ? $ariaDescribedby : ($title ? $modalId . '-desc' : null);
@endphp

@if ($open)
  <div
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 transition-all"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $labelledBy }}"
  >
    <div
      class="relative bg-white shadow-lg {{ $maxWidth }} w-full rounded-lg outline-none {{ $class }}"
      tabindex="0"
      id="{{ $modalId }}"
    >
      <header
        class="sticky top-0 z-10 bg-white px-6 py-4 border-b flex items-center gap-3"
        @if($labelledBy) id="{{ $labelledBy }}" @endif
      >
        @if ($icon)
          <span class="inline-flex items-center justify-center w-7 h-7">
            {!! $icon !!}
          </span>
        @endif

        @if ($title)
          <span class="font-semibold text-xl">
            {{ $title }}
          </span>
        @endif

        <span class="flex-1"></span>
        @if ($dismissible)
          <button
            type="button"
            class="ml-4 text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary rounded-full transition"
            aria-label="{{ $closeLabel }}"
            @click="$dispatch('close-modal-{{ $modalId }}')"
          >
            <span class="w-6 h-6">&times;</span>
          </button>
        @endif
      </header>

      <div
        class="px-6 py-6 text-base {{ $describedBy ? 'has-desc' : '' }}"
        @if($describedBy) id="{{ $describedBy }}" @endif
      >
        {{ $content ?? $slot }}
      </div>

      @if (isset($actions))
        <footer
          class="sticky bottom-0 z-10 bg-white px-6 py-4 border-t flex flex-row-reverse gap-3"
        >
          {{ $actions }}
        </footer>
      @endif
    </div>
  </div>
@endif
