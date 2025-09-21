@props(['src' => null, 'alt' => ''])
<div class="inline-flex items-center gap-2">
  @if ($src)
    <img
      src="{{ $src }}"
      alt="{{ $alt }}"
      class="h-8 w-auto object-contain"
    />
  @endif
</div>
