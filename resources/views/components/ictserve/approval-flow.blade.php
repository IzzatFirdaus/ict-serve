@props([
    'steps' => [],
    'currentStep' => 0,
    'orientation' => 'horizontal', // 'horizontal' or 'vertical'
    'showLabels' => true,
    'showTimestamps' => true,
    'compact' => false,
])

@php
    // MYDS-compliant status config for approval steps
    $statusConfig = [
        'pending' => [
            'bg' => 'bg-gray-200',
            'text' => 'text-txt-black-500',
            'border' => 'border-otl-gray-300',
            'icon' => 'clock',
            'aria' => __('Belum bermula')
        ],
        'in_progress' => [
            'bg' => 'bg-warning-500',
            'text' => 'text-white',
            'border' => 'border-warning-500',
            'icon' => 'refresh',
            'aria' => __('Sedang diproses')
        ],
        'completed' => [
            'bg' => 'bg-success-500',
            'text' => 'text-white',
            'border' => 'border-success-500',
            'icon' => 'check',
            'aria' => __('Selesai')
        ],
        'rejected' => [
            'bg' => 'bg-danger-500',
            'text' => 'text-white',
            'border' => 'border-danger-500',
            'icon' => 'x',
            'aria' => __('Ditolak')
        ],
        'skipped' => [
            'bg' => 'bg-gray-300',
            'text' => 'text-txt-black-500',
            'border' => 'border-gray-300',
            'icon' => 'skip',
            'aria' => __('Dilangkau')
        ]
    ];

    // Accessible icon SVGs - MYDS 20x20, 1.5px stroke
    $iconSvg = [
        'check' => '<svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7"/></svg>',
        'x' => '<svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l8 8M6 14L14 6"/></svg>',
        'refresh' => '<svg class="w-5 h-5 animate-spin" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v4.5h.5M16 11.5A6.5 6.5 0 004.5 8.5M4.5 8.5H8.5M16 15.5v-4.5h-.5m0 0A6.5 6.5 0 014.5 11.5m11 0H11.5"/></svg>',
        'clock' => '<svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 6v4l2 2"/></svg>',
        'skip' => '<svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" d="M4 10h12M10 4l6 6-6 6"/></svg>',
    ];
@endphp

<div
    {{ $attributes->merge(['class' => 'bg-white dark:bg-dialog shadow-card rounded-lg border border-otl-divider px-6 py-6']) }}
    role="list"
    aria-label="{{ __('Aliran Kelulusan') }}"
