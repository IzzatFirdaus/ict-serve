@props([
    'type' => 'info',
    'title' => null,
    'message' => '',
    'position' => 'top-right',
    'duration' => 5000,
    'dismissible' => true,
    'persistent' => false,
    'actions' => [],
])

@php
$baseClasses = 'max-w-sm w-full bg-bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-otl-divider overflow-hidden';

$typeStyles = [
    'success' => ['iconColor' => 'text-txt-success', 'borderColor' => 'border-l-success-600'],
    'error' => ['iconColor' => 'text-txt-danger', 'borderColor' => 'border-l-danger-600'],
    'warning' => ['iconColor' => 'text-txt-warning', 'borderColor' => 'border-l-warning-600'],
    'info' => ['iconColor' => 'text-txt-primary', 'borderColor' => 'border-l-primary-600'],
];

$currentStyle = $typeStyles[$type] ?? $typeStyles['info'];
@endphp

<div
    x-data="{
        show: true,
        autoHide: {{ $persistent ? 'false' : 'true' }},
        duration: {{ $duration }},
        init() {
            if (this.autoHide && this.duration > 0) {
                setTimeout(() => { this.hide(); }, this.duration);
            }
        },
        hide() {
            this.show = false;
            setTimeout(() => { this.$el.remove(); }, 300);
        }
    }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="{{ $baseClasses }} border-l-4 {{ $currentStyle['borderColor'] }}"
    {{ $attributes->merge(['role' => 'status', 'aria-live' => $type === 'error' ? 'assertive' : 'polite']) }}
