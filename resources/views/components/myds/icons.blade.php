{{--
  MYDS Icons Blade Registry for ICTServe (iServe)
  - Provides standard icon includes for MYDS-compliant applications
  - Follows 20x20 grid, 1.5px stroke, consistent names, and tokens (colour, size)
  - Social media and generic icons included; easy to extend for new icons
  - Usage: <x-myds.icons.[icon-name] :size="24" :class="'txt-primary'" />
  - Accessible: SVGs use currentColor for easy theming and support aria-hidden
  - Icons: Only MYDS official set (see MYDS-Icons-Overview.md)
--}}

{{-- Generic Icons --}}

@props([
  'size' => 20, // px, default MYDS grid
  'class' => '', // extra classes for sizing
  'colour' => null,
])

{{-- Example usage: <x-myds.icons.search size="24" class="txt-primary" /> --}}

@switch(trim($slot))
  @case('search')
    {{-- Search Icon --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <circle cx="9" cy="9" r="6" />
      <line x1="15" y1="15" x2="12.2" y2="12.2" />
    </svg>

    @break
  @case('chevron-down')
    {{-- Chevron Down Icon --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <polyline points="5 8 10 13 15 8" fill="none" />
    </svg>

    @break
  @case('alert-triangle')
    {{-- Alert Triangle (Danger/Warning) --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <polygon points="10 3 19 17 1 17 10 3" fill="none" />
      <line x1="10" y1="8" x2="10" y2="12" />
      <circle cx="10" cy="15" r="1" />
    </svg>

    @break
  @case('table')
    {{-- Table/List --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect x="3" y="5" width="14" height="10" rx="2" />
      <line x1="3" y1="9" x2="17" y2="9" />
      <line x1="7" y1="5" x2="7" y2="15" />
      <line x1="13" y1="5" x2="13" y2="15" />
    </svg>

    @break
  @case('document')
    {{-- Document --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect x="4" y="3" width="12" height="14" rx="2" />
      <line x1="8" y1="7" x2="12" y2="7" />
      <line x1="8" y1="11" x2="12" y2="11" />
    </svg>

    @break
  @case('info')
    {{-- Info --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      fill="none"
      viewBox="0 0 20 20"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <circle cx="10" cy="10" r="8" />
      <line x1="10" y1="7" x2="10" y2="11" />
      <circle cx="10" cy="14" r="1" />
    </svg>

    @break
    {{-- --- Social Media Icons (MYDS set) --- --}}
  @case('facebook')
    {{-- Facebook --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect
        x="2"
        y="2"
        width="16"
        height="16"
        rx="4"
        fill="currentColor"
        opacity="0.05"
      />
      <path
        d="M13.5 10.6h-2.3V16h-2.1v-5.4H7V8.7h2.1v-1c0-1.3.6-3 2.9-3 .6 0 1.3.1 1.3.1v1.8H13c-.7 0-.8.3-.8.7v1h2l-.2 1.9z"
        fill="currentColor"
      />
    </svg>

    @break
  @case('twitter')
    {{-- Twitter/X --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect
        x="2"
        y="2"
        width="16"
        height="16"
        rx="4"
        fill="currentColor"
        opacity="0.05"
      />
      <path
        d="M14.2 7.2L11.4 10l2.9 2.8h-1.7L10.5 10.9 9 12.8H7.5l2.8-2.8-2.7-2.8h1.7l1.3 1.3 1.4-1.3h1.2z"
        fill="currentColor"
      />
    </svg>

    @break
  @case('instagram')
    {{-- Instagram --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect
        x="2"
        y="2"
        width="16"
        height="16"
        rx="4"
        fill="currentColor"
        opacity="0.05"
      />
      <circle cx="10" cy="10" r="4.5" />
      <circle cx="14.2" cy="5.8" r="0.8" fill="currentColor" />
    </svg>

    @break
  @case('youtube')
    {{-- YouTube --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect
        x="2"
        y="2"
        width="16"
        height="16"
        rx="4"
        fill="currentColor"
        opacity="0.05"
      />
      <rect x="6" y="7" width="8" height="6" rx="2" />
      <polygon points="10.5,10 9,9.2 9,10.8" fill="currentColor" />
    </svg>

    @break
  @default
    {{-- Fallback X (missing icon) --}}
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="{{ $size }}"
      height="{{ $size }}"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      class="myds-icon {{ $class }}"
      aria-hidden="true"
    >
      <rect
        x="2"
        y="2"
        width="16"
        height="16"
        rx="4"
        stroke="currentColor"
        fill="none"
      />
      <line x1="4" y1="4" x2="16" y2="16" stroke="currentColor" />
      <line x1="16" y1="4" x2="4" y2="16" stroke="currentColor" />
    </svg>
@endswitch
