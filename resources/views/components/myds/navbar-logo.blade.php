@props(['src' => null, 'alt' => '', 'href' => '/'])
<a href="{{ $href }}" class="inline-flex items-center" aria-label="{{ $alt }}">
  @if ($src)
    <img src="{{ $src }}" alt="{{ $alt }}" class="h-8 w-auto object-contain" />
  @else
    <span class="font-poppins font-semibold">MOTAC</span>
  @endif
</a>
