{{--
  MYDS Icon Component for ICTServe (iServe)
  - Follows MYDS standards: Design, Develop, Icons, Colour tokens, consistent grid and sizing
  - Fulfills MyGovEA principles: clear, seragam, accessible, minimalis, and citizen-centric
  - Usage:
      <x-myds.icon name="search" size="md" colour="primary" class="mr-2" />
      <x-myds.icon name="facebook" size="lg" colour="black-700" />
  - Props:
      name: string (required; icon name as per MYDS icon set)
      size: string ('xs'|'sm'|'md'|'lg'|'xl'|int px; default: 'md' = 20px)
      colour: string (MYDS token, e.g., 'primary', 'danger', 'success', 'black-700', etc; default: 'black-900')
      class: string|null (additional CSS classes)
      title: string|null (for accessibility)
      ariaLabel: string|null (for accessibility; if set, aria-hidden is false)
      type: 'outline'|'filled' (default: 'outline')
--}}
@props([
    'name',           // icon name (required)
    'size' => 'md',   // xs=16, sm=18, md=20, lg=24, xl=32, or int px
    'colour' => 'black-900', // MYDS colour token
    'class' => '',    // extra classes
    'title' => null,  // for accessibility
    'ariaLabel' => null, // for accessibility
    'type' => 'outline', // 'outline' or 'filled'
])

@php
    // Map size tokens to px as per MYDS icon spec
    $sizeMap = [
        'xs' => 16,
        'sm' => 18,
        'md' => 20,
        'lg' => 24,
        'xl' => 32,
    ];
    $iconSize = is_numeric($size) ? intval($size) : ($sizeMap[$size] ?? 20);

    // MYDS colour token to class
    $colourClass = match($colour) {
        'primary' => 'txt-primary',
        'danger' => 'txt-danger',
        'success' => 'txt-success',
        'warning' => 'txt-warning',
        'black-900' => 'txt-black-900',
        'black-700' => 'txt-black-700',
        'black-500' => 'txt-black-500',
        'white' => 'txt-white',
        default => 'txt-' . $colour,
    };

    // Accessibility
    $titleAttr = $title ? 'title="'.$title.'"' : '';
    $ariaAttrs = $ariaLabel
        ? 'role="img" aria-label="'.$ariaLabel.'"'
        : 'aria-hidden="true" focusable="false"';

    // Icon SVG repository: icons should be included as Blade partials or inline SVGs matching MYDS
    // Recommend: Place icons/svg/[name]-[type].blade.php (e.g., icons/svg/search-outline.blade.php)
    $iconBladePath = 'myds.icons.svg.' . $name . '-' . $type;
@endphp

<span class="inline-block align-middle {{ $class }}"
      style="width:{{ $iconSize }}px;height:{{ $iconSize }}px;line-height:0;"
      {!! $titleAttr !!}
      {!! $ariaAttrs !!}
>
    @if(view()->exists($iconBladePath))
        {{-- Render the SVG icon inline with currentColor and sizing --}}
        @include($iconBladePath, [
            'width' => $iconSize,
            'height' => $iconSize,
            'class' => "myds-icon $colourClass",
        ])
    @else
        {{-- Fallback for missing icon --}}
        <svg width="{{ $iconSize }}" height="{{ $iconSize }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" class="myds-icon {{ $colourClass }}">
            <rect x="2" y="2" width="16" height="16" rx="4" stroke="currentColor" fill="none"/>
            <line x1="4" y1="4" x2="16" y2="16" stroke="currentColor"/>
            <line x1="16" y1="4" x2="4" y2="16" stroke="currentColor"/>
        </svg>
    @endif
</span>
