@props([
    'activities' => [],
    'title' => 'Aktiviti Terkini',
    'showHeader' => true,
    'maxItems' => 5,
    'showViewAll' => true,
    'viewAllUrl' => null,
    'loading' => false,
])

<div class="bg-bg-white shadow-sm rounded-lg border border-otl-divider" {{ $attributes }}>
    {{-- Header --}}
    @if($showHeader)
        <div class="px-6 py-4 border-b border-otl-divider">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-txt-black-900 font-heading">{{ $title }}</h3>
                @if($showViewAll && $viewAllUrl)
                    <a 
                        href="{{ $viewAllUrl }}" 
                        class="text-sm text-txt-primary hover:text-primary-700 font-medium transition-colors"
                    >
                        Lihat Semua
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Content --}}
    <div class="px-6 py-4">
        @if($loading)
            {{-- Loading State --}}
            <div class="space-y-4">
                @for($i = 0; $i < 3; $i++)
                    <div class="animate-pulse flex items-start space-x-3">
                        <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                        </div>
                    </div>
                @endfor
            </div>
        @elseif(count($activities) > 0)
            {{-- Activities List --}}
            <div class="flow-root">
                <ul class="-mb-8">
                    @foreach($activities->take($maxItems) as $activity)
                        <li>
                            <div class="relative pb-8">
                                {{-- Timeline Line --}}
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif

                                <div class="relative flex items-start space-x-3">
                                    {{-- Activity Icon --}}
                                    <div class="relative">
                                        @php
                                            $iconClass = 'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-bg-white';
                                            $iconBgClass = match($activity['type'] ?? 'info') {
                                                'success' => 'bg-success-500',
                                                'warning' => 'bg-warning-500',
                                                'danger' => 'bg-danger-500',
                                                'info' => 'bg-primary-500',
                                                default => 'bg-gray-500'
                                            };
                                        @endphp
                                        
                                        <span class="{{ $iconClass }} {{ $iconBgClass }}">
                                            @if(isset($activity['icon']))
                                                {!! $activity['icon'] !!}
                                            @else
                                                @switch($activity['type'] ?? 'info')
                                                    @case('success')
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        @break
                                                    @case('warning')
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z" />
                                                        </svg>
                                                        @break
                                                    @case('danger')
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        @break
                                                    @default
                                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                @endswitch
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Activity Content --}}
                                    <div class="min-w-0 flex-1">
                                        <div>
                                            <div class="text-sm">
                                                <p class="font-medium text-txt-black-900">
                                                    {{ $activity['title'] ?? 'Aktiviti' }}
                                                </p>
                                            </div>
                                            
                                            @if(isset($activity['description']))
                                                <p class="mt-1 text-sm text-txt-black-600">
                                                    {{ $activity['description'] }}
                                                </p>
                                            @endif

                                            {{-- Activity Meta --}}
                                            <div class="mt-2 flex items-center space-x-2 text-sm text-txt-black-500">
                                                @if(isset($activity['user']))
                                                    <span>{{ $activity['user'] }}</span>
                                                    <span>&middot;</span>
                                                @endif
                                                
                                                @if(isset($activity['timestamp']))
                                                    <time datetime="{{ $activity['timestamp'] }}">
                                                        {{ $activity['timestamp'] instanceof \Carbon\Carbon ? $activity['timestamp']->diffForHumans() : $activity['timestamp'] }}
                                                    </time>
                                                @endif

                                                @if(isset($activity['status']))
                                                    <span>&middot;</span>
                                                    <x-myds.badge 
                                                        :variant="match($activity['status']) {
                                                            'approved', 'completed' => 'success',
                                                            'pending', 'in_progress' => 'warning',
                                                            'rejected', 'cancelled' => 'danger',
                                                            default => 'gray'
                                                        }"
                                                        size="sm"
                                                    >
                                                        {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                                                    </x-myds.badge>
                                                @endif
                                            </div>

                                            {{-- Action Link --}}
                                            @if(isset($activity['url']))
                                                <div class="mt-2">
                                                    <a 
                                                        href="{{ $activity['url'] }}" 
                                                        class="text-sm text-txt-primary hover:text-primary-700 font-medium transition-colors"
                                                    >
                                                        {{ $activity['action_text'] ?? 'Lihat Detail' }} →
                                                    </a>
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
        @else
            {{-- Empty State --}}
            <div class="text-center py-8">
                <div class="mx-auto h-12 w-12 text-txt-black-400">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-txt-black-900">Tiada aktiviti</h3>
                <p class="mt-1 text-sm text-txt-black-500">Aktiviti terkini akan dipaparkan di sini.</p>
            </div>
        @endif

        {{-- Additional Slot Content --}}
        @if(isset($slot) && !empty(trim($slot)))
            <div class="mt-4 pt-4 border-t border-otl-divider">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>