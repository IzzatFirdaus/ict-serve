{{--
  ICTServe (iServe) Modal (Dialog) Component
  MYDS & MyGovEA Compliance:
    - Structure: Follows MYDS Alert Dialog/Dialog component anatomy (see MYDS-Design-Overview.md, MYDS-Develop-Overview.md).
    - Colour: Uses MYDS tokens for background, border, text, shadow (see MYDS-Colour-Reference.md).
    - Typography: Poppins for headings, Inter for body (see MYDS-Develop-Overview.md, MYDS-Design-Overview.md).
    - Icons: Only MYDS icon set, 20x20, stroke 1.5px (see MYDS-Icons-Overview.md).
    - Accessibility: Keyboard (Esc to close, focus trap), ARIA roles, labelled, visible focus ring.
    - Minimal, clear, actionable, and citizen-centric (see prinsip-reka-bentuk-mygovea.md).
--}}

@props([
    'id' => null,
    'title' => null,
    'show' => false,
    'maxWidth' => 'md', // 'sm', 'md', 'lg', 'xl', 'full'
    'closeButton' => true,
    'ariaLabel' => null,
])

@php
    $widthClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        'full' => 'max-w-full',
    ][$maxWidth] ?? 'max-w-md';
@endphp

@if($show)
    <div
        x-data="{ open: true }"
        x-show="open"
        x-transition:enter="transition easeoutback.short"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition easeoutback.short"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        tabindex="-1"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        role="dialog"
        aria-modal="true"
        @keydown.escape.window="open = false"
        @close.window="open = false"
        @click.self="open = false"
        {{ $id ? "id=$id" : '' }}
    >
        <div
            class="w-full {{ $widthClasses }} bg-bg-white rounded-lg shadow-card border border-otl-divider"
            @click.away="open = false"
            @keydown.tab="trapFocus($el)"
            @keydown.shift.tab="trapFocus($el)"
        >
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-otl-divider sticky top-0 bg-bg-white z-10 rounded-t-lg">
                @if($title)
                    <h2 class="text-xl font-semibold text-txt-black-900 font-poppins" id="{{ $id ? $id . '-title' : 'modal-title' }}">{{ $title }}</h2>
                @endif
                @if($closeButton)
                    <button
                        type="button"
                        @click="open = false"
                        class="rounded-md p-2 bg-transparent text-txt-black-700 hover:bg-bg-gray-50 focus-visible:ring-2 focus-visible:ring-fr-primary transition"
                        aria-label="Tutup dialog"
                    >
                        {{-- MYDS x icon --}}
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" focusable="false">
                            <path d="M6 6l8 8M6 14l8-8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                @endif
            </div>

            {{-- Modal Content --}}
            <div class="px-6 py-6 text-sm text-txt-black-900 font-inter">
                {{ $slot }}
            </div>

            {{-- Modal Footer slot (optional) --}}
            @isset($footer)
                <div class="px-6 py-4 border-t border-otl-divider bg-bg-white rounded-b-lg">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
@endif

{{--
    Focus trap helper (Alpine.js required)
    Ensures keyboard navigation is trapped within modal when open.
--}}
<script>
function trapFocus(modal) {
    const focusable = modal.querySelectorAll('a, button, textarea, input, select, [tabindex]:not([tabindex="-1"])');
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    document.activeElement === last ? first.focus() : last.focus();
}
</script>
