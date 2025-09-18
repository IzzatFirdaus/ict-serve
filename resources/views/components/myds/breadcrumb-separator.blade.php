{{-- MYDS Breadcrumb Separator Component --}}
@props([
    'size' => '16',
    'class' => ''
])

<svg
    class="{{ $class }} text-txt-black-500"
    width="{{ $size }}"
    height="{{ $size }}"
    viewBox="0 0 20 20"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    aria-hidden="true"
    focusable="false"
    {{ $attributes }}
>
    <path
        d="M8 6l4 4-4 4"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>
