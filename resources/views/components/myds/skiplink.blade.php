{{--
  MYDS Skip Link for ICTServe (iServe)
  - Accessible, visible on focus, follows MYDS guidance and MyGovEA
  - Props:
  href: target section id (default '#main-content')
  label: visible text (default: "Langkau ke kandungan utama")
--}}

@props([
  'href' => '#main-content',
  'label' => 'Langkau ke kandungan utama',
])
@once
  <link rel="stylesheet" href="{{ asset('css/myds/skiplink.css') }}" />
@endonce

<a href="{{ $href }}" class="myds-skip-link" aria-label="{{ $label }}">
  {{ $label }}
</a>
