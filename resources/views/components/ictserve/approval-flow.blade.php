@props([
    'steps' => [],
    'currentStep' => 0,
    'orientation' => 'horizontal', // 'horizontal' or 'vertical'
    'showLabels' => true,
    'showTimestamps' => true,
    'compact' => false,
])

@php
    $stepStatuses = ['pending', 'in_progress', 'completed', 'rejected', 'skipped'];
    
    $statusConfig = [
        'pending' => [
            'bg' => 'bg-gray-200',
            'text' => 'text-txt-black-500',
            'border' => 'border-gray-300',
            'icon' => 'clock'
        ],
        'in_progress' => [
            'bg' => 'bg-warning-500',
            'text' => 'text-white',
            'border' => 'border-warning-500',
            'icon' => 'refresh'
        ],
        'completed' => [
            'bg' => 'bg-success-500',
            'text' => 'text-white',
            'border' => 'border-success-500',
            'icon' => 'check'
        ],
        'rejected' => [
            'bg' => 'bg-danger-500',
            'text' => 'text-white',
            'border' => 'border-danger-500',
            'icon' => 'x'
        ],
        'skipped' => [
            'bg' => 'bg-gray-300',
            'text' => 'text-txt-black-500',
            'border' => 'border-gray-300',
            'icon' => 'skip'
        ]
    ];
@endphp

<div class="approval-flow {{ $compact ? 'compact' : '' }}" {{ $attributes }}>
    @if($orientation === 'horizontal')
        {{-- Horizontal Layout --}}
        <div class="flex items-center {{ $compact ? 'space-x-2' : 'space-x-4' }}">
            @foreach($steps as $index => $step)
                @php
                    $status = $step['status'] ?? 'pending';
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                    $isLast = $loop->last;
                @endphp

                <div class="flex items-center {{ $isLast ? '' : 'flex-1' }}">
                    {{-- Step Node --}}
                    <div class="relative flex flex-col items-center">
                        {{-- Step Circle --}}
                        <div class="flex items-center justify-center {{ $compact ? 'h-8 w-8' : 'h-10 w-10' }} rounded-full border-2 {{ $config['bg'] }} {{ $config['border'] }} transition-all duration-200">
                            @switch($config['icon'])
                                @case('check')
                                    <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @break
                                @case('x')
                                    <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    @break
                                @case('refresh')
                                    <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }} animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    @break
                                @case('clock')
                                    <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @break
                                @default
                                    <span class="{{ $compact ? 'text-sm' : 'text-base' }} font-semibold {{ $config['text'] }}">
                                        {{ $index + 1 }}
                                    </span>
                            @endswitch
                        </div>

                        {{-- Step Label --}}
                        @if($showLabels && !$compact)
                            <div class="mt-2 text-center">
                                <p class="text-sm font-medium text-txt-black-900">
                                    {{ $step['title'] ?? "Langkah " . ($index + 1) }}
                                </p>
                                @if(isset($step['description']))
                                    <p class="text-xs text-txt-black-500 mt-1">
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
                        <div class="flex-1 mx-4">
                            @php
                                $nextStep = $steps[$index + 1] ?? null;
                                $nextStatus = $nextStep['status'] ?? 'pending';
                                $lineColor = $status === 'completed' ? 'bg-success-500' : 'bg-gray-200';
                            @endphp
                            <div class="h-0.5 {{ $lineColor }} transition-colors duration-300"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Compact Labels (below the flow) --}}
        @if($showLabels && $compact)
            <div class="mt-4 grid grid-cols-{{ count($steps) }} gap-2">
                @foreach($steps as $index => $step)
                    <div class="text-center">
                        <p class="text-xs font-medium text-txt-black-900">
                            {{ $step['title'] ?? "Langkah " . ($index + 1) }}
                        </p>
                        @if($showTimestamps && isset($step['timestamp']))
                            <p class="text-xs text-txt-black-400 mt-1">
                                {{ $step['timestamp'] instanceof \Carbon\Carbon ? $step['timestamp']->format('d/m/Y') : $step['timestamp'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    @else
        {{-- Vertical Layout --}}
        <div class="space-y-4">
            @foreach($steps as $index => $step)
                @php
                    $status = $step['status'] ?? 'pending';
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                    $isLast = $loop->last;
                @endphp

                <div class="relative flex items-start">
                    {{-- Timeline Line --}}
                    @if(!$isLast)
                        <div class="absolute left-5 top-10 bottom-0 w-0.5 {{ $status === 'completed' ? 'bg-success-500' : 'bg-gray-200' }} transition-colors duration-300"></div>
                    @endif

                    {{-- Step Node --}}
                    <div class="relative flex items-center justify-center {{ $compact ? 'h-8 w-8' : 'h-10 w-10' }} rounded-full border-2 {{ $config['bg'] }} {{ $config['border'] }} transition-all duration-200 z-10">
                        @switch($config['icon'])
                            @case('check')
                                <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                @break
                            @case('x')
                                <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                @break
                            @case('refresh')
                                <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }} animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                @break
                            @case('clock')
                                <svg class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @break
                            @default
                                <span class="{{ $compact ? 'text-sm' : 'text-base' }} font-semibold {{ $config['text'] }}">
                                    {{ $index + 1 }}
                                </span>
                        @endswitch
                    </div>

                    {{-- Step Content --}}
                    @if($showLabels)
                        <div class="ml-4 flex-1 pb-4">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-txt-black-900">
                                    {{ $step['title'] ?? "Langkah " . ($index + 1) }}
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
                                <p class="text-sm text-txt-black-600 mt-1">
                                    {{ $step['description'] }}
                                </p>
                            @endif

                            <div class="flex items-center mt-2 space-x-4 text-xs text-txt-black-500">
                                @if($showTimestamps && isset($step['timestamp']))
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $step['timestamp'] instanceof \Carbon\Carbon ? $step['timestamp']->format('d/m/Y H:i') : $step['timestamp'] }}
                                    </div>
                                @endif

                                @if(isset($step['user']))
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $step['user'] }}
                                    </div>
                                @endif
                            </div>

                            @if(isset($step['comments']) && $step['comments'])
                                <div class="mt-2 p-3 bg-gray-50 rounded-md">
                                    <p class="text-sm text-txt-black-600">{{ $step['comments'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Additional Slot Content --}}
    @if(isset($slot) && !empty(trim($slot)))
        <div class="mt-6 pt-6 border-t border-otl-divider">
            {{ $slot }}
        </div>
    @endif
</div>