<div class="container mx-auto px-4 py-6">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <x-myds.callout variant="success" class="mb-6">
            {{ session('success') }}
        </x-myds.callout>
    @endif

    @if (session()->has('error'))
        <x-myds.callout variant="danger" class="mb-6">
            {{ session('error') }}
        </x-myds.callout>
    @endif

    @if (session()->has('info'))
        <x-myds.callout variant="info" class="mb-6">
            {{ session('info') }}
        </x-myds.callout>
    @endif

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold font-poppins text-black-900">Pusat Notifikasi</h1>
                <p class="text-sm text-black-500 font-inter mt-1">Kelola semua notifikasi dan maklumat penting anda</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-700">
                    {{ $unreadCount }} belum dibaca
                </span>
                @if($unreadCount > 0)
                    <x-myds.button wire:click="openMarkAllModal" variant="primary" size="medium">
                        <x-myds.icon name="check-circle" size="16" class="mr-2" />
                        Tandai Semua Dibaca
                    </x-myds.button>
                @endif
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-black-900 font-poppins">{{ $stats['total'] }}</div>
                <div class="text-xs text-black-500 font-inter">Jumlah</div>
            </div>
        </div>
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-primary-600 font-poppins">{{ $stats['unread'] }}</div>
                <div class="text-xs text-black-500 font-inter">Belum Dibaca</div>
            </div>
        </div>
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-warning-600 font-poppins">{{ $stats['tickets'] }}</div>
                <div class="text-xs text-black-500 font-inter">Tiket Helpdesk</div>
            </div>
        </div>
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-success-600 font-poppins">{{ $stats['loans'] }}</div>
                <div class="text-xs text-black-500 font-inter">Pinjaman</div>
            </div>
        </div>
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-secondary-600 font-poppins">{{ $stats['system'] }}</div>
                <div class="text-xs text-black-500 font-inter">Sistem</div>
            </div>
        </div>
        <div class="bg-white border border-divider rounded-lg p-4">
            <div class="text-center">
                <div class="text-2xl font-semibold text-danger-600 font-poppins">{{ $stats['urgent'] }}</div>
                <div class="text-xs text-black-500 font-inter">Segera</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white border border-divider rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-medium text-black-700 font-inter mb-2">Status</label>
                <x-myds.select wire:model.live="filter" class="w-full">
                    @foreach($this->getFilterOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-myds.select>
            </div>

            {{-- Category Filter --}}
            <div>
                <label class="block text-sm font-medium text-black-700 font-inter mb-2">Kategori</label>
                <x-myds.select wire:model.live="category" class="w-full">
                    @foreach($this->getCategoryOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-myds.select>
            </div>

            {{-- Priority Filter --}}
            <div>
                <label class="block text-sm font-medium text-black-700 font-inter mb-2">Keutamaan</label>
                <x-myds.select wire:model.live="priority" class="w-full">
                    @foreach($this->getPriorityOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-myds.select>
            </div>

            {{-- Clear Read Notifications --}}
            <div class="flex items-end">
                <x-myds.button
                    wire:click="clearAllRead"
                    wire:confirm="Adakah anda pasti ingin menghapus semua notifikasi yang telah dibaca?"
                    variant="secondary"
                    size="medium"
                    class="w-full"
                >
                    <x-myds.icon name="trash" size="16" class="mr-2" />
                    Hapus Yang Dibaca
                </x-myds.button>
            </div>
        </div>
    </div>

    {{-- Notifications List --}}
    <div class="bg-white border border-divider rounded-lg overflow-hidden">
        @if($notifications->count() > 0)
            <div class="divide-y divide-divider">
                @foreach($notifications as $notification)
                    <div
                        class="px-6 py-4 hover:bg-washed transition-colors duration-150 {{ !$notification->is_read ? 'bg-primary-50' : '' }}"
                        wire:key="notification-{{ $notification->id }}"
                    >
                        <div class="flex items-start space-x-4">
                            {{-- Icon --}}
                            <div class="flex-shrink-0">
                                @php
                                    $iconConfig = match($notification->type) {
                                        'ticket_created', 'ticket_updated' => ['icon' => 'warning', 'color' => 'warning'],
                                        'ticket_resolved', 'loan_approved' => ['icon' => 'check-circle', 'color' => 'success'],
                                        'loan_requested' => ['icon' => 'document', 'color' => 'primary'],
                                        'equipment_due', 'equipment_overdue' => ['icon' => 'clock', 'color' => 'danger'],
                                        default => ['icon' => 'info', 'color' => 'secondary']
                                    };
                                @endphp
                                <div class="w-10 h-10 rounded-full bg-{{ $iconConfig['color'] }}-100 flex items-center justify-center">
                                    <x-myds.icon name="{{ $iconConfig['icon'] }}" size="20" class="text-{{ $iconConfig['color'] }}-600" />
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-black-900 font-inter truncate">
                                        {{ $notification->title }}
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        {{-- Priority Badge --}}
                                        @php
                                            $priorityColors = [
                                                'urgent' => 'bg-danger-100 text-danger-700',
                                                'high' => 'bg-warning-100 text-warning-700',
                                                'medium' => 'bg-primary-100 text-primary-700',
                                                'low' => 'bg-success-100 text-success-700',
                                            ];
                                            $priorityColor = $priorityColors[$notification->priority] ?? 'bg-black-100 text-black-700';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $priorityColor }}">
                                            {{ ucfirst($notification->priority) }}
                                        </span>

                                        {{-- Category Badge --}}
                                        @php
                                            $categoryColors = [
                                                'ticket' => 'bg-warning-100 text-warning-700',
                                                'loan' => 'bg-success-100 text-success-700',
                                                'system' => 'bg-secondary-100 text-secondary-700',
                                                'general' => 'bg-black-100 text-black-700',
                                            ];
                                            $categoryColor = $categoryColors[$notification->category] ?? 'bg-black-100 text-black-700';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $categoryColor }}">
                                            {{ ucfirst($notification->category) }}
                                        </span>
                                    </div>
                                </div>

                                <p class="mt-1 text-sm text-black-600 font-inter">
                                    {{ $notification->message }}
                                </p>

                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-black-500 font-inter">
                                        {{ $notification->getTimeAgo() }}
                                    </span>

                                    <div class="flex items-center space-x-2">
                                        {{-- Action Button --}}
                                        @if($notification->action_url)
                                            <x-myds.button
                                                size="small"
                                                variant="primary"
                                                onclick="window.location.href='{{ $notification->action_url }}'; @this.markNotificationAsRead({{ $notification->id }})"
                                            >
                                                <x-myds.icon name="eye" size="12" class="mr-1" />
                                                Lihat
                                            </x-myds.button>
                                        @endif

                                        {{-- Mark as Read/Unread --}}
                                        @if(!$notification->is_read)
                                            <x-myds.button
                                                size="small"
                                                variant="success"
                                                wire:click="markNotificationAsRead({{ $notification->id }})"
                                            >
                                                <x-myds.icon name="check" size="12" class="mr-1" />
                                                Tandai Dibaca
                                            </x-myds.button>
                                        @endif

                                        {{-- Delete --}}
                                        <x-myds.button
                                            size="small"
                                            variant="danger"
                                            wire:click="deleteNotification({{ $notification->id }})"
                                            wire:confirm="Adakah anda pasti ingin menghapus notifikasi ini?"
                                        >
                                            <x-myds.icon name="trash" size="12" class="mr-1" />
                                            Hapus
                                        </x-myds.button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-divider">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <x-myds.icon name="bell" size="48" class="mx-auto text-black-300 mb-4" />
                <h3 class="text-lg font-medium text-black-900 font-poppins mb-2">Tiada Notifikasi</h3>
                <p class="text-black-500 font-inter">Anda tidak mempunyai notifikasi mengikut penapis yang dipilih.</p>
            </div>
        @endif
    </div>

    {{-- Mark All Modal --}}
    @if($showMarkAllModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black-500 bg-opacity-75" wire:click="closeMarkAllModal"></div>

                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary-100">
                            <x-myds.icon name="check-circle" size="24" class="text-primary-600" />
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-black-900 font-poppins">
                                Tandai Semua Sebagai Dibaca
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-black-500 font-inter">
                                    Adakah anda pasti ingin menandai semua {{ $unreadCount }} notifikasi sebagai telah dibaca?
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <x-myds.button
                            type="button"
                            variant="primary"
                            class="w-full sm:col-start-2"
                            wire:click="markAllAsRead"
                        >
                            Ya, Tandai Semua
                        </x-myds.button>
                        <x-myds.button
                            type="button"
                            variant="secondary"
                            class="mt-3 w-full sm:mt-0 sm:col-start-1"
                            wire:click="closeMarkAllModal"
                        >
                            Batal
                        </x-myds.button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Loading State --}}
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-600"></div>
                <span class="text-sm text-black-700 font-inter">Memproses...</span>
            </div>
        </div>
    </div>
</div>
