@props([
    'title',
    'value' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'primary',
    'trend' => null,
    'trendDirection' => null, // 'up', 'down', 'neutral'
    'href' => null,
    'loading' => false,
])

@php
    $iconColorClasses = [
        'primary' => 'text-txt-primary bg-primary-50',
        'accent' => 'text-txt-accent bg-accent-50',
        'success' => 'text-txt-success bg-success-50',
        'warning' => 'text-txt-warning bg-warning-50',
        'danger' => 'text-txt-danger bg-danger-50',
    ];

    $trendColorClasses = [
        'up' => 'text-txt-success',
        'down' => 'text-txt-danger',
        'neutral' => 'text-txt-black-500',
    ];

    $component = $href ? 'a' : 'div';
    $componentAttributes = $href ? ['href' => $href] : [];
@endphp

<{{ $component }} 
    @if($href) href="{{ $href }}" @endif
    class="bg-bg-white overflow-hidden shadow-sm rounded-lg border border-otl-divider {{ $href ? 'hover:shadow-md transition-shadow duration-200 hover:border-primary-200' : '' }}"
    {{ $attributes }}
>
    <div class="p-6">
        {{-- Loading State --}}
        @if($loading)
            <div class="animate-pulse">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-gray-200 rounded-lg"></div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                        <div class="h-8 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center">
                {{-- Icon --}}
                @if($icon)
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-lg flex items-center justify-center {{ $iconColorClasses[$iconColor] ?? $iconColorClasses['primary'] }}">
                            {!! $icon !!}
                        </div>
                    </div>
                @endif

                {{-- Content --}}
                <div class="ml-4 flex-1">
                    {{-- Title --}}
                    <p class="text-sm font-medium text-txt-black-600 truncate">
                        {{ $title }}
                    </p>

                    {{-- Value --}}
                    @if($value !== null)
                        <p class="text-3xl font-bold text-txt-black-900 mt-1">
                            {{ $value }}
                        </p>
                    @endif

                    {{-- Subtitle --}}
                    @if($subtitle)
                        <p class="text-xs text-txt-black-500 mt-1">
                            {{ $subtitle }}
                        </p>
                    @endif

                    {{-- Trend --}}
                    @if($trend && $trendDirection)
                        <div class="flex items-center mt-2">
                            @if($trendDirection === 'up')
                                <svg class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7" />
                                </svg>
                            @elseif($trendDirection === 'down')
                                <svg class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10" />
                                </svg>
                            @else
                                <svg class="h-4 w-4 {{ $trendColorClasses[$trendDirection] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            @endif
                            <span class="ml-1 text-sm font-medium {{ $trendColorClasses[$trendDirection] }}">
                                {{ $trend }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Arrow for links --}}
                @if($href)
                    <div class="flex-shrink-0 ml-4">
                        <svg class="h-5 w-5 text-txt-black-400 group-hover:text-txt-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Slot for additional content --}}
            @if(isset($slot) && !empty(trim($slot)))
                <div class="mt-4 pt-4 border-t border-otl-divider">
                    {{ $slot }}
                </div>
            @endif
        @endif
    </div>
</{{ $component }}>