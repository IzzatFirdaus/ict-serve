{{--
  MYDS Dropdown for ICTServe (iServe)
  - Compliant with MYDS standards (Design, Develop, Icons, Colour) and MyGovEA principles.
  - Keyboard accessible, ARIA, focus ring, semantic tokens, responsive, citizen-centric.
  - Usage:
      <x-myds.dropdown label="Options">
        <x-myds.dropdown-item href="/profile">Profile</x-myds.dropdown-item>
        <x-myds.dropdown-item variant="danger">Logout</x-myds.dropdown-item>
      </x-myds.dropdown>
--}}
@props([
    'label' => 'Pilihan',
    'variant' => 'default', // default, primary, danger
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'align' => 'end', // start, end, center (menu alignment)
])

<x-myds.tokens />

@php
$buttonClasses = match($variant) {
    'primary' => 'bg-primary-600 txt-white border-otl-primary-200 hover:bg-primary-700 focus-ring-primary',
    'danger' => 'bg-danger-600 txt-white border-otl-danger-200 hover:bg-danger-700 focus-ring-danger',
    default => 'bg-white txt-black-700 border-otl-gray-200 hover:bg-gray-50 focus-ring-primary',
};
$sizeClasses = match($size) {
    'sm' => 'px-3 py-2 text-sm',
    'lg' => 'px-6 py-3 text-lg',
    default => 'px-4 py-2.5 text-base',
};
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }" @keydown.escape.window="open = false" @click.away="open = false">
    <!-- Trigger Button: Accessible, MYDS tokens, ARIA, visible focus -->
    <button type="button"
            @click="open = !open"
            :aria-expanded="open"
            aria-haspopup="true"
            aria-controls="dropdown-menu"
            {{ $disabled ? 'disabled' : '' }}
            class="inline-flex justify-center items-center w-full radius-m border font-medium transition ease-easeout duration-200 focus:outline-none focus-ring-primary {{ $buttonClasses }} {{ $sizeClasses }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
    >
        {{ $label }}
        <x-myds.icons.chevron-down class="ml-2 -mr-1 myds-icon" />
    </button>

    <!-- Dropdown Menu: Menu role, shadow, semantic tokens, ARIA -->
    <div
        x-show="open"
        x-transition:enter="transition ease-easeout duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-easeout duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute {{ $align === 'start' ? 'left-0' : ($align === 'center' ? 'left-1/2 -translate-x-1/2' : 'right-0') }} z-10 mt-2 w-56 origin-top-{{ $align }} divide-y divide-otl-divider radius-l bg-white shadow-context-menu border border-otl-divider"
        style="min-width:12rem;"
        id="dropdown-menu"
        role="menu"
        aria-label="Senarai Pilihan"
        tabindex="-1"
    >
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>
