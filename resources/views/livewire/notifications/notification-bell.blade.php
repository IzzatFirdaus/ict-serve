{{--
    ICTServe (iServe) – Notification Bell
    MYDS & MyGovEA: accessible, semantic, responsive, clear, and consistent
--}}

<div class="relative" x-data="{ open: @entangle('showDropdown').defer }">
    {{-- Bell Icon Button --}}
    <x-myds.button
        type="button"
        variant="tertiary"
        size="icon"
        aria-label="{{ __('Buka notifikasi / View notifications') }}"
        :aria-expanded="open ? 'true' : 'false'"
        aria-haspopup="menu"
        @click="open = !open"
        class="relative"
        :iconOnly="true"
        tabindex="0"
    >
        <x-myds.button-icon>
            <x-myds.icon name="bell" class="w-6 h-6" />
        </x-myds.button-icon>
        {{-- Notification Badge --}}
        @if($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 h-5 w-5 rounded-full bg-danger-600 text-xs font-semibold text-white flex items-center justify-center ring-2 ring-white z-10" aria-label="{{ $unreadCount }} {{ __('notifikasi belum dibaca / unread notifications') }}">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </x-myds.button>
    {{-- Dropdown Panel --}}
    <div
        x-show="open"
        x-transition:enter="transition easeoutback-short"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition easeout-short"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        @keydown.escape.window="open = false"
        @click.outside="open = false"
        class="absolute right-0 z-50 mt-3 w-96 max-w-xs min-w-[300px] origin-top-right myds-shadow-context-menu rounded-lg bg-bg-white-0 ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        tabindex="-1"
        style="display: none;"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-3 border-b otl-divider bg-bg-washed rounded-t-lg">
            <h3 class="text-heading-3xs font-semibold text-txt-black-900">
                <x-myds.icon name="bell" class="mr-1 w-4 h-4 text-primary-600" />
                {{ __('Notifikasi / Notifications') }}
            </h3>
            <div class="flex items-center gap-2">
                @if($unreadCount > 0)
                    <x-myds.button
                        type="button"
                        variant="tertiary"
                        size="xs"
                        wire:click="markAllAsRead"
                        class="text-primary-600"
                    >
                        {{ __('Tandai Semua / Mark All') }}
                    </x-myds.button>
                @endif
                <x-myds.button
                    :href="route('notifications.index')"
                    variant="tertiary"
                    size="xs"
                    @click="open = false"
                >
                    {{ __('Lihat Semua / View All') }}
                </x-myds.button>
            </div>
        </div>
        @if($unreadCount > 0)
            <div class="px-5 py-1 text-body-xs text-txt-black-500 border-b otl-divider">
                {{ $unreadCount }} {{ __('notifikasi belum dibaca / unread notifications') }}
            </div>
        @endif
        {{-- Notifications List --}}
        <div class="max-h-96 overflow-y-auto">
            @forelse($recentNotifications as $notification)
                <div
                    class="px-5 py-4 flex gap-3 items-start border-b otl-divider hover:bg-washed last:border-b-0 {{ !$notification->is_read ? 'bg-primary-50' : '' }}"
                    wire:key="bell-notification-{{ $notification->id }}"
                    tabindex="0"
                    role="menuitem"
                    aria-label="{{ $notification->title }}"
                >
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center
                            @if($notification->priority === 'high') bg-warning-100
                            @elseif($notification->priority === 'critical') bg-danger-100
                            @else bg-primary-100 @endif
                        ">
                            {{-- Choose icon based on type --}}
                            <x-myds.icon
                                :name="match($notification->type) {
                                    'ticket_created', 'ticket_updated' => 'clipboard-list',
                                    'ticket_resolved', 'loan_approved' => 'check-circle',
                                    'loan_requested' => 'document',
                                    'equipment_due', 'equipment_overdue' => 'clock',
                                    default => 'information-circle'
                                }"
                                class="w-5 h-5
                                    @if($notification->priority === 'critical') text-danger-600
                                    @elseif($notification->priority === 'high') text-warning-600
                                    @else text-primary-600 @endif"
                            />
                        </div>
                    </div>
                    {{-- Content --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="text-body-sm font-semibold text-txt-black-900 truncate">
                                {{ $notification->title }}
                            </span>
                            @if(!$notification->is_read)
                                <x-myds.tag variant="primary" dot="true" size="xs" mode="pill">
                                    Baru
                                </x-myds.tag>
                            @endif
                        </div>
                        <div class="text-body-xs text-txt-black-700 mt-1 line-clamp-2">
                            {{ $notification->message }}
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-txt-black-500">
                                {{ $notification->getTimeAgo() }}
                            </span>
                            <div class="flex items-center gap-2">
                                @if($notification->action_url)
                                    <x-myds.button
                                        :href="$notification->action_url"
                                        variant="primary"
                                        size="xs"
                                        @click="open = false; @this.markAsRead({{ $notification->id }})"
                                    >
                                        {{ __('Lihat / View') }}
                                    </x-myds.button>
                                @endif
                                @if(!$notification->is_read)
                                    <x-myds.button
                                        type="button"
                                        variant="secondary"
                                        size="xs"
                                        wire:click="markAsRead({{ $notification->id }})"
                                    >
                                        {{ __('Tandai / Mark') }}
                                    </x-myds.button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-10 text-center">
                    <x-myds.icon name="inbox" class="mx-auto h-12 w-12 text-txt-black-300" />
                    <h3 class="mt-2 text-heading-3xs text-txt-black-900">
                        {{ __('Tiada Notifikasi / No Notifications') }}
                    </h3>
                    <p class="mt-1 text-body-sm text-txt-black-500">
                        {{ __('Anda tidak mempunyai notifikasi baharu / You don\'t have any new notifications') }}
                    </p>
                </div>
            @endforelse
        </div>
        {{-- Footer --}}
        @if($recentNotifications->count() > 0)
            <div class="px-5 py-3 border-t otl-divider bg-bg-washed rounded-b-lg">
                <x-myds.button
                    :href="route('notifications.index')"
                    variant="primary"
                    size="sm"
                    class="w-full"
                    @click="open = false"
                >
                    <x-myds.button-icon>
                        <x-myds.icon name="inbox" />
                    </x-myds.button-icon>
                    {{ __('Lihat Semua Notifikasi / View All Notifications') }}
                </x-myds.button>
            </div>
        @endif
    </div>
</div>
