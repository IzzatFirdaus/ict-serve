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
$baseClasses = 'max-w-sm w-full bg-bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden';

$typeStyles = [
    'success' => [
        'icon' => 'check-circle-fill',
        'iconColor' => 'text-success-600',
        'borderColor' => 'border-l-success-600',
    ],
    'error' => [
        'icon' => 'cross-circle-fill',
        'iconColor' => 'text-danger-600',
        'borderColor' => 'border-l-danger-600',
    ],
    'warning' => [
        'icon' => 'warning-fill',
        'iconColor' => 'text-warning-600',
        'borderColor' => 'border-l-warning-600',
    ],
    'info' => [
        'icon' => 'info-circle-fill',
        'iconColor' => 'text-primary-600',
        'borderColor' => 'border-l-primary-600',
    ],
];

$currentStyle = $typeStyles[$type] ?? $typeStyles['info'];

$positionClasses = [
    'top-right' => 'top-0 right-0',
    'top-left' => 'top-0 left-0',
    'bottom-right' => 'bottom-0 right-0',
    'bottom-left' => 'bottom-0 left-0',
    'top-center' => 'top-0 left-1/2 transform -translate-x-1/2',
    'bottom-center' => 'bottom-0 left-1/2 transform -translate-x-1/2',
];
@endphp

<div 
    x-data="{
        show: true,
        autoHide: {{ $persistent ? 'false' : 'true' }},
        duration: {{ $duration }},
        init() {
            if (this.autoHide && this.duration > 0) {
                setTimeout(() => {
                    this.hide();
                }, this.duration);
            }
        },
        hide() {
            this.show = false;
            setTimeout(() => {
                this.$el.remove();
            }, 300);
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
    {{ $attributes->merge(['role' => 'alert', 'aria-live' => 'polite']) }}
>
    <div class="p-4">
        <div class="flex items-start">
            {{-- Icon --}}
            <div class="flex-shrink-0">
                @switch($type)
                    @case('success')
                        <svg class="h-6 w-6 {{ $currentStyle['iconColor'] }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        @break

                    @case('error')
                        <svg class="h-6 w-6 {{ $currentStyle['iconColor'] }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        @break

                    @case('warning')
                        <svg class="h-6 w-6 {{ $currentStyle['iconColor'] }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        @break

                    @default
                        <svg class="h-6 w-6 {{ $currentStyle['iconColor'] }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
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
                    <div class="mt-3 flex space-x-3">
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
                                    class="text-sm font-medium text-primary-600 hover:text-primary-900"
                                    @if($action['external'] ?? false) target="_blank" @endif
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
                        class="bg-bg-white rounded-md inline-flex text-txt-black-400 hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <span class="sr-only">Tutup</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Progress Bar (for auto-hide) --}}
        @if(!$persistent && $duration > 0)
            <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-1">
                    <div 
                        class="h-1 rounded-full {{ $currentStyle['borderColor'] }} border-l-0 bg-current opacity-30"
                        x-data="{ width: 100 }"
                        x-init="
                            let startTime = Date.now();
                            let interval = setInterval(() => {
                                let elapsed = Date.now() - startTime;
                                let remaining = Math.max(0, {{ $duration }} - elapsed);
                                width = (remaining / {{ $duration }}) * 100;
                                
                                if (remaining <= 0) {
                                    clearInterval(interval);
                                }
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

{{-- Toast Container (for positioning) --}}
@pushOnce('toast-container')
<div 
    id="toast-container"
    class="fixed inset-0 flex flex-col items-end justify-start px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-50"
    x-data="toastContainer()"
    @toast.window="addToast($event.detail)"
>
    <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-data="{ 
                    toast: toast,
                    show: true,
                    init() {
                        if (this.toast.duration > 0) {
                            setTimeout(() => {
                                this.hide();
                            }, this.toast.duration);
                        }
                    },
                    hide() {
                        this.show = false;
                        setTimeout(() => {
                            $dispatch('remove-toast', { id: this.toast.id });
                        }, 300);
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
                class="max-w-sm w-full bg-bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden border-l-4"
                :class="{
                    'border-l-success-600': toast.type === 'success',
                    'border-l-danger-600': toast.type === 'error',
                    'border-l-warning-600': toast.type === 'warning',
                    'border-l-primary-600': toast.type === 'info'
                }"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <template x-if="toast.type === 'success'">
                                <svg class="h-6 w-6 text-success-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <svg class="h-6 w-6 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'warning'">
                                <svg class="h-6 w-6 text-warning-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </template>
                            <template x-if="toast.type === 'info'">
                                <svg class="h-6 w-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
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
                                class="bg-bg-white rounded-md inline-flex text-txt-black-400 hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            >
                                <span class="sr-only">Tutup</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                duration: data.duration || 5000,
                ...data
            };
            
            this.toasts.push(toast);
            
            // Auto-remove after max toasts
            if (this.toasts.length > 5) {
                this.toasts.shift();
            }
        }
    }
}

// Global toast function
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

// Convenience methods
window.toastSuccess = (message, title = null, options = {}) => toast('success', message, title, options);
window.toastError = (message, title = null, options = {}) => toast('error', message, title, options);
window.toastWarning = (message, title = null, options = {}) => toast('warning', message, title, options);
window.toastInfo = (message, title = null, options = {}) => toast('info', message, title, options);
</script>
@endpushOnce