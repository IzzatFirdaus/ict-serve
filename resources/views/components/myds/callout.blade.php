@props([
    'variant' => 'info',
    'dismissible' => false,
    'title' => null,
])

@php
    // MYDS callout styling with proper semantic tokens
    $baseClasses = 'flex gap-3 rounded-lg border-l-4 p-4 font-inter';

    $variantClasses = match($variant) {
        'success' => 'bg-success-50 border-l-success-500 text-success-900',
        'warning' => 'bg-warning-50 border-l-warning-500 text-warning-900',
        'danger', 'error' => 'bg-danger-50 border-l-danger-500 text-danger-900',
        'info' => 'bg-primary-50 border-l-primary-500 text-primary-900',
        default => 'bg-primary-50 border-l-primary-500 text-primary-900',
    };

    $iconColor = match($variant) {
        'success' => 'text-success-600',
        'warning' => 'text-warning-600',
        'danger', 'error' => 'text-danger-600',
        'info' => 'text-primary-600',
        default => 'text-primary-600',
    };
@endphp

<div class="{{ $baseClasses }} {{ $variantClasses }}" role="alert" {{ $attributes }}>
    <!-- Icon -->
    <div class="flex-shrink-0">
        @switch($variant)
            @case('success')
                <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.53 10.53a.75.75 0 00-1.06 1.061l1.5 1.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                @break
            @case('warning')
                <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                @break
            @case('danger')
            @case('error')
                <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                @break
            @default
                <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
        @endswitch
    </div>

    <!-- Content -->
    <div class="flex-1 min-w-0">
        @if($title)
            <h3 class="text-sm font-semibold mb-1">{{ $title }}</h3>
        @endif
        <div class="text-sm">
            {{ $slot }}
        </div>
    </div>

    <!-- Dismiss button -->
    @if($dismissible)
        <div class="flex-shrink-0">
            <button type="button"
                class="inline-flex rounded-md p-1.5 transition-colors duration-200 hover:bg-black-900/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                onclick="this.closest('[role=alert]').remove()"
                aria-label="Tutup">
                <svg class="h-5 w-5 {{ $iconColor }}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            {{-- Komponen Callout MYDS (BM, Aksesibiliti, Token, Ikon) --}}
            @props([
                'variant' => 'info', // info, success, warning, danger
                'icon' => null,
                'dismissible' => false,
                'ariaLabel' => null,
            ])

            @php
                $variants = [
                    'info' => 'bg-primary-50 text-primary-600 border-primary-200',
                    'success' => 'bg-success-50 text-success-600 border-success-200',
                    'warning' => 'bg-warning-50 text-warning-700 border-warning-200',
                    'danger' => 'bg-danger-50 text-danger-600 border-danger-200',
                ];
                $icons = [
                    'info' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="9"/><path d="M10 14v-4M10 7h.01"/></svg>',
                    'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="9"/><path d="M7 10l2 2 4-4"/></svg>',
                    'warning' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="9"/><path d="M10 7v3m0 4h.01"/></svg>',
                    'danger' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true"><circle cx="10" cy="10" r="9"/><path d="M10 7v3m0 4h.01"/></svg>',
                ];
            @endphp

            <div
                class="relative flex items-start gap-3 p-4 border border-divider rounded-md {{ $variants[$variant] }}"
                @if($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
                role="alert"
            >
                <span class="flex-shrink-0 mt-0.5" aria-hidden="true">
                    {!! $icon ?? $icons[$variant] !!}
                </span>
                <div class="flex-1">
                    {{ $slot }}
                </div>
                @if($dismissible)
                    <button type="button" class="absolute top-2 right-2 text-black-400 hover:text-black-900 focus:outline-none focus:ring focus:ring-primary-300 rounded transition" aria-label="Tutup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M6 6l8 8M6 14L14 6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                @endif
            </div>
                </svg>
            </button>
        </div>
    @endif
</div>
