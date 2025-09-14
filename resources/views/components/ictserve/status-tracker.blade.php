@props([
    'steps' => [],
    'currentStep' => 0,
    'type' => 'loan', // 'loan' or 'helpdesk'
    'orientation' => 'horizontal', // 'horizontal' or 'vertical'
    'showTimestamps' => true,
    'showDescription' => true,
    'compact' => false,
])

@php
$defaultSteps = [
    'loan' => [
        ['key' => 'submitted', 'title' => 'Permohonan Dihantar', 'description' => 'Permohonan telah dihantar dan menunggu semakan'],
        ['key' => 'pending_support', 'title' => 'Menunggu Sokongan', 'description' => 'Menunggu sokongan daripada penyelia'],
        ['key' => 'approved', 'title' => 'Diluluskan', 'description' => 'Permohonan telah diluluskan'],
        ['key' => 'issued', 'title' => 'Peralatan Dikeluarkan', 'description' => 'Peralatan telah dikeluarkan kepada pemohon'],
        ['key' => 'completed', 'title' => 'Selesai', 'description' => 'Peralatan telah dipulangkan'],
    ],
    'helpdesk' => [
        ['key' => 'open', 'title' => 'Tiket Terbuka', 'description' => 'Tiket telah dibuat dan menunggu tindakan'],
        ['key' => 'assigned', 'title' => 'Ditugaskan', 'description' => 'Tiket telah ditugaskan kepada teknisi'],
        ['key' => 'in_progress', 'title' => 'Dalam Proses', 'description' => 'Teknisi sedang menangani masalah'],
        ['key' => 'resolved', 'title' => 'Diselesaikan', 'description' => 'Masalah telah diselesaikan'],
        ['key' => 'closed', 'title' => 'Ditutup', 'description' => 'Tiket telah ditutup'],
    ]
];

$processSteps = !empty($steps) ? $steps : $defaultSteps[$type];

$getStepStatus = function($index) use ($currentStep) {
    if ($index < $currentStep) return 'completed';
    if ($index === $currentStep) return 'current';
    return 'pending';
};

$getStepIcon = function($status, $index) {
    switch ($status) {
        case 'completed':
            return 'check';
        case 'current':
            return 'clock';
        default:
            return 'circle';
    }
};

$getStepClasses = function($status) {
    switch ($status) {
        case 'completed':
            return [
                'bg' => 'bg-success-600',
                'text' => 'text-white',
                'border' => 'border-success-600',
                'line' => 'bg-success-600'
            ];
        case 'current':
            return [
                'bg' => 'bg-primary-600',
                'text' => 'text-white',
                'border' => 'border-primary-600',
                'line' => 'bg-gray-200'
            ];
        default:
            return [
                'bg' => 'bg-gray-200',
                'text' => 'text-gray-600',
                'border' => 'border-gray-200',
                'line' => 'bg-gray-200'
            ];
    }
};
@endphp

