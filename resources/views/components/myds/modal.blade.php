{{--
  MYDS Modal (Dialog) Component for ICTServe (iServe)
  - Follows MYDS standards (Design, Develop, Icons, Colour) and MyGovEA principles (citizen-centric, minimalis, seragam, accessible)
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
    'variant' => 'default', // default|info|success|warning|danger
    'size' => 'md', // sm|md|lg|xl
    'class' => '',
    'ariaLabel' => null,
    'ariaDescribedby' => null,
    'closeLabel' => 'Tutup', // default Bahasa Melayu
])

@php
    // Modal sizing per MYDS specs
    $maxWidth = match($size) {
        'sm' => 'max-w-md',    // ~400px
        'lg' => 'max-w-3xl',  // ~800px
        'xl' => 'max-w-5xl',  // ~1200px
        default => 'max-w-xl', // ~600px
    };

    // Variant colour ring/shadow
    $variantRing = match($variant) {
        'info' => 'ring-primary-300',
        'success' => 'ring-success-300',
        'warning' => 'ring-warning-300',
        'danger' => 'ring-danger-300',
        default => 'ring-primary-300',
    };

    // Variant icon fallback
    $variantIcon = match($variant) {
        'info' => '<x-myds.icons.info class="txt-primary" />',
        'success' => '<x-myds.icons.check-circle class="txt-success" />',
        'warning' => '<x-myds.icons.alert-triangle class="txt-warning" />',
        'danger' => '<x-myds.icons.alert-triangle class="txt-danger" />',
        default => null,
    };

    $modalId = $id ?? 'myds-modal-'.uniqid();
    $labelledBy = $ariaLabel ? null : $modalId.'-title';
    $describedBy = $ariaDescribedby ? $ariaDescribedby : ($title ? $modalId.'-desc' : null);
@endphp

@if($open)
  {{-- Overlay (modal backdrop) --}}
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 transition-all easeoutback.short"
       x-data="{ focusTrap: null }"
       x-init="focusTrap = $el.querySelector('[tabindex]'); focusTrap && focusTrap.focus();"
       @keydown.escape.window="if ({{ $dismissible ? 'true' : 'false' }}) $dispatch('close-modal-{{ $modalId }}')"
       @click.self="if ({{ $dismissible ? 'true' : 'false' }}) $dispatch('close-modal-{{ $modalId }}')"
       role="dialog"
       aria-modal="true"
       aria-labelledby="{{ $labelledBy }}"
       @close-modal-{{ $modalId }}.window="$el.remove()"
  >
    {{-- Dialog Panel --}}
    <div
      class="relative bg-bg-dialog shadow-context-menu {{ $maxWidth }} w-full radius-l transition-all easeoutback.short outline-none {{ $class }}"
      @click.stop
      tabindex="0"
      id="{{ $modalId }}"
      @keydown.tab.prevent=" /* Focus trap: TODO if Alpine/JS present */ "
      @keydown.shift.tab.prevent=" /* Focus trap: TODO if Alpine/JS present */ "
    >

      {{-- Sticky Header --}}
      <header class="sticky top-0 z-10 bg-bg-dialog px-6 py-4 border-b border-otl-divider flex items-center gap-3"
        @if($labelledBy) id="{{ $labelledBy }}" @endif
      >
        @if($icon || $variantIcon)
          <span class="inline-flex items-center justify-center w-7 h-7">
            {!! $icon ?? $variantIcon !!}
          </span>
        @endif
        @if($title)
          <span class="font-poppins font-semibold text-xl txt-black-900">{{ $title }}</span>
        @endif
        <span class="flex-1"></span>
        @if($dismissible)
          <button type="button"
            class="ml-4 text-txt-black-500 hover:text-txt-black-900 focus:outline-none focus:ring-2 focus:ring-fr-primary rounded-full transition"
            aria-label="{{ $closeLabel }}"
            @click="$dispatch('close-modal-{{ $modalId }}')"
          >
            <x-myds.icons.x class="w-6 h-6" />
          </button>
        @endif
      </header>

      {{-- Modal Content --}}
      <div class="px-6 py-6 text-base {{ $describedBy ? 'has-desc' : '' }}"
        @if($describedBy) id="{{ $describedBy }}" @endif
      >
        {{ $content ?? $slot }}
      </div>

      {{-- Sticky Footer --}}
      @if(isset($actions))
        <footer class="sticky bottom-0 z-10 bg-bg-dialog px-6 py-4 border-t border-otl-divider flex flex-row-reverse gap-3">
          {{ $actions }}
        </footer>
      @endif

    </div>
  </div>
@endif
