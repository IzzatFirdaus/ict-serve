<div class="bg-white border border-divider rounded-lg p-4" x-data="{
    autoRefresh: @entangle('autoRefresh'),
    refreshInterval: @entangle('refreshInterval'),
    intervalId: null,

    startAutoRefresh(interval) {
        this.stopAutoRefresh();
        this.intervalId = setInterval(() => {
            $wire.refreshData();
        }, interval * 1000);
    },

    stopAutoRefresh() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }
}"
x-init="
    $wire.on('startAutoRefresh', (interval) => startAutoRefresh(interval));
    $wire.on('stopAutoRefresh', () => stopAutoRefresh());
"
x-on:beforeunload.window="stopAutoRefresh()">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium text-black-900 font-poppins">{{ $title }}</h3>
        <div class="flex items-center space-x-2">
            {{-- Auto Refresh Toggle --}}
            <div class="flex items-center space-x-2">
                <span class="text-sm text-black-500 font-inter">Auto Refresh</span>
                <button
                    type="button"
                    wire:click="toggleAutoRefresh"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $autoRefresh ? 'bg-primary-600' : 'bg-black-200' }}"
                >
                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $autoRefresh ? 'translate-x-5' : 'translate-x-0' }}"></span>
                </button>
            </div>

            {{-- Manual Refresh Button --}}
            <x-myds.button wire:click="forceRefresh" variant="secondary" size="small">
                <x-myds.icon name="refresh" size="16" class="mr-1" />
                Muat Semula
            </x-myds.button>
        </div>
    </div>

    {{-- Status Items --}}
    <div class="space-y-3">
        @forelse($items as $item)
            <div class="flex items-center justify-between p-3 bg-washed rounded-lg" wire:key="status-{{ $item['id'] }}">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        @if($item['status'] === 'active')
                            <div class="w-3 h-3 bg-success-500 rounded-full animate-pulse"></div>
                        @elseif($item['status'] === 'warning')
                            <div class="w-3 h-3 bg-warning-500 rounded-full animate-pulse"></div>
                        @elseif($item['status'] === 'error')
                            <div class="w-3 h-3 bg-danger-500 rounded-full animate-pulse"></div>
                        @else
                            <div class="w-3 h-3 bg-black-300 rounded-full"></div>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-medium text-black-900 font-inter">{{ $item['label'] }}</div>
                        <div class="text-xs text-black-500 font-inter">{{ $item['value'] }}</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <x-myds.status-indicator
                        :status="$item['status']"
                        :type="$item['type'] ?? 'default'"
                        size="small"
                    />
                    <span class="text-xs text-black-400 font-inter">
                        {{ $item['updated_at']->diffForHumans() }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <x-myds.icon name="info" size="32" class="mx-auto text-black-300 mb-2" />
                <p class="text-sm text-black-500 font-inter">Tiada data status tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Last Updated --}}
    <div class="mt-4 text-center">
        <span class="text-xs text-black-400 font-inter">
            Terakhir dikemaskini: {{ now()->format('d/m/Y H:i:s') }}
        </span>
    </div>

    {{-- Auto Refresh Indicator --}}
    @if($autoRefresh)
        <div class="mt-2 flex items-center justify-center">
            <div class="flex items-center space-x-2 text-xs text-primary-600">
                <div class="w-2 h-2 bg-primary-600 rounded-full animate-pulse"></div>
                <span class="font-inter">Dimuat semula automatik setiap {{ $refreshInterval }} saat</span>
            </div>
        </div>
    @endif
</div>
