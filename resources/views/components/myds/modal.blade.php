@props([
    'open' => false,
    'maxWidth' => 'md',
    'closeable' => true,
])

@php
    $maxWidthClasses = match($maxWidth) {
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
        default => 'sm:max-w-md',
    };

    $modalId = 'modal-' . uniqid();

    // Check if Alpine.js attributes are present
    $hasAlpineShow = $attributes->has('x-show');
    $initialVisibility = $hasAlpineShow ? '' : ($open ? '' : 'hidden');
@endphp

<div
    id="{{ $modalId }}"
    class="fixed inset-0 z-50 overflow-y-auto {{ $initialVisibility }}"
    aria-labelledby="{{ $modalId }}-title"
    role="dialog"
    aria-modal="true"
    {{ $attributes->whereStartsWith('x-') }}
    {{ $attributes->whereStartsWith('wire:') }}
>
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" {{ $attributes->whereStartsWith('@') }}></div>

    <!-- Modal panel -->
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-[var(--radius-xl)] bg-white text-left shadow-xl transition-all sm:my-8 w-full {{ $maxWidthClasses }}">
            <!-- Close button -->
            @if($closeable)
                <div class="absolute right-0 top-0 pr-4 pt-4">
                    <button
                        type="button"
                        class="rounded-[var(--radius-s)] bg-white text-txt-black-400 hover:text-txt-black-500 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                        @if($hasAlpineShow)
                            @click="hide()"
                        @else
                            onclick="closeModal('{{ $modalId }}')"
                        @endif
                        aria-label="Close modal"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Modal content -->
            {{ $slot }}
        </div>
    </div>
</div>

<!-- JavaScript for modal functionality -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('[role="dialog"]:not(.hidden)');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('bg-gray-500') && event.target.classList.contains('bg-opacity-75')) {
            const modal = event.target.closest('[role="dialog"]');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }
    });
</script>
