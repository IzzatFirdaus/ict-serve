{{--
  MYDS Grid Item for ICTServe (iServe)
  - Standards: MYDS grid, spacing, tokens.
  - Principles: MyGovEA (struktur hierarki, fleksibel, minimalis).
  - Usage:
      <x-myds.grid-item span="6" md="4" sm="4" class="bg-white">...</x-myds.grid-item>
  - Props:
      span: int|string (number of columns to span, default 1)
      md: int|string|null (columns span on md breakpoint)
      sm: int|string|null (columns span on sm breakpoint)
      lg: int|string|null (columns span on lg breakpoint)
      class: string|null
      as: string ('div'|'section'|...; default: 'div')
--}}
@props([
  'span' => 1,
  'md' => null,
  'sm' => null,
  'lg' => null,
  'class' => '',
  'as' => 'div',
])

@php
  // Build responsive col-span classes
  $classes = [];
  if ($span) $classes[] = 'col-span-' . $span;
  if ($sm) $classes[] = 'sm:col-span-' . $sm;
  if ($md) $classes[] = 'md:col-span-' . $md;
  if ($lg) $classes[] = 'lg:col-span-' . $lg;
@endphp

<{{ $as }} {{ $attributes->merge(['class' => implode(' ', $classes) . ' ' . $class]) }}>
  {{ $slot }}
</{{ $as }}>
