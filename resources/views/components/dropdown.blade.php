{{--
  ICTServe (iServe) Dropdown Component
  MYDS & MyGovEA Compliance:
  - Uses MYDS Dropdown Menu pattern (see MYDS-Design-Overview.md: Dropdown, Context Menu).
  - Colour: bg-white, shadow-context-menu, otl-divider, radius-m (8px) (MYDS-Colour-Reference.md).
  - Spacing: px-0 py-1 (menu), px-4 py-2 (items).
  - Focus: Focus ring on open, keyboard navigation, ARIA roles.
  - Animations: MYDS motion system (easeoutback.short, 200ms).
  - Accessible: ARIA, tab navigation, role="menu", role="menuitem".
  - Minimal, clear, consistent (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
  'align' => 'end',
  'width' => '48',
  'contentClasses' => '',
])

@php
  $alignmentClasses = match ($align) {
    'left' => 'origin-top-left start-0',
    'center' => 'origin-top',
    default => 'origin-top-right end-0',
  };
  $widthClass = match ($width) {
    '48' => 'w-48',
    default => $width,
  };
@endphp

<div
  class="relative"
  x-data="{ open: false }"
  @click.outside="open = false"
  @keydown.escape.window="open = false"
>
  {{-- Trigger --}}
  <div
    @click="open = !open"
    @keydown.enter.prevent="open = !open"
    tabindex="0"
    aria-haspopup="menu"
    aria-expanded="open"
  >
    {{ $trigger }}
  </div>

  {{-- Dropdown Menu --}}
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="absolute z-50 mt-2 {{ $widthClass }} rounded-md shadow-context-menu {{ $alignmentClasses }}"
    x-cloak
    tabindex="-1"
    role="menu"
    aria-orientation="vertical"
    @keydown.arrow-down.prevent="$el.querySelector('[role=menuitem]')?.focus()"
    @keydown.tab="open = false"
  >
    <div
      class="rounded-md border border-otl-divider bg-white py-1 px-0 focus:outline-none {{ $contentClasses }}"
    >
      {{ $content }}
    </div>
  </div>
</div>
