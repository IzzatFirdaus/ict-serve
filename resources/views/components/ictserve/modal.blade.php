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
            else this.firstFocusable().focus()
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
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
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
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto {{ $modalWidth }}"
        {{ $attributes }}
    >
        {{-- Modal Header --}}
        @if($title || $closeable)
            <div class="px-6 py-4 border-b border-otl-divider bg-gray-50">
                <div class="flex items-center justify-between">
                    @if($title)
                        <h3 class="text-lg font-semibold text-txt-black-900 font-heading">
                            {{ $title }}
                        </h3>
                    @else
                        <div></div>
                    @endif
                    
                    @if($closeable)
                        <button 
                            type="button"
                            @click="show = false"
                            class="bg-bg-white rounded-md text-txt-black-400 hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            aria-label="Tutup"
                        >
                            <span class="sr-only">Tutup</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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
                                    class="text-sm font-medium text-primary-600 hover:text-primary-900"
                                    @if($action['external'] ?? false) target="_blank" @endif
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
>
    <div x-show="show" class="fixed inset-0 transform transition-all" @click="show = false">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div 
        x-show="show" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto max-w-lg"
    >
        <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-danger-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-txt-black-900 font-heading">
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
>
    <div x-show="show" class="fixed inset-0 transform transition-all" @click="show = false">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div 
        x-show="show" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 bg-bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto max-w-md"
    >
        <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                @php
                $alertType = $alertType ?? 'info';
                $iconStyles = [
                    'success' => ['bg' => 'bg-success-100', 'text' => 'text-success-600'],
                    'error' => ['bg' => 'bg-danger-100', 'text' => 'text-danger-600'],
                    'warning' => ['bg' => 'bg-warning-100', 'text' => 'text-warning-600'],
                    'info' => ['bg' => 'bg-primary-100', 'text' => 'text-primary-600'],
                ];
                $currentIcon = $iconStyles[$alertType] ?? $iconStyles['info'];
                @endphp
                
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ $currentIcon['bg'] }} sm:mx-0 sm:h-10 sm:w-10">
                    @switch($alertType)
                        @case('success')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @break
                        @case('error')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            @break
                        @case('warning')
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            @break
                        @default
                            <svg class="h-6 w-6 {{ $currentIcon['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                    @endswitch
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-txt-black-900 font-heading">
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