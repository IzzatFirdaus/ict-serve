@props([
    'items' => [],
    'variant' => 'horizontal', // horizontal, vertical, mobile
    'activeItem' => null,
    'size' => 'default',
])

@php
    $navClasses = match($variant) {
        'horizontal' => 'flex flex-row space-x-1',
        'vertical' => 'flex flex-col space-y-1',
        'mobile' => 'flex flex-col space-y-1 md:flex-row md:space-y-0 md:space-x-1',
        default => 'flex flex-row space-x-1'
    };

    $itemSizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'default' => 'px-4 py-3 text-base',
        'lg' => 'px-6 py-4 text-lg',
        default => 'px-4 py-3 text-base'
    };
@endphp

<nav {{ $attributes->merge(['class' => $navClasses]) }} role="navigation">
    @foreach($items as $item)
        @php
            $isActive = $activeItem === $item['key'] ||
                       (isset($item['route']) && request()->routeIs($item['route'])) ||
                       (isset($item['url']) && request()->url() === $item['url']);

            $itemClasses = $isActive
                ? 'bg-primary-100 text-txt-primary border-primary-300'
                : 'text-txt-black-700 hover:text-txt-black-900 hover:bg-gray-50 border-transparent';
        @endphp

        @if(isset($item['type']) && $item['type'] === 'dropdown')
            {{-- Dropdown Navigation Item --}}
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    @click.away="open = false"
                    class="{{ $itemSizeClasses }} {{ $itemClasses }} font-medium rounded-md border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 flex items-center"
                    :aria-expanded="open"
                    aria-haspopup="true"
                >
                    @if(isset($item['icon']))
                        <span class="mr-2">{{ $item['icon'] }}</span>
                    @endif
                    {{ $item['label'] }}
                    <svg class="ml-2 h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute top-full left-0 mt-1 min-w-48 bg-white border border-otl-divider rounded-md shadow-lg z-50"
                    style="display: none;"
                >
                    @foreach($item['children'] as $child)
                        <a
                            href="{{ $child['url'] ?? $child['route'] ?? '#' }}"
                            class="block px-4 py-3 text-sm text-txt-black-700 hover:text-txt-black-900 hover:bg-gray-50 transition-colors duration-200 first:rounded-t-md last:rounded-b-md"
                        >
                            @if(isset($child['icon']))
                                <span class="mr-2">{{ $child['icon'] }}</span>
                            @endif
                            {{ $child['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Regular Navigation Item --}}
            <a
                href="{{ $item['url'] ?? $item['route'] ?? '#' }}"
                class="{{ $itemSizeClasses }} {{ $itemClasses }} font-medium rounded-md border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 inline-flex items-center"
                @if($isActive) aria-current="page" @endif
            >
                @if(isset($item['icon']))
                    <span class="mr-2">{{ $item['icon'] }}</span>
                @endif
                {{ $item['label'] }}
                @if(isset($item['badge']))
                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-txt-black-700">
                        {{ $item['badge'] }}
                    </span>
                @endif
            </a>
        @endif
    @endforeach
</nav>
