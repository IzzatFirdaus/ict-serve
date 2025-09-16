{{--
  MYDS Heading component for ICTServe (iServe)
  - Conforms to MYDS: typography scale, colour tokens, Poppins font, spacing, icon option
  - MyGovEA: clear hierarchy, accessibility, minimalis, citizen-centric
  - Props:
      level: 1-6 (HTML heading level, required)
      class: string|null (extra classes)
      icon: Blade/SVG|null (leading icon)
      sr: bool (screen-reader only)
      spacing: 'none'|'tight'|'default'|'loose'|'extra-loose' (vertical margin)
      variant: 'default'|'primary'|'secondary'|'muted'|'danger'|'success'|'warning'
      weight: 'light'|'normal'|'medium'|'semibold'|'bold'|'extrabold'
      size: string|null (override auto sizing)
--}}
@props([
  'level' => 1,
  'class' => '',
  'icon' => null,
  'sr' => false,
  'spacing' => 'default',
  'variant' => 'default',
  'weight' => 'semibold',
  'size' => null, // override auto sizing
])

@php
    // Default sizes for heading levels (MYDS typography scale)
    $defaultSize = match((int)$level) {
        1 => 'text-4xl md:text-5xl lg:text-6xl',
        2 => 'text-3xl md:text-4xl lg:text-5xl',
        3 => 'text-2xl md:text-3xl lg:text-4xl',
        4 => 'text-xl md:text-2xl lg:text-3xl',
        5 => 'text-lg md:text-xl lg:text-2xl',
        6 => 'text-base md:text-lg lg:text-xl',
        default => 'text-2xl md:text-3xl lg:text-4xl'
    };

    $sizeClasses = $size ?? $defaultSize;

    $weightClasses = match($weight) {
        'light' => 'font-light',
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'semibold' => 'font-semibold',
        'bold' => 'font-bold',
        'extrabold' => 'font-extrabold',
        default => 'font-semibold'
    };

    $variantClasses = match($variant) {
        'primary' => 'txt-primary',
        'secondary' => 'txt-black-700',
        'muted' => 'txt-black-500',
        'danger' => 'txt-danger',
        'success' => 'txt-success',
        'warning' => 'txt-warning',
        default => 'txt-black-900'
    };

    $spacingClasses = match($spacing) {
        'none' => 'mb-0',
        'tight' => 'mb-2',
        'default' => 'mb-4',
        'loose' => 'mb-6',
        'extra-loose' => 'mb-8',
        default => 'mb-4'
    };

    $headingTag = "h{$level}";
    $srClass = $sr ? 'sr-only' : '';
@endphp

<x-myds.tokens />

<{{ $headingTag }} {{ $attributes->merge(['class' => "font-poppins {$sizeClasses} {$weightClasses} {$variantClasses} {$spacingClasses} {$srClass} {$class} leading-tight tracking-tight"]) }}>
  @if($icon)
    <span class="inline-block align-middle mr-2">{!! $icon !!}</span>
  @endif
  {{ $slot }}
</{{ $headingTag }}>

@once
<link rel="stylesheet" href="{{ asset('css/myds/heading.css') }}" />
@endonce
