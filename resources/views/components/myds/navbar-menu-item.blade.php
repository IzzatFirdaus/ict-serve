@props(['href' => '#', 'active' => false])
<a href="{{ $href }}" @class(["px-3 py-2 text-sm font-medium transition-colors rounded-s", $active ? 'txt-primary border-b-2 border-otl-primary-200 font-semibold bg-washed' : 'txt-black-700 hover:txt-primary hover:bg-washed']) aria-current="{{ $active ? 'page' : false }}">
  {{ $slot }}
</a>
