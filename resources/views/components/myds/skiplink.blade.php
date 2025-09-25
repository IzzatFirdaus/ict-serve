<x-ictserve.skiplink {{ $attributes->merge([]) }}>
    {{ $slot }}
</x-ictserve.skiplink>
{{--
  Skip Link component for ICTServe (iServe)
  - Accessible, visible on focus; neutral naming (non-branded)
  - Props:
    href: target section id (default '#main-content')
    label: visible text (default: "Langkau ke kandungan utama")
--}}

@props([
  'href' => '#main-content',
  'label' => 'Langkau ke kandungan utama',
])
@once
  <link rel="stylesheet" href="{{ asset('css/shared/skip-link.css') }}" />
@endonce

<a href="{{ $href }}" class="skip-link" aria-label="{{ $label }}">
  {{ $label }}
</a>
