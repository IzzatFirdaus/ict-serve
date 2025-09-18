{{--
  ICTServe (iServe) MYDS Spinner Component
  MYDS & MyGovEA Compliance:
    - Uses MYDS primary color tokens for spinner (text-txt-primary)
    - Animation follows MYDS motion tokens (smooth, 200ms)
    - Accessible with ARIA labels and screen reader support
    - Keyboard focusable when needed
    - Follows MYDS sizing scale (xs, sm, md, lg, xl)
    - Citizen-centric design: clear visual feedback for loading states
--}}

@props([
    'size' => 'md',
    'color' => 'primary',
    'class' => '',
    'label' => 'Loading...',
])

@php
$sizeClasses = [
    'xs' => 'w-3 h-3',
    'sm' => 'w-4 h-4',
    'md' => 'w-6 h-6',
    'lg' => 'w-8 h-8',
    'xl' => 'w-12 h-12'
];

$colorClasses = [
    'primary' => 'text-txt-primary',
    'white' => 'text-white',
    'black' => 'text-txt-black-900',
    'danger' => 'text-txt-danger',
    'success' => 'text-txt-success',
    'warning' => 'text-txt-warning'
];

$spinnerSize = $sizeClasses[$size] ?? $sizeClasses['md'];
$spinnerColor = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div
    class="inline-flex items-center justify-center {{ $class }}"
    role="status"
    aria-label="{{ $label }}"
    aria-live="polite"
>
    <svg
        class="animate-spin {{ $spinnerSize }} {{ $spinnerColor }}"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        aria-hidden="true"
        focusable="false"
    >
        <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
        ></circle>
        <path
            class="opacity-75"
            fill="currentColor"
            d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
    </svg>
    <span class="sr-only">{{ $label }}</span>
</div>
