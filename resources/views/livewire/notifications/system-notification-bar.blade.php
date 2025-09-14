<div
    x-data="{
        showNotification: @entangle('isVisible'),
        autoHideTimeout: @entangle('autoHideTimeout')
    }"
    x-show="showNotification"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform -translate-y-full opacity-0"
    x-transition:enter-end="transform translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="transform translate-y-0 opacity-100"
    x-transition:leave-end="transform -translate-y-full opacity-0"
    x-on:auto-hide-notification.window="setTimeout(() => $wire.hideNotification(), $event.detail.timeout)"
    class="fixed top-0 left-0 right-0 z-50"
    style="display: none;"
>
    @if($currentNotification)
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-b-lg shadow-lg {{ $this->getNotificationClasses($currentNotification['type']) }}">
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($currentNotification['type'] === 'warning')
                                    <x-myds.icon name="warning" size="20" class="text-warning-600" />
                                @elseif($currentNotification['type'] === 'danger')
                                    <x-myds.icon name="cross-circle" size="20" class="text-danger-600" />
                                @elseif($currentNotification['type'] === 'success')
                                    <x-myds.icon name="check-circle" size="20" class="text-success-600" />
                                @else
                                    <x-myds.icon name="info" size="20" class="text-primary-600" />
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium font-poppins {{ $this->getTitleColor($currentNotification['type']) }}">
                                    {{ $currentNotification['title'] }}
                                </h3>
                                <p class="text-sm font-inter {{ $this->getMessageColor($currentNotification['type']) }}">
                                    {{ $currentNotification['message'] }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            @if(isset($currentNotification['action']))
                                <x-myds.button
                                    wire:click="executeAction"
                                    variant="primary"
                                    size="small"
                                >
                                    {{ $currentNotification['action']['label'] }}
                                </x-myds.button>
                            @endif

                            <button
                                wire:click="dismissNotification"
                                class="flex-shrink-0 p-1 rounded-md hover:bg-black-100 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                            >
                                <x-myds.icon name="cross" size="16" class="{{ $this->getCloseIconColor($currentNotification['type']) }}" />
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Progress bar for auto-hide --}}
                @if(!$currentNotification['persistent'])
                    <div class="h-1 bg-black-200">
                        <div
                            class="h-full bg-primary-600 transition-all duration-{{ $autoHideTimeout }} ease-linear"
                            x-data="{ progress: 0 }"
                            x-init="setTimeout(() => progress = 100, 100)"
                            :style="`width: ${progress}%`"
                        ></div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

@script
<script>
    // Listen for Livewire events
    $wire.on('system-notification', (notification) => {
        // Additional client-side handling if needed
    });

    $wire.on('maintenance-mode', (data) => {
        // Handle maintenance mode notifications
    });

    $wire.on('system-alert', (data) => {
        // Handle system alerts
    });
</script>
@endscript
