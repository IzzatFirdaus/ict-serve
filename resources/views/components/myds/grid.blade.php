{{--
  MYDS Grid Container for ICTServe (iServe)
  - Standards: MYDS 12/8/4 responsive grid, spacing, semantic tokens.
  - Principles: MyGovEA (hierarki, minimalis, seragam, responsif).
  - Usage:
      <x-myds.grid cols="12" gap="4">
        <x-myds.grid-item span="6">...</x-myds.grid-item>
        <x-myds.grid-item span="6">...</x-myds.grid-item>
      </x-myds.grid>
  - Props:
      cols: int (4|8|12; default: 12)
      gap: int (4,8,12,16,24; default: 24)
      as: string ('div'|'section'|...; default: 'div')
      class: string|null
--}}
@props([
  'cols' => 12,
  'gap' => 24,
  'as' => 'div',
  'class' => '',
])

@php
  // Responsive grid class builder
  $colsClass = match((int)$cols) {
    4 => 'grid-cols-4 sm:grid-cols-4 md:grid-cols-8 lg:grid-cols-12',
    8 => 'grid-cols-4 sm:grid-cols-8 md:grid-cols-8 lg:grid-cols-12',
    12 => 'grid-cols-4 sm:grid-cols-8 md:grid-cols-12 lg:grid-cols-12',
    default => 'grid-cols-4 sm:grid-cols-8 md:grid-cols-12 lg:grid-cols-12',
  };
  $gapClass = 'gap-' . ((int)$gap);
@endphp

<x-myds.tokens />

<{{ $as }} {{ $attributes->merge(['class' => "grid $colsClass $gapClass $class"]) }}>
  {{ $slot }}
</{{ $as }}>
