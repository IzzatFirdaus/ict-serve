@props([
    'label' => 'Options',
    'variant' => 'default', // default, primary, danger
    'size' => 'default', // sm, default, lg
    'disabled' => false,
])

@php
$buttonClasses = match($variant) {
    'primary' => 'bg-bg-primary-600 text-txt-white border-otl-primary-200 hover:bg-bg-primary-700 focus:ring-fr-primary',
    'danger' => 'bg-bg-danger-600 text-txt-white border-otl-danger-200 hover:bg-bg-danger-700 focus:ring-fr-danger',
    default => 'bg-bg-white text-txt-black-700 border-otl-gray-200 hover:bg-gray-50 focus:ring-fr-primary',
};

$sizeClasses = match($size) {
    'sm' => 'px-3 py-2 text-sm',
    'lg' => 'px-6 py-3 text-lg',
    default => 'px-4 py-2.5 text-base',
};
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
    <!-- Trigger Button -->
    <button type="button"
            @click="open = !open"
            @keydown.escape="open = false"
            :aria-expanded="open"
            aria-haspopup="true"
            {{ $disabled ? 'disabled' : '' }}
            class="inline-flex justify-center items-center w-full rounded-md border font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $buttonClasses }} {{ $sizeClasses }} {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">
        {{ $label }}
        <svg class="ml-2 -mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
    class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-otl-divider rounded-md bg-bg-white shadow-lg border border-otl-divider focus:outline-none"
        role="menu">
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>
