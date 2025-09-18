{{--
  MYDS Icon Component - Malaysia Government Design System Compliance

  MYDS & MyGovEA Compliance:
    - Icon system: 20x20 grid, 1.5px stroke width, scalable (MYDS-Icons-Overview.md).
    - All icons follow MYDS design principles and accessibility guidelines.
    - Uses "currentColor" for dynamic theming with MYDS semantic tokens.
    - ARIA: Decorative by default (aria-hidden), supports aria-label for meaningful icons.
    - Follows MyGovEA principles: minimalist, consistent, accessible.
--}}

@props([
    'name',
    'class' => 'w-5 h-5',
    'ariaLabel' => null,
])

@php
    // MYDS Icon Paths: 20x20 grid, stroke-width=1.5, following MYDS-Icons-Overview.md
    $icons = [
        // Generic Icons
        'check' => '<path d="M5 10.5l4 4 6-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'check-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 10.5l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>',
        'clock' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 6v4l2.5 2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'cube' => '<path d="M3.5 7L10 3.5 16.5 7v6.5L10 16.5 3.5 13.5V7z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 3.5v13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M16.5 7l-6.5 3.5-6.5-3.5" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'x-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7.5 7.5l5 5m0-5l-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'exclamation-triangle' => '<path d="M10 3.5l7.5 13h-15L10 3.5z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 8v3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="14" r="1" fill="currentColor"/>',
        'exclamation-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 7v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="14" r="1" fill="currentColor"/>',
        'info-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="10" cy="7" r="1" fill="currentColor"/><path d="M10 9v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'clipboard-list' => '<rect x="5" y="4" width="10" height="14" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M9 7h2m2 0h-2m-2 3h4m-4 3h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'plus' => '<path d="M10 5v10M5 10h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'refresh' => '<path d="M4.5 10a5.5 5.5 0 0 1 9-4.2M15.5 10a5.5 5.5 0 0 1-9 4.2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M13.5 5.5v2h2M6.5 14.5v-2h-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'user' => '<circle cx="10" cy="7" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M4 16c0-2.5 3-4 6-4s6 1.5 6 4" stroke="currentColor" stroke-width="1.5"/>',
        'users' => '<circle cx="7" cy="8" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="13" cy="11" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M4 16c0-2 2.5-3 5-3s5 1 5 3" stroke="currentColor" stroke-width="1.5"/>',
        'desktop-computer' => '<rect x="3.5" y="5" width="13" height="9" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 15.5h4M10 14v1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'dots-vertical' => '<circle cx="10" cy="4" r="1.25" fill="currentColor"/><circle cx="10" cy="10" r="1.25" fill="currentColor"/><circle cx="10" cy="16" r="1.25" fill="currentColor"/>',
        'edit' => '<path d="M14.8 4.8a2 2 0 1 1 2.8 2.8L8 17.5 4 18.5l1-4L14.8 4.8z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'download' => '<path d="M10 3v9m0 0l3-3m-3 3l-3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><rect x="5" y="16" width="10" height="2" rx="1" fill="currentColor"/>',
        'share' => '<circle cx="7" cy="11" r="2.5" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="15" cy="7" r="2.5" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="15" cy="15" r="2.5" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8.7 9.8l4.6-2.6M13.3 12.8l-4.6 2.6" stroke="currentColor" stroke-width="1.5"/>',
        'arrow-left' => '<path d="M7 10h10M10 7l-3 3 3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'arrow-right' => '<path d="M13 10H3M10 13l3-3-3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'paper-airplane' => '<path d="M2.5 17.5l15-7.5-15-7.5v7.5l10 2.5-10 2.5z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'save' => '<rect x="4" y="4" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 16v-2a2 2 0 0 1 4 0v2" stroke="currentColor" stroke-width="1.5"/>',
        'lock-closed' => '<rect x="5" y="9" width="10" height="7" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 9V7a3 3 0 0 1 6 0v2" stroke="currentColor" stroke-width="1.5"/>',
        'view-grid' => '<rect x="3" y="3" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="12" y="3" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="3" y="12" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="12" y="12" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/>',
        'view-list' => '<path d="M4 7h12M4 10h12M4 13h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'filter' => '<rect x="3" y="4" width="14" height="3" rx="1.5" stroke="currentColor" stroke-width="1.5"/><rect x="7" y="9" width="6" height="3" rx="1.5" stroke="currentColor" stroke-width="1.5"/><rect x="9" y="14" width="2" height="3" rx="1" stroke="currentColor" stroke-width="1.5"/>',
        'document-text' => '<rect x="5" y="4" width="10" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 9h4M8 12h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'chart-pie' => '<circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 2v8h8" stroke="currentColor" stroke-width="1.5"/>',
        'chart-bar' => '<rect x="4" y="10" width="3" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="8.5" y="7" width="3" height="9" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="13" y="4" width="3" height="12" rx="1" stroke="currentColor" stroke-width="1.5"/>',
        'chevron-up' => '<path d="M7 13l3-3 3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'chevron-down' => '<path d="M7 7l3 3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
        'search' => '<circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M17 17l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'eye' => '<circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/><path d="M3 10c2.5-4 11.5-4 14 0" stroke="currentColor" stroke-width="1.5"/>',
        'bell' => '<path d="M10 2a4 4 0 0 1 4 4v2a6 6 0 0 1 4 5v1H2v-1a6 6 0 0 1 4-5V6a4 4 0 0 1 4-4z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 17h4a2 2 0 1 1-4 0z" stroke="currentColor" stroke-width="1.5"/>',
        'cog' => '<circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 2v2M10 16v2M4.22 4.22l1.42 1.42M15.36 15.36l1.42 1.42M2 10h2M16 10h2M4.22 15.78l1.42-1.42M15.36 4.64l1.42-1.42" stroke="currentColor" stroke-width="1.5"/>',
        'x' => '<path d="M6 6l8 8M6 14l8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',

        // Additional MYDS Icons
        'home' => '<path d="M3 9l7-7 7 7v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 17v-6h4v6" stroke="currentColor" stroke-width="1.5"/>',
        'calendar' => '<rect x="3" y="4" width="14" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M7 2v4M13 2v4M3 8h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'mail' => '<rect x="2" y="5" width="16" height="10" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M18 7l-8 5-8-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'phone' => '<path d="M15.05 5A5 5 0 0 1 19 8.95V16.05a5 5 0 0 1-5 5H6a5 5 0 0 1-5-5V8.95A5 5 0 0 1 5.95 5H15.05z" stroke="currentColor" stroke-width="1.5" fill="none"/><circle cx="10" cy="12" r="2" stroke="currentColor" stroke-width="1.5"/>',
        'trash' => '<path d="M6 7v10a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7M4 7h12M9 4h2a1 1 0 0 1 1 1v1H8V5a1 1 0 0 1 1-1z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'folder' => '<path d="M2 6a2 2 0 0 1 2-2h5l2 3h5a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'document' => '<rect x="5" y="4" width="10" height="12" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'star' => '<path d="M10 2l2.4 7.2h7.6l-6 4.8 2.4 7.2L10 17.2 3.6 21.2l2.4-7.2-6-4.8h7.6z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'heart' => '<path d="M10 17.7l-1.4-1.3C4.9 12.9 2 10.2 2 7c0-2.8 2.2-5 5-5 1.5 0 2.9.7 3.8 1.8C11.7 2.7 13.1 2 14.6 2c2.8 0 5 2.2 5 5 0 3.2-2.9 5.9-6.6 9.4L10 17.7z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'warning' => '<path d="M10 3.5l7.5 13h-15L10 3.5z" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 8v3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="14" r="1" fill="currentColor"/>',
        'upload' => '<path d="M10 17V7m0 0l-3 3m3-3l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><rect x="5" y="2" width="10" height="2" rx="1" fill="currentColor"/>',
        'link' => '<path d="M7 11h6M9 7h2a4 4 0 0 1 0 8H9M11 13H9a4 4 0 0 1 0-8h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'external-link' => '<path d="M15 3h4v4M10 14l9-9M8 6H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'copy' => '<rect x="8" y="8" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><rect x="4" y="4" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'menu' => '<path d="M3 7h14M3 12h14M3 17h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'grid' => '<rect x="3" y="3" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="11" y="3" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="3" y="11" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="11" y="11" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/>',
        'list' => '<path d="M8 6h9M8 12h9M8 18h9M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'settings' => '<circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 2v2M10 16v2M4.22 4.22l1.42 1.42M15.36 15.36l1.42 1.42M2 10h2M16 10h2M4.22 15.78l1.42-1.42M15.36 4.64l1.42-1.42" stroke="currentColor" stroke-width="1.5"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'login' => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'print' => '<rect x="5" y="6" width="10" height="10" stroke="currentColor" stroke-width="1.5" fill="none"/><rect x="3" y="9" width="14" height="5" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M8 6V4a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v2" stroke="currentColor" stroke-width="1.5"/>',
        'send' => '<path d="M2.5 17.5l15-7.5-15-7.5v7.5l10 2.5-10 2.5z" stroke="currentColor" stroke-width="1.5" fill="none"/>',
        'reply' => '<path d="M7 17l-4-4 4-4M3 13h11a4 4 0 0 0 0-8h-1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'forward' => '<path d="M13 17l4-4-4-4M17 13H6a4 4 0 0 1 0-8h1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'minus' => '<path d="M5 10h10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'plus-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M10 6v8M6 10h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'minus-circle' => '<circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M6 10h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
    ];

    // Default to clock icon if name not found
    $iconPath = $icons[$name] ?? $icons['clock'];
@endphp

<svg
    {{ $attributes->merge([
        'class' => $class,
        'viewBox' => '0 0 20 20',
        'fill' => 'none',
        'xmlns' => 'http://www.w3.org/2000/svg',
        'aria-hidden' => $ariaLabel ? 'false' : 'true',
        'aria-label' => $ariaLabel,
        'focusable' => 'false',
        'role' => $ariaLabel ? 'img' : 'presentation',
    ]) }}
    stroke="currentColor"
>
    {!! $iconPath !!}
</svg>
