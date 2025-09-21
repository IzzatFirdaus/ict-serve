@props(['class' => ''])
<div
  {{ $attributes->merge(['class' => 'flex items-center gap-x-2 ' . $class]) }}
>
  {{ $slot }}
</div>
