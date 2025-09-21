@props(['class' => ''])
<div
  {{ $attributes->merge(['class' => 'hidden md:flex gap-0.5 items-center flex-1 justify-center ' . $class]) }}
>
  {{ $slot }}
</div>