>
    @if($orientation === 'horizontal')
        {{-- Horizontal Flow with MYDS grid & spacing --}}
        <div class="flex items-center {{ $compact ? 'gap-2' : 'gap-6' }} overflow-x-auto" tabindex="0">
            @foreach($steps as $index => $step)
                @php
                    $status = $step['status'] ?? 'pending';
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                    $isFirst = $loop->first;
                    $isLast = $loop->last;
                @endphp

                <div class="flex items-center w-full min-w-0">
                    {{-- Step Node --}}
                    <div class="flex flex-col items-center min-w-0">
                        <div
                            class="flex items-center justify-center {{ $compact ? 'h-8 w-8' : 'h-10 w-10' }} rounded-full border-2 {{ $config['bg'] }} {{ $config['border'] }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-all duration-200"
                            aria-current="{{ $currentStep == $index ? 'step' : 'false' }}"
                            aria-label="{{ $step['title'] ?? 'Langkah ' . ($index+1) }}: {{ $config['aria'] }}"
                            tabindex="0"
                        >
                            {!! $iconSvg[$config['icon']] ?? '<span class="text-base font-semibold '.$config['text'].'">'.($index+1).'</span>' !!}
                        </div>
                        @if($showLabels && !$compact)
                            <div class="mt-2 text-center min-w-[100px] max-w-[180px]">
                                <p class="text-sm font-medium text-txt-black-900 truncate" title="{{ $step['title'] ?? 'Langkah '.($index+1) }}">
                                    {{ $step['title'] ?? __('Langkah ') . ($index+1) }}
                                </p>
                                @if(isset($step['description']))
                                    <p class="text-xs text-txt-black-500 mt-1 truncate" title="{{ $step['description'] }}">
                                        {{ $step['description'] }}
                                    </p>
                                @endif
                                @if($showTimestamps && isset($step['timestamp']))
                                    <p class="text-xs text-txt-black-400 mt-1">
                                        {{ $step['timestamp'] instanceof \Carbon\Carbon ? $step['timestamp']->format('d/m/Y H:i') : $step['timestamp'] }}
                                    </p>
                                @endif
                                @if(isset($step['user']))
                                    <p class="text-xs text-txt-black-500 mt-1">
                                        {{ $step['user'] }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                    {{-- Connecting Line --}}
                    @if(!$isLast)
                        @php
                            $nextStep = $steps[$index + 1] ?? null;
                            $lineColor = ($status === 'completed') ? 'bg-success-500' : (($status === 'rejected') ? 'bg-danger-500' : 'bg-gray-200');
                        @endphp
                        <div class="flex-1 flex items-center">
                            <div class="h-0.5 w-full mx-2 {{ $lineColor }} transition-colors duration-300"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        {{-- Compact Labels Underneath --}}
        @if($showLabels && $compact)
            <div class="mt-4 grid grid-cols-{{ count($steps) }} gap-2">
                @foreach($steps as $index => $step)
                    <div class="text-center min-w-0">
                        <p class="text-xs font-medium text-txt-black-900 truncate" title="{{ $step['title'] ?? 'Langkah '.($index+1) }}">
                            {{ $step['title'] ?? __('Langkah ') . ($index+1) }}
                        </p>
                        @if($showTimestamps && isset($step['timestamp']))
                            <p class="text-xs text-txt-black-400 mt-1 truncate">
                                {{ $step['timestamp'] instanceof \Carbon\Carbon ? $step['timestamp']->format('d/m/Y') : $step['timestamp'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    @else
        {{-- Vertical Flow --}}
        <div class="flex flex-col gap-6">
            @foreach($steps as $index => $step)
                @php
                    $status = $step['status'] ?? 'pending';
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                    $isLast = $loop->last;
                @endphp
                <div class="relative flex items-start min-h-[48px] group">
                    {{-- Timeline Line --}}
                    @if(!$isLast)
                        <div class="absolute left-5 top-10 bottom-0 w-0.5 {{ ($status === 'completed') ? 'bg-success-500' : (($status === 'rejected') ? 'bg-danger-500' : 'bg-gray-200') }} transition-colors duration-300 z-0"></div>
                    @endif

                    {{-- Step Node --}}
                    <div
                        class="flex items-center justify-center {{ $compact ? 'h-8 w-8' : 'h-10 w-10' }} rounded-full border-2 {{ $config['bg'] }} {{ $config['border'] }} focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-all duration-200 z-10"
                        aria-current="{{ $currentStep == $index ? 'step' : 'false' }}"
                        aria-label="{{ $step['title'] ?? 'Langkah ' . ($index+1) }}: {{ $config['aria'] }}"
                        tabindex="0"
                    >
                        {!! $iconSvg[$config['icon']] ?? '<span class="'.($compact ? 'text-sm' : 'text-base').' font-semibold '.$config['text'].'">'.($index+1).'</span>' !!}
                    </div>
                    @if($showLabels)
                        <div class="ml-4 flex-1 pb-4 min-w-0">
                            <div class="flex items-center justify-between min-w-0">
                                <h4 class="text-sm font-medium text-txt-black-900 truncate" title="{{ $step['title'] ?? 'Langkah '.($index+1) }}">
                                    {{ $step['title'] ?? __('Langkah ') . ($index+1) }}
                                </h4>
                                @if(isset($step['status']))
                                    <x-myds.badge
                                        :variant="match($step['status']) {
                                            'completed' => 'success',
                                            'in_progress' => 'warning',
                                            'rejected' => 'danger',
                                            default => 'gray'
                                        }"
                                        size="sm"
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $step['status'])) }}
                                    </x-myds.badge>
                                @endif
                            </div>
                            @if(isset($step['description']))
                                <p class="text-sm text-txt-black-600 mt-1 truncate" title="{{ $step['description'] }}">
                                    {{ $step['description'] }}
                                </p>
                            @endif
                            <div class="flex items-center mt-2 space-x-4 text-xs text-txt-black-500">
                                @if($showTimestamps && isset($step['timestamp']))
                                    <div class="flex items-center truncate">
                                        <svg class="h-4 w-4 mr-1" aria-hidden="true" fill="none" viewBox="0 0 20 20" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="10" cy="10" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 6v4l2 2"/>
                                        </svg>
                                        {{ $step['timestamp'] instanceof \Carbon\Carbon ? $step['timestamp']->format('d/m/Y H:i') : $step['timestamp'] }}
                                    </div>
                                @endif
                                @if(isset($step['user']))
                                    <div class="flex items-center truncate">
                                        <svg class="h-4 w-4 mr-1" aria-hidden="true" fill="none" viewBox="0 0 20 20" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="10" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 18c0-4 8-4 8-4s8 0 8 4"/>
                                        </svg>
                                        {{ $step['user'] }}
                                    </div>
                                @endif
                            </div>
                            @if(isset($step['comments']) && $step['comments'])
                                <div class="mt-2 p-3 bg-washed rounded-md border border-otl-divider">
                                    <p class="text-sm text-txt-black-600">{{ $step['comments'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Slot for extra controls or notes --}}
    @if(isset($slot) && !empty(trim($slot)))
        <div class="mt-6 pt-6 border-t border-otl-divider">
            {{ $slot }}
        </div>
    @endif
</div>
