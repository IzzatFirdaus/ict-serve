@props([
    'variant' => 'info', // info, success, warning, danger
    'dismissible' => false,
    'icon' => true,
    'title' => null
])

@php
    $baseClasses = 'rounded-myds-md p-4 border';

    // Variant classes using MYDS color tokens
    $variantClasses = match($variant) {
        'success' => 'bg-success-50 border-success-200 text-success-800 dark:bg-success-900/20 dark:border-success-800 dark:text-success-200',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800 dark:bg-warning-900/20 dark:border-warning-800 dark:text-warning-200',
        'danger' => 'bg-danger-50 border-danger-200 text-danger-800 dark:bg-danger-900/20 dark:border-danger-800 dark:text-danger-200',
        default => 'bg-primary-50 border-primary-200 text-primary-800 dark:bg-primary-900/20 dark:border-primary-800 dark:text-primary-200' // info
    };

    $iconColor = match($variant) {
        'success' => 'text-success-600 dark:text-success-400',
        'warning' => 'text-warning-600 dark:text-warning-400',
        'danger' => 'text-danger-600 dark:text-danger-400',
        default => 'text-primary-600 dark:text-primary-400'
    };

    $classes = trim($baseClasses . ' ' . $variantClasses);
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     {{ $attributes->merge(['class' => $classes]) }}
     role="alert">

    <div class="flex items-start space-x-3">
        @if($icon)
            <div class="flex-shrink-0 {{ $iconColor }}">
                @switch($variant)
                    @case('success')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        @break
                    @case('warning')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        @break
                    @case('danger')
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        @break
                    @default
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                @endswitch
            </div>
        @endif

        <div class="flex-1 min-w-0">
            @if($title)
                <h4 class="text-sm font-semibold font-poppins mb-1">{{ $title }}</h4>
            @endif
            <div class="text-body-sm myds-body">
                {{ $slot }}
            </div>
        </div>

        @if($dismissible)
            <div class="flex-shrink-0">
                <button @click="show = false"
                        class="inline-flex rounded-myds-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors {{ $iconColor }} hover:bg-black/5 dark:hover:bg-white/5 focus:ring-current">
                    <span class="sr-only">{{ __('Dismiss') }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</div>
