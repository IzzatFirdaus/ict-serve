{{--
    MYDS Alert/Callout Blade Component
    ==================================
    This is a full implementation of the MYDS "Callout" component,
    which is used to display contextual messages to the user.

    Props:
    - `type`: 'info' (default), 'success', 'warning', 'danger'. Controls the color and icon.
    - `dismissible`: (boolean) If true, a close button is shown. Defaults to false.
    - `title`: (string, optional) An optional bolded title for the alert.

    MyGovEA Principles Applied:
    - Komunikasi (Communication): Provides clear, color-coded feedback for user actions (e.g., success, error).
    - Pencegahan Ralat (Error Prevention): Used to display validation errors or warnings.
    - Seragam (Consistent): Provides a consistent, reusable alert format across the entire application, as specified in MYDS documentation.
--}}
@props([
    'type' => 'info',
    'dismissible' => false,
    'title' => null,
])

@php
    // Determine the appropriate classes and icon based on the alert type prop.
    // This logic centralizes styling decisions and keeps the HTML clean.
    //
    $variantClasses = match ($type) {
        'success' => [
            'container' => 'bg-success-50 dark:bg-success-950/50 border-success-500 dark:border-success-500',
            'icon' => 'text-success-500 dark:text-success-400',
            'title' => 'text-success-800 dark:text-success-200',
            'body' => 'text-success-700 dark:text-success-300',
            'icon_component' => 'heroicon-o-check-circle',
        ],
        'warning' => [
            'container' => 'bg-warning-50 dark:bg-warning-950/50 border-warning-500 dark:border-warning-500',
            'icon' => 'text-warning-500 dark:text-warning-400',
            'title' => 'text-warning-800 dark:text-warning-200',
            'body' => 'text-warning-700 dark:text-warning-300',
            'icon_component' => 'heroicon-o-exclamation-triangle',
        ],
        'danger' => [
            'container' => 'bg-danger-50 dark:bg-danger-950/50 border-danger-500 dark:border-danger-500',
            'icon' => 'text-danger-500 dark:text-danger-400',
            'title' => 'text-danger-800 dark:text-danger-200',
            'body' => 'text-danger-700 dark:text-danger-300',
            'icon_component' => 'heroicon-o-x-circle',
        ],
        default => [ // 'info' type
            'container' => 'bg-primary-50 dark:bg-primary-950/50 border-primary-500 dark:border-primary-500',
            'icon' => 'text-primary-500 dark:text-primary-400',
            'title' => 'text-primary-800 dark:text-primary-200',
            'body' => 'text-primary-700 dark:text-primary-300',
            'icon_component' => 'heroicon-o-information-circle',
        ],
    };
@endphp

{{-- Alpine.js is used to handle the show/hide state for dismissible alerts --}}
<div x-data="{ show: true }"
     x-show="show"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     {{ $attributes->merge(['class' => 'p-4 border-l-4 rounded-md flex items-start gap-3 ' . $variantClasses['container']]) }}
     role="alert"
>
    {{-- Leading Icon --}}
    <div class="flex-shrink-0">
        <x-dynamic-component :component="$variantClasses['icon_component']" :class="'h-6 w-6 ' . $variantClasses['icon']" aria-hidden="true" />
    </div>

    {{-- Alert Title and Content (Slot) --}}
    <div class="flex-grow">
        @if ($title)
            <h3 class="text-sm font-bold {{ $variantClasses['title'] }}">
                {{ $title }}
            </h3>
        @endif

        <div class="text-sm {{ $variantClasses['body'] }}">
            {{ $slot }}
        </div>
    </div>

    {{-- Dismissible Close Button --}}
    @if ($dismissible)
        <div class="flex-shrink-0">
            <button
                @click="show = false"
                type="button"
                class="inline-flex p-1 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $variantClasses['container'] }} {{ $variantClasses['icon'] }} focus:ring-{{$type}}-500"
                aria-label="Tutup"
            >
                <x-heroicon-o-x-mark class="h-5 w-5" />
            </button>
        </div>
    @endif
</div>
