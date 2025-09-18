<div class="relative" x-data="{ open: @entangle('showDropdown') }">
    {{-- Bell Icon Button --}}
    <button
        @click="open = !open"
        type="button"
        class="relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        aria-expanded="false"
        aria-haspopup="true"
    >
        <span class="sr-only">{{ __('Buka notifikasi / View notifications') }}</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5m0-10v5m-5-5h5m-5 0v5h5v-5h-5z" />
        </svg>

        {{-- Notification Badge --}}
        @if($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 h-4 w-4 rounded-full bg-red-500 text-xs font-medium text-white flex items-center justify-center ring-2 ring-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @click.outside="open = false"
        class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        style="display: none;"
    >
        {{-- Header --}}
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">
                    {{ __('Notifikasi / Notifications') }}
                </h3>
                <div class="flex items-center space-x-2">
                    @if($unreadCount > 0)
                        <button
                            wire:click="markAllAsRead"
                            class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                        >
                            {{ __('Tandai Semua / Mark All') }}
                        </button>
                    @endif
                    <a
                        href="{{ route('notifications.index') }}"
                        class="text-xs text-gray-500 hover:text-gray-700 font-medium"
                        @click="open = false"
                    >
                        {{ __('Lihat Semua / View All') }}
                    </a>
                </div>
            </div>
            @if($unreadCount > 0)
                <p class="text-xs text-gray-500 mt-1">
                    {{ $unreadCount }} {{ __('notifikasi belum dibaca / unread notifications') }}
                </p>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="max-h-96 overflow-y-auto">
            @forelse($recentNotifications as $notification)
                <div
                    class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0 {{ !$notification->is_read ? 'bg-blue-50' : '' }}"
                    wire:key="bell-notification-{{ $notification->id }}"
                >
                    <div class="flex items-start space-x-3">
                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-{{ $notification->color }}-100 flex items-center justify-center">
                                <svg class="w-4 h-4 {{ $this->getPriorityColor($notification->priority) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @switch($notification->type)
                                        @case('ticket_created')
                                        @case('ticket_updated')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 14.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            @break
                                        @case('ticket_resolved')
                                        @case('loan_approved')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @break
                                        @case('loan_requested')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            @break
                                        @case('equipment_due')
                                        @case('equipment_overdue')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @break
                                        @default
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    @endswitch
                                </svg>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $notification->title }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                {{ $notification->message }}
                            </p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-gray-500">
                                    {{ $notification->getTimeAgo() }}
                                </span>
                                <div class="flex items-center space-x-2">
                                    @if($notification->action_url)
                                        <a
                                            href="{{ $notification->action_url }}"
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                                            @click="open = false; @this.markAsRead({{ $notification->id }})"
                                        >
                                            {{ __('Lihat / View') }}
                                        </a>
                                    @endif
                                    @if(!$notification->is_read)
                                        <button
                                            wire:click="markAsRead({{ $notification->id }})"
                                            class="text-xs text-green-600 hover:text-green-800 font-medium"
                                        >
                                            {{ __('Tandai / Mark') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Unread Indicator --}}
                        @if(!$notification->is_read)
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5m0-10v5m-5-5h5m-5 0v5h5v-5h-5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        {{ __('Tiada Notifikasi / No Notifications') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Anda tidak mempunyai notifikasi baharu / You don\'t have any new notifications') }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if($recentNotifications->count() > 0)
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                <a
                    href="{{ route('notifications.index') }}"
                    class="block text-center text-sm text-blue-600 hover:text-blue-800 font-medium"
                    @click="open = false"
                >
                    {{ __('Lihat Semua Notifikasi / View All Notifications') }}
                </a>
            </div>
        @endif
    </div>
</div>
