@props([
  'variant' => 'primary',
  //primary,
  'secondary',
  'secondary-colour',
  'tertiary',
  'tertiary-colour',
  'danger-primary',
  'danger-secondary',
  'danger-tertiary',
  'size' => 'medium',
  //small,
  'medium',
  'large',
  'type' => 'button',
  //button,
  'submit',
  'reset',
  'disabled' => false,
  'loading' => false,
  'iconLeading' => null,
  'iconTrailing' => null,
  'counter' => null,
  'iconOnly' => false,
])

@php
  $baseClasses = 'myds-button relative inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2';

  // Size classes
  $sizeClasses = match ($size) {
    'small' => 'px-3 py-1.5 text-sm gap-1.5',
    'large' => 'px-6 py-3 text-lg gap-3',
    'default' => 'px-4 py-2 text-sm',
    default => 'px-4 py-2 text-sm', // medium
  };

  // Icon-only sizing
  if ($iconOnly) {
    $sizeClasses = match ($size) {
      'small' => 'p-1.5',
      'large' => 'p-3',
      default => 'p-2',
    };
  }

  // Variant classes based on MYDS specifications
  $variantClasses = match ($variant) {
    'primary' => 'bg-blue-600 text-white border border-blue-600 hover:bg-blue-700 hover:border-blue-700 focus:ring-blue-500 active:translate-y-0.5',
    'secondary' => 'bg-white text-gray-900 border border-gray-300 hover:bg-gray-50 hover:border-gray-400 focus:ring-blue-500 active:translate-y-0.5',
    'secondary-colour' => 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 hover:border-blue-300 focus:ring-blue-500 active:translate-y-0.5',
    'tertiary' => 'bg-transparent text-gray-700 border-0 hover:bg-gray-100 focus:ring-blue-500 active:translate-y-0.5',
    'tertiary-colour' => 'bg-transparent text-blue-600 border-0 hover:bg-blue-50 focus:ring-blue-500 active:translate-y-0.5',
    'danger-primary' => 'bg-red-600 text-white border border-red-600 hover:bg-red-700 hover:border-red-700 focus:ring-red-500 active:translate-y-0.5',
    'danger-secondary' => 'bg-white text-red-700 border border-red-300 hover:bg-red-50 hover:border-red-400 focus:ring-red-500 active:translate-y-0.5',
    'danger-tertiary' => 'bg-transparent text-red-600 border-0 hover:bg-red-50 focus:ring-red-500 active:translate-y-0.5',
    'danger' => 'bg-danger-600 text-white hover:bg-danger-700 focus:ring-fr-danger',
    'success' => 'bg-success-600 text-white hover:bg-success-700 focus:ring-fr-success',
    'outline' => 'border border-otl-gray-300 text-txt-black-900 hover:bg-gray-50 focus:ring-fr-primary',
    default => 'bg-blue-600 text-white border border-blue-600 hover:bg-blue-700 hover:border-blue-700 focus:ring-blue-500 active:translate-y-0.5',
  };

  // Disabled state
  if ($disabled || $loading) {
    $variantClasses = 'bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed active:translate-y-0';
  }

  $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses);
@endphp

<button
  type="{{ $type }}"
  {{ $attributes->merge([
    'class' => "$baseClasses $sizeClasses $variantClasses",
    'aria-disabled' => $disabled ? 'true' : null,
    'disabled' => $disabled,
  ]) }}
>
  @if ($iconLeading)
    <span class="mr-2">{{ $iconLeading }}</span>
  @endif
  {{ $slot }}
  @if ($iconTrailing)
    <span class="ml-2">{{ $iconTrailing }}</span>
  @endif
</button>
