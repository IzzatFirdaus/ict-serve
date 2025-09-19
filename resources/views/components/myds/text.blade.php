{{--
  MYDS Text for ICTServe (iServe)
  - Props: size (xs|sm|base|lg|xl), variant, weight (light|normal|medium|semibold|bold), spacing (none|tight|default|loose)
  - Uses Inter font per MYDS body typography
--}}

@props([
  'size' => 'base',
  'variant' => 'default',
  'weight' => 'normal',
  'spacing' => 'default',
])

@php
  $sizeClasses = match ($size) {
    'xs' => 'text-xs',
    'sm' => 'text-sm',
    'lg' => 'text-lg',
    'xl' => 'text-xl',
    default => 'text-base',
  };

  $variantClasses = match ($variant) {
    'primary' => 'txt-primary',
    'secondary' => 'txt-black-700',
    'muted' => 'txt-black-500',
    'danger' => 'txt-danger',
    'success' => 'txt-success',
    'warning' => 'txt-warning',
    'white' => 'txt-white',
    default => 'txt-black-900',
  };

  $weightClasses = match ($weight) {
    'light' => 'font-light',
    'medium' => 'font-medium',
    'semibold' => 'font-semibold',
    'bold' => 'font-bold',
    default => 'font-normal',
  };

  $spacingClasses = match ($spacing) {
    'none' => 'mb-0',
    'tight' => 'mb-2',
    'loose' => 'mb-6',
    default => 'mb-4',
  };
@endphp

<p
  {{ $attributes->merge(['class' => "font-inter {$sizeClasses} {$variantClasses} {$weightClasses} {$spacingClasses} leading-relaxed"]) }}
>
  {{ $slot }}
</p>

@once
  <link rel="stylesheet" href="{{ asset('css/myds/text.css') }}" />
@endonce
