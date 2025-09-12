@props([
    'href' => null,
    'icon' => null,
    'disabled' => false,
])

@php
    $tag = $href && !$disabled ? 'a' : 'button';
    $classes = 'block w-full text-left px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-100 hover:text-txt-black-900 focus:outline-none focus:bg-gray-100 focus:text-txt-black-900 transition-colors';

    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed pointer-events-none';
    }
@endphp

<{{ $tag }}
    @if($href && !$disabled) href="{{ $href }}" @endif
    @if($tag === 'button') type="button" @endif
    class="{{ $classes }}"
    role="menuitem"
    tabindex="-1"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes }}
>
    <div class="flex items-center">
        @if($icon)
            <span class="mr-3 flex-shrink-0">
                {{ $icon }}
            </span>
        @endif

        <span>{{ $slot }}</span>
    </div>
</{{ $tag }}>