<div class="status-tracker" {{ $attributes }}>
    @if($orientation === 'horizontal')
        {{-- Horizontal Layout --}}
        <nav aria-label="Progress" class="flex items-center justify-between">
            @foreach($processSteps as $index => $step)
                @php
                $status = $getStepStatus($index);
                $classes = $getStepClasses($status);
                $isLast = $index === count($processSteps) - 1;
                @endphp
                
                <div class="flex items-center {{ !$isLast ? 'flex-1' : '' }}">
                    {{-- Step Circle --}}
                    <div class="relative flex items-center justify-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 {{ $classes['border'] }} {{ $classes['bg'] }} {{ $compact ? 'w-8 h-8' : 'w-10 h-10' }}">
                            @if($status === 'completed')
                                <svg class="w-5 h-5 {{ $classes['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @elseif($status === 'current')
                                <svg class="w-5 h-5 {{ $classes['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <span class="block w-3 h-3 rounded-full {{ $classes['bg'] === 'bg-gray-200' ? 'bg-gray-400' : $classes['bg'] }}"></span>
                            @endif
                        </div>
                    </div>

                    {{-- Step Content --}}
                    <div class="ml-4 min-w-0 {{ !$isLast ? 'flex-1' : '' }}">
                        <div class="text-sm font-medium {{ $status === 'current' ? 'text-primary-600' : ($status === 'completed' ? 'text-success-600' : 'text-gray-500') }}">
                            {{ $step['title'] }}
                        </div>
                        @if($showDescription && !$compact && isset($step['description']))
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $step['description'] }}
                            </div>
                        @endif
                        @if($showTimestamps && isset($step['timestamp']))
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $step['timestamp'] }}
                            </div>
                        @endif
                    </div>

                    {{-- Connection Line --}}
                    @if(!$isLast)
                        <div class="flex-1 ml-4">
                            <div class="h-0.5 {{ $status === 'completed' ? 'bg-success-600' : 'bg-gray-200' }} {{ $compact ? 'h-0.5' : 'h-1' }}"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>
    @else
        {{-- Vertical Layout --}}
        <div class="flow-root">
            <ul class="-mb-8">
                @foreach($processSteps as $index => $step)
                    @php
                    $status = $getStepStatus($index);
                    $classes = $getStepClasses($status);
                    $isLast = $index === count($processSteps) - 1;
                    @endphp
                    
                    <li>
                        <div class="relative pb-8">
                            {{-- Connection Line --}}
                            @if(!$isLast)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $status === 'completed' ? 'bg-success-600' : 'bg-gray-200' }}" aria-hidden="true"></span>
                            @endif
                            
                            <div class="relative flex space-x-3">
                                {{-- Step Circle --}}
                                <div>
                                    <span class="h-8 w-8 rounded-full {{ $classes['bg'] }} border-2 {{ $classes['border'] }} flex items-center justify-center ring-8 ring-white">
                                        @if($status === 'completed')
                                            <svg class="w-5 h-5 {{ $classes['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($status === 'current')
                                            <svg class="w-5 h-5 {{ $classes['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <span class="block w-2.5 h-2.5 rounded-full {{ $classes['bg'] === 'bg-gray-200' ? 'bg-gray-400' : $classes['bg'] }}"></span>
                                        @endif
                                    </span>
                                </div>
                                
                                {{-- Step Content --}}
                                <div class="min-w-0 flex-1 pt-1.5">
                                    <div>
                                        <p class="text-sm font-medium {{ $status === 'current' ? 'text-primary-600' : ($status === 'completed' ? 'text-success-600' : 'text-gray-500') }}">
                                            {{ $step['title'] }}
                                        </p>
                                        @if($showDescription && isset($step['description']))
                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $step['description'] }}
                                            </p>
                                        @endif
                                        @if($showTimestamps && isset($step['timestamp']))
                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ $step['timestamp'] }}
                                            </p>
                                        @endif
                                        
                                        {{-- Additional Step Details --}}
                                        @if(isset($step['details']) && !empty($step['details']))
                                            <div class="mt-2 text-sm">
                                                @if(isset($step['details']['actor']))
                                                    <p class="text-gray-600">
                                                        <span class="font-medium">Oleh:</span> {{ $step['details']['actor'] }}
                                                    </p>
                                                @endif
                                                @if(isset($step['details']['comment']))
                                                    <p class="text-gray-600 mt-1">
                                                        <span class="font-medium">Catatan:</span> {{ $step['details']['comment'] }}
                                                    </p>
                                                @endif
                                                @if(isset($step['details']['duration']) && $status === 'completed')
                                                    <p class="text-gray-500 text-xs mt-1">
                                                        Masa diambil: {{ $step['details']['duration'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Status Summary --}}
    @if(!$compact)
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Status Semasa</h4>
                    <p class="text-sm text-gray-600">
                        {{ $processSteps[$currentStep]['title'] ?? 'Tidak Diketahui' }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-900">
                        Kemajuan
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ $currentStep + 1 }} / {{ count($processSteps) }} langkah
                    </div>
                </div>
            </div>
            
            {{-- Progress Bar --}}
            <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div 
                        class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                        style="width: {{ (($currentStep + 1) / count($processSteps)) * 100 }}%"
                    ></div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Status Badge Helper --}}
@if(isset($showBadge) && $showBadge)
    @php
    $currentStepData = $processSteps[$currentStep] ?? null;
    $badgeVariant = match($currentStepData['key'] ?? '') {
        'submitted', 'open' => 'info',
        'pending_support', 'assigned', 'in_progress' => 'warning',
        'approved', 'resolved' => 'success',
        'issued' => 'info',
        'completed', 'closed' => 'success',
        'rejected' => 'danger',
        default => 'gray'
    };
    @endphp
    
    <div class="mt-4">
        <x-myds.badge variant="{{ $badgeVariant }}">
            {{ $currentStepData['title'] ?? 'Status Tidak Diketahui' }}
        </x-myds.badge>
    </div>
@endif