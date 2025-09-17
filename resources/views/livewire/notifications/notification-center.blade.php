<div>
    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        {{ __('Pusat Notifikasi / Notification Center') }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Kelola semua notifikasi anda / Manage all your notifications') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $unreadCount }} {{ __('belum dibaca / unread') }}
                    </span>
                    @if($unreadCount > 0)
                        <button
                            wire:click="markAllAsRead"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            {{ __('Tandai Semua Dibaca / Mark All Read') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats Overview --}}
        <div class="px-6 py-4 bg-gray-50">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                    <div class="text-xs text-gray-500">Total</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['unread'] }}</div>
                    <div class="text-xs text-gray-500">Belum Dibaca</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-500">{{ $stats['tickets'] }}</div>
                    <div class="text-xs text-gray-500">Tiket</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-500">{{ $stats['loans'] }}</div>
                    <div class="text-xs text-gray-500">Pinjaman</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-500">{{ $stats['system'] }}</div>
                    <div class="text-xs text-gray-500">Sistem</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-500">{{ $stats['urgent'] }}</div>
                    <div class="text-xs text-gray-500">Segera</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Status Filter --}}
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Status:</label>
                    <select wire:model.live="filter" class="block w-auto text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach($this->getFilterOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Category Filter --}}
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Kategori:</label>
                    <select wire:model.live="category" class="block w-auto text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach($this->getCategoryOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Priority Filter --}}
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Prioriti:</label>
                    <select wire:model.live="priority" class="block w-auto text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @foreach($this->getPriorityOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Clear Read Notifications --}}
                <div class="ml-auto">
                    <button
                        wire:click="clearAllRead"
                        wire:confirm="Adakah anda pasti ingin menghapus semua notifikasi yang telah dibaca? / Are you sure you want to clear all read notifications?"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Hapus Yang Dibaca / Clear Read') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Notifications List --}}
    <div class="bg-white rounded-lg shadow-sm">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <div
                        class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150 {{ !$notification->is_read ? 'bg-blue-50' : '' }}"
                        wire:key="notification-{{ $notification->id }}"
                    >
                        <div class="flex items-start space-x-4">
                            {{-- Icon --}}
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-{{ $notification->color }}-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-{{ $notification->color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $notification->title }}
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        {{-- Priority Badge --}}
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $this->getPriorityColor($notification->priority) }}">
                                            {{ ucfirst(is_object($notification->priority) && method_exists($notification->priority,'value') ? (string)$notification->priority->value : (string)$notification->priority) }}
                                        </span>
                                        {{-- Category Badge --}}
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{ $this->getCategoryColor($notification->category) }}">
                                            {{ ucfirst(is_object($notification->category) && method_exists($notification->category,'value') ? (string)$notification->category->value : (string)$notification->category) }}
                                        </span>
                                    </div>
                                </div>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $notification->message }}
                                </p>

                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        {{ $notification->getTimeAgo() }}
                                    </span>

                                    <div class="flex items-center space-x-2">
                                        {{-- Action Button --}}
                                        @if($notification->action_url)
                                            <a
                                                href="{{ $notification->action_url }}"
                                                class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                                                onclick="@this.markNotificationAsRead({{ $notification->id }})"
                                            >
                                                {{ __('Lihat / View') }}
                                            </a>
                                        @endif

                                        {{-- Mark as Read/Unread --}}
                                        @if(!$notification->is_read)
                                            <button
                                                wire:click="markNotificationAsRead({{ $notification->id }})"
                                                class="text-xs text-green-600 hover:text-green-800 font-medium"
                                            >
                                                {{ __('Tandai Dibaca / Mark Read') }}
                                            </button>
                                        @endif

                                        {{-- Delete --}}
                                        <button
                                            wire:click="deleteNotification({{ $notification->id }})"
                                            wire:confirm="Adakah anda pasti ingin menghapus notifikasi ini? / Are you sure you want to delete this notification?"
                                            class="text-xs text-red-600 hover:text-red-800 font-medium"
                                        >
                                            {{ __('Hapus / Delete') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5m0-10v5m-5-5h5m-5 0v5h5v-5h-5z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    {{ __('Tiada Notifikasi / No Notifications') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Anda tidak mempunyai notifikasi mengikut penapis yang dipilih / You don\'t have any notifications matching the selected filters') }}
                </p>
            </div>
        @endif
    </div>

    {{-- Loading State --}}
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-gray-700">{{ __('Memproses... / Processing...') }}</span>
            </div>
        </div>
    </div>
</div>