>
    <div class="p-4">
        <div class="flex items-start">
            {{-- Icon (MYDS 20x20 stroke 1.5) --}}
            <div class="flex-shrink-0">
                @switch($type)
                    @case('success')
                        <svg class="h-5 w-5 {{ $currentStyle['iconColor'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7l-6 6-3-3M10 18a8 8 0 110-16 8 8 0 010 16z" />
                        </svg>
                        @break
                    @case('error')
                        <svg class="h-5 w-5 {{ $currentStyle['iconColor'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <circle cx="10" cy="10" r="8" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7l6 6M13 7l-6 6" />
                        </svg>
                        @break
                    @case('warning')
                        <svg class="h-5 w-5 {{ $currentStyle['iconColor'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 3l8 14H2L10 3zM10 8v4m0 3h.01" />
                        </svg>
                        @break
                    @default
                        <svg class="h-5 w-5 {{ $currentStyle['iconColor'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <circle cx="10" cy="10" r="8" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6v4m0 4h.01" />
                        </svg>
                @endswitch
            </div>

            {{-- Content --}}
            <div class="ml-3 w-0 flex-1">
                @if($title)
                    <p class="text-sm font-medium text-txt-black-900">
                        {{ $title }}
                    </p>
                @endif

                @if($message)
                    <p class="text-sm text-txt-black-600 {{ $title ? 'mt-1' : '' }}">
                        {{ $message }}
                    </p>
                @endif

                {{-- Actions --}}
                @if(count($actions) > 0)
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($actions as $action)
                            @if($action['type'] === 'button')
                                <x-myds.button
                                    variant="{{ $action['variant'] ?? 'secondary' }}"
                                    size="small"
                                    @if(isset($action['action'])) wire:click="{{ $action['action'] }}" @endif
                                    @if(isset($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif
                                >
                                    {{ $action['label'] }}
                                </x-myds.button>
                            @elseif($action['type'] === 'link')
                                <a
                                    href="{{ $action['url'] }}"
                                    class="text-sm font-medium text-txt-primary hover:text-primary-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                                    @if($action['external'] ?? false) target="_blank" rel="noopener" @endif
                                >
                                    {{ $action['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Dismiss Button --}}
            @if($dismissible)
                <div class="ml-4 flex-shrink-0 flex">
                    <button
                        @click="hide()"
                        class="bg-bg-white rounded-md inline-flex text-txt-black-400 hover:text-txt-black-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                        aria-label="Tutup notifikasi"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l8 8M6 14l8-8" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Progress Bar (for auto-hide) --}}
        @if(!$persistent && $duration > 0)
            <div class="mt-3" aria-hidden="true">
                <div class="w-full bg-gray-200 rounded-full h-1">
                    <div
                        class="h-1 rounded-full {{ $currentStyle['borderColor'] }} border-l-0 bg-current opacity-30"
                        x-data="{ width: 100 }"
                        x-init="
                            let start = Date.now();
                            let intv = setInterval(() => {
                                let elapsed = Date.now() - start;
                                let remaining = Math.max(0, {{ $duration }} - elapsed);
                                width = (remaining / {{ $duration }}) * 100;
                                if (remaining <= 0) clearInterval(intv);
                            }, 50);
                        "
                        :style="'width: ' + width + '%'"
                        style="transition: width 0.05s linear;"
                    ></div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Toast Container (global) --}}
@pushOnce('toast-container')
<div
    id="toast-container"
    class="fixed inset-0 flex flex-col items-end justify-start px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-50"
    x-data="toastContainer()"
    @toast.window="addToast($event.detail)"
    role="region"
    aria-label="Pemberitahuan"
>
    <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-data="{
                    toast: toast,
                    show: true,
                    init() {
                        if ((this.toast.duration ?? 0) > 0) {
                            setTimeout(() => { this.hide(); }, this.toast.duration);
                        }
                    },
                    hide() {
                        this.show = false;
                        setTimeout(() => { $dispatch('remove-toast', { id: this.toast.id }); }, 300);
                    }
                }"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @remove-toast.window="if ($event.detail.id === toast.id) toasts = toasts.filter(t => t.id !== toast.id)"
                class="max-w-sm w-full bg-bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-otl-divider overflow-hidden border-l-4"
                :class="{
                    'border-l-success-600': toast.type === 'success',
                    'border-l-danger-600': toast.type === 'error',
                    'border-l-warning-600': toast.type === 'warning',
                    'border-l-primary-600': toast.type === 'info'
                }"
                role="status"
                :aria-live="toast.type === 'error' ? 'assertive' : 'polite'"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <template x-if="toast.type === 'success'">
                                <svg class="h-5 w-5 text-txt-success" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7l-6 6-3-3M10 18a8 8 0 110-16 8 8 0 010 16z" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <svg class="h-5 w-5 text-txt-danger" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <circle cx="10" cy="10" r="8" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7l6 6M13 7l-6 6" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'warning'">
                                <svg class="h-5 w-5 text-txt-warning" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 3l8 14H2L10 3zM10 8v4m0 3h.01" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'info'">
                                <svg class="h-5 w-5 text-txt-primary" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <circle cx="10" cy="10" r="8" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6v4m0 4h.01" />
                                </svg>
                            </template>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p x-text="toast.title" x-show="toast.title" class="text-sm font-medium text-txt-black-900"></p>
                            <p x-text="toast.message" class="text-sm text-txt-black-600" :class="{ 'mt-1': toast.title }"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button
                                @click="hide()"
                                class="bg-bg-white rounded-md inline-flex text-txt-black-400 hover:text-txt-black-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                                aria-label="Tutup notifikasi"
                            >
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l8 8M6 14l8-8" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function toastContainer() {
    return {
        toasts: [],
        nextId: 1,

        addToast(data) {
            const toast = {
                id: this.nextId++,
                type: data.type || 'info',
                title: data.title || null,
                message: data.message || '',
                duration: typeof data.duration === 'number' ? data.duration : 5000,
                ...data
            };

            this.toasts.push(toast);
            if (this.toasts.length > 5) this.toasts.shift(); // keep list short
        }
    }
}

// Global toast helpers aligned with MYDS AutoToast pattern
window.toast = function(type, message, title = null, options = {}) {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: {
            type,
            message,
            title,
            ...options
        }
    }));
};
window.toastSuccess = (message, title = null, options = {}) => toast('success', message, title, options);
window.toastError   = (message, title = null, options = {}) => toast('error', message, title, options);
window.toastWarning = (message, title = null, options = {}) => toast('warning', message, title, options);
window.toastInfo    = (message, title = null, options = {}) => toast('info', message, title, options);
</script>
@endpushOnce
