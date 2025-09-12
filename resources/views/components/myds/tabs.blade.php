@props([
    'tabs' => [],
    'activeTab' => null,
    'variant' => 'default',
    'size' => 'default',
])

@php
    $wrapperClasses = match($variant) {
        'underline' => 'border-b border-otl-divider',
        'pills' => '',
        'cards' => 'bg-washed p-1 rounded-lg',
        default => 'border-b border-otl-divider'
    };

    $tabClasses = match($variant) {
        'underline' => '',
        'pills' => 'rounded-md',
        'cards' => 'rounded-md',
        default => ''
    };

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'default' => 'px-4 py-3 text-base',
        'lg' => 'px-6 py-4 text-lg',
        default => 'px-4 py-3 text-base'
    };
@endphp

<div
    x-data="{ activeTab: '{{ $activeTab ?? ($tabs[0]['key'] ?? '') }}' }"
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    <!-- Tab Navigation -->
    <div class="flex {{ $wrapperClasses }}" role="tablist">
        @foreach($tabs as $tab)
            <button
                type="button"
                @click="activeTab = '{{ $tab['key'] }}'"
                :class="{
                    @if($variant === 'underline')
                        'border-b-2 border-primary-600 text-txt-primary': activeTab === '{{ $tab['key'] }}',
                        'border-b-2 border-transparent text-txt-black-500 hover:text-txt-black-700 hover:border-gray-300': activeTab !== '{{ $tab['key'] }}'
                    @elseif($variant === 'pills')
                        'bg-primary-600 text-white': activeTab === '{{ $tab['key'] }}',
                        'text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-100': activeTab !== '{{ $tab['key'] }}'
                    @elseif($variant === 'cards')
                        'bg-white text-txt-primary shadow-sm': activeTab === '{{ $tab['key'] }}',
                        'text-txt-black-500 hover:text-txt-black-700': activeTab !== '{{ $tab['key'] }}'
                    @else
                        'border-b-2 border-primary-600 text-txt-primary': activeTab === '{{ $tab['key'] }}',
                        'border-b-2 border-transparent text-txt-black-500 hover:text-txt-black-700 hover:border-gray-300': activeTab !== '{{ $tab['key'] }}'
                    @endif
                }"
                class="{{ $sizeClasses }} {{ $tabClasses }} font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2"
                role="tab"
                :aria-selected="activeTab === '{{ $tab['key'] }}'"
                :aria-controls="'panel-{{ $tab['key'] }}'"
                :id="'tab-{{ $tab['key'] }}'"
                @if(isset($tab['disabled']) && $tab['disabled'])
                    disabled
                    class="opacity-50 cursor-not-allowed"
                @endif
            >
                @if(isset($tab['icon']))
                    <span class="mr-2">{{ $tab['icon'] }}</span>
                @endif
                {{ $tab['label'] }}
                @if(isset($tab['badge']))
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-txt-black-700">
                        {{ $tab['badge'] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    <!-- Tab Panels -->
    <div class="mt-4">
        @foreach($tabs as $tab)
            <div
                x-show="activeTab === '{{ $tab['key'] }}'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-1"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-1"
                role="tabpanel"
                id="panel-{{ $tab['key'] }}"
                aria-labelledby="tab-{{ $tab['key'] }}"
            >
                @if(isset($tab['content']))
                    {!! $tab['content'] !!}
                @endif
            </div>
        @endforeach
    </div>
</div>
