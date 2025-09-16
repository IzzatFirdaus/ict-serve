@props([
    'show' => false,
    'title' => '',
    'size' => 'medium',
    'closeable' => true,
    'backdrop' => true,
    'persistent' => false,
    'maxWidth' => null,
    'actions' => [],
])

@php
$sizeClasses = [
    'small' => 'max-w-md',
    'medium' => 'max-w-lg',
    'large' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
    '2xl' => 'max-w-6xl',
    'full' => 'max-w-7xl',
];

$modalWidth = $maxWidth ?: ($sizeClasses[$size] ?? $sizeClasses['medium']);
$dialogId = 'dialog-' . \Illuminate\Support\Str::uuid();
$titleId = $title ? $dialogId . '-title' : null;
@endphp

<div
    x-data="{
        show: @entangle('show'),
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...this.$el.querySelectorAll(selector)]
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
        autofocus() {
            let focusable = this.$el.querySelector('[autofocus]')
            if (focusable) focusable.focus()
            else if (this.firstFocusable()) this.firstFocusable().focus()
        }
    }"
    x-init="
        $watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-hidden');
                setTimeout(() => autofocus(), 100);
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        });
    "
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="!@js($persistent) && (show = false)"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $titleId }}"
    id="{{ $dialogId }}"
>
    {{-- Backdrop --}}
    @if($backdrop)
        <div
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 transform transition-all"
            @if(!$persistent)
                @click="show = false"
            @endif
            aria-hidden="true"
        >
            <div class="absolute inset-0 bg-gray-600 opacity-50"></div>
        </div>
    @endif

    {{-- Modal Container --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-context-menu transform transition-all sm:w-full sm:mx-auto {{ $modalWidth }}"
        {{ $attributes }}
    >
        {{-- Modal Header --}}
        @if($title || $closeable)
            <div class="px-6 py-4 border-b border-otl-divider bg-gray-50">
                <div class="flex items-center justify-between">
                    @if($title)
                        <h3 class="text-lg font-semibold text-txt-black-900 font-heading" id="{{ $titleId }}">
                            {{ $title }}
                        </h3>
                    @else
                        <div></div>
                    @endif

                    @if($closeable)
                        <button
                            type="button"
                            @click="show = false"
                            class="bg-bg-white rounded-md text-txt-black-400 hover:text-txt-black-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                            aria-label="Tutup dialog"
                        >
                            <svg class="h-6 w-6" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 14l8-8M6 6l8 8"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @endif

        {{-- Modal Body --}}
        <div class="px-6 py-4">
            {{ $slot }}
        </div>

        {{-- Modal Footer --}}
        @if(isset($footer) || count($actions) > 0)
            <div class="px-6 py-4 border-t border-otl-divider bg-gray-50">
                @if(isset($footer))
                    {{ $footer }}
                @elseif(count($actions) > 0)
                    <div class="flex items-center justify-end space-x-3">
                        @foreach($actions as $action)
                            @if($action['type'] === 'button')
                                <x-myds.button
                                    type="{{ $action['buttonType'] ?? 'button' }}"
                                    variant="{{ $action['variant'] ?? 'secondary' }}"
                                    size="{{ $action['size'] ?? 'medium' }}"
                                    @if(isset($action['action'])) wire:click="{{ $action['action'] }}" @endif
                                    @if(isset($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif
                                    @if(isset($action['close']) && $action['close']) @click="show = false" @endif
                                    :disabled="$action['disabled'] ?? false"
                                    {{ isset($action['loading']) ? 'wire:loading.attr="disabled"' : '' }}
                                    {{ isset($action['target']) ? 'wire:target="' . $action['target'] . '"' : '' }}
                                >
                                    @if(isset($action['loading']))
                                        <span wire:loading.remove wire:target="{{ $action['target'] }}">
                                            @if(isset($action['icon']))
                                                <x-myds.icon name="{{ $action['icon'] }}" class="mr-2 h-4 w-4" />
                                            @endif
                                            {{ $action['label'] }}
                                        </span>
                                        <span wire:loading wire:target="{{ $action['target'] }}" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                <circle cx="10" cy="10" r="8" class="opacity-25" />
                                                <path class="opacity-75" stroke-linecap="round" d="M10 2a8 8 0 018 8" />
                                            </svg>
                                            {{ $action['loadingText'] ?? 'Memproses...' }}
                                        </span>
                                    @else
                                        @if(isset($action['icon']))
                                            <x-myds.icon name="{{ $action['icon'] }}" class="mr-2 h-4 w-4" />
                                        @endif
                                        {{ $action['label'] }}
                                    @endif
                                </x-myds.button>
                            @elseif($action['type'] === 'link')
                                <a
                                    href="{{ $action['url'] }}"
                                    class="text-sm font-medium text-txt-primary hover:text-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                                    @if($action['external'] ?? false) target="_blank" rel="noopener" @endif
                                    @if(isset($action['close']) && $action['close']) @click="show = false" @endif
                                >
                                    @if(isset($action['icon']))
                                        <x-myds.icon name="{{ $action['icon'] }}" class="mr-2 h-4 w-4 inline" />
                                    @endif
                                    {{ $action['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

{{-- Confirmation Modal Preset --}}
@if(isset($preset) && $preset === 'confirmation')
<div
    x-data="{ show: @entangle('show') }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="confirm-title"
>
    <div x-show="show" class="fixed inset-0 transform transition-all" @click="show = false" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-600 opacity-50"></div>
    </div>

    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-context-menu transform transition-all sm:w-full sm:mx-auto max-w-lg"
    >
        <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-danger-100 sm:mx-0 sm:h-10 sm:w-10" aria-hidden="true">
                    <svg class="h-6 w-6 text-txt-danger" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 7v4m0 4h.01M3 16h14a2 2 0 001.732-3L11.732 4a2 2 0 00-3.464 0L1.268 13A2 2 0 003 16z"></path>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 id="confirm-title" class="text-lg leading-6 font-medium text-txt-black-900 font-heading">
                        {{ $title ?? 'Pengesahan Diperlukan' }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-txt-black-500">
                            {{ $slot }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <x-myds.button
                variant="danger"
                wire:click="{{ $confirmAction ?? 'confirm' }}"
                @click="show = false"
                class="w-full sm:ml-3 sm:w-auto"
            >
                {{ $confirmText ?? 'Ya, Sahkan' }}
            </x-myds.button>
            <x-myds.button
                variant="secondary"
                @click="show = false"
                class="mt-3 w-full sm:mt-0 sm:w-auto"
            >
                {{ $cancelText ?? 'Batal' }}
            </x-myds.button>
        </div>
    </div>
</div>
@endif

{{-- Alert Modal Preset --}}
@if(isset($preset) && $preset === 'alert')
<div
    x-data="{ show: @entangle('show') }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="alert-title"
>
    <div x-show="show" class="fixed inset-0 transform transition-all" @click="show = false" aria-hidden="true">
        <div class="absolute inset-0 bg-gray-600 opacity-50"></div>
    </div>

    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-context-menu transform transition-all sm:w-full sm:mx-auto max-w-md"
    >
        <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                @php
                $alertType = $alertType ?? 'info';
                $iconStyles = [
                    'success' => ['bg' => 'bg-success-100', 'text' => 'text-txt-success'],
                    'error' => ['bg' => 'bg-danger-100', 'text' => 'text-txt-danger'],
                    'warning' => ['bg' => 'bg-warning-100', 'text' => 'text-txt-warning'],
                    'info' => ['bg' => 'bg-primary-100', 'text' => 'text-txt-primary'],
                ];
                $currentIcon = $iconStyles[$alertType] ?? $iconStyles['info'];
                @endphp

                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $currentIcon['bg'] }} sm:mx-0 sm:h-10 sm:w-10" aria-hidden="true">
                    @switch($alertType)
                        @case('success')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7"></path>
                            </svg>
                            @break
                        @case('error')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l8 8M6 14L14 6"></path>
                            </svg>
                            @break
                        @case('warning')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 3l-8 14h16L10 3zM10 8v4m0 3h.01"></path>
                            </svg>
                            @break
                        @default
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 2a8 8 0 100 16 8 8 0 000-16zM10 6v4m0 4h.01"></path>
                            </svg>
                    @endswitch
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 id="alert-title" class="text-lg leading-6 font-medium text-txt-black-900 font-heading">
                        {{ $title ?? 'Maklumat' }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-txt-black-500">
                            {{ $slot }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <x-myds.button
                variant="primary"
                @click="show = false"
                class="w-full sm:w-auto"
            >
                {{ $okText ?? 'OK' }}
            </x-myds.button>
        </div>
    </div>
</div>
@endif
