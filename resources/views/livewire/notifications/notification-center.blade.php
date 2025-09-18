{{--
    ICTServe (iServe) – Notification Center
    MYDS & MyGovEA: Accessible, responsive, citizen-centric, and consistent
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>
            <x-myds.icon name="bell" class="w-6 h-6 mr-2" />
            Pusat Notifikasi / Notification Center
        </x-myds.masthead-title>
    </x-myds.masthead-header>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <x-myds.callout variant="success" class="mb-6">
            <x-myds.icon name="check-circle" />
            <span>{{ session('message') }}</span>
        </x-myds.callout>
    @endif

    {{-- Header & Stats --}}
    <x-myds.card class="mb-6">
        <x-myds.card-header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="text-heading-lg font-semibold text-txt-black-900">
                        <x-myds.icon name="bell" class="mr-2" />
                        Pusat Notifikasi / Notification Center
                    </span>
                    <div class="text-body-sm text-txt-black-500">
                        Kelola semua notifikasi anda / Manage all your notifications
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-myds.tag variant="primary" size="small" mode="pill">
                        {{ $unreadCount }} {{ __('belum dibaca / unread') }}
                    </x-myds.tag>
                    @if($unreadCount > 0)
                        <x-myds.button
                            type="button"
                            variant="secondary"
                            size="sm"
                            wire:click="markAllAsRead"
                        >
                            <x-myds.icon name="check" class="w-4 h-4 mr-1" />
                            {{ __('Tandai Semua Dibaca / Mark All Read') }}
                        </x-myds.button>
                    @endif
                </div>
            </div>
        </x-myds.card-header>
        <x-myds.card-body class="bg-washed">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-txt-black-900">{{ $stats['total'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Total</div>
                </div>
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-primary-600">{{ $stats['unread'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Belum Dibaca</div>
                </div>
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-primary-500">{{ $stats['tickets'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Tiket</div>
                </div>
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-success-600">{{ $stats['loans'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Pinjaman</div>
                </div>
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-purple-600">{{ $stats['system'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Sistem</div>
                </div>
                <div class="text-center">
                    <div class="text-heading-lg font-bold text-danger-600">{{ $stats['urgent'] }}</div>
                    <div class="text-body-xs text-txt-black-500">Segera</div>
                </div>
            </div>
        </x-myds.card-body>
    </x-myds.card>

    {{-- Filters --}}
    <x-myds.card class="mb-6">
        <x-myds.card-body>
            <div class="flex flex-wrap items-center gap-4">
                <x-myds.field>
                    <x-myds.label size="small">Status:</x-myds.label>
                    <x-myds.select wire:model.live="filter" size="small">
                        @foreach($this->getFilterOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-myds.select>
                </x-myds.field>
                <x-myds.field>
                    <x-myds.label size="small">Kategori:</x-myds.label>
                    <x-myds.select wire:model.live="category" size="small">
                        @foreach($this->getCategoryOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-myds.select>
                </x-myds.field>
                <x-myds.field>
                    <x-myds.label size="small">Prioriti:</x-myds.label>
                    <x-myds.select wire:model.live="priority" size="small">
                        @foreach($this->getPriorityOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-myds.select>
                </x-myds.field>
                <div class="ml-auto">
                    <x-myds.button
                        type="button"
                        variant="danger-tertiary"
                        size="sm"
                        wire:click="clearAllRead"
                        onclick="return confirm('Adakah anda pasti ingin menghapus semua notifikasi yang telah dibaca? / Are you sure you want to clear all read notifications?')"
                    >
                        <x-myds.icon name="trash" class="w-4 h-4 mr-1" />
                        {{ __('Hapus Yang Dibaca / Clear Read') }}
                    </x-myds.button>
                </div>
            </div>
        </x-myds.card-body>
    </x-myds.card>

    {{-- Notifications List --}}
    <x-myds.card>
        @if($notifications->count() > 0)
            <div class="divide-y otl-divider">
                @foreach($notifications as $notification)
                    <div
                        class="px-6 py-4 flex gap-4 items-start hover:bg-washed duration-150 {{ !$notification->is_read ? 'bg-primary-50' : '' }}"
                        wire:key="notification-{{ $notification->id }}"
                        tabindex="0"
                        aria-label="{{ $notification->title }}"
                    >
                        {{-- Icon --}}
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($notification->priority === 'high') bg-warning-100
                                @elseif($notification->priority === 'critical') bg-danger-100
                                @else bg-primary-100 @endif">
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
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="text-body-md font-semibold text-txt-black-900 truncate">
                                    {{ $notification->title }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <x-myds.tag
                                        :variant="match($notification->priority) {
                                            'critical' => 'danger',
                                            'high' => 'warning',
                                            'medium' => 'primary',
                                            default => 'default'
                                        }"
                                        size="xs"
                                        mode="pill"
                                        dot="{{ !$notification->is_read }}"
                                    >
                                        {{ ucfirst(is_object($notification->priority) && method_exists($notification->priority,'value') ? (string)$notification->priority->value : (string)$notification->priority) }}
                                    </x-myds.tag>
                                    <x-myds.tag
                                        :variant="match($notification->category) {
                                            'system' => 'primary',
                                            'tickets' => 'primary',
                                            'loans' => 'success',
                                            'urgent' => 'danger',
                                            default => 'default'
                                        }"
                                        size="xs"
                                        mode="pill"
                                    >
                                        {{ ucfirst(is_object($notification->category) && method_exists($notification->category,'value') ? (string)$notification->category->value : (string)$notification->category) }}
                                    </x-myds.tag>
                                </div>
                            </div>
                            <div class="text-body-sm text-txt-black-700 mt-1">
                                {{ $notification->message }}
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-xs text-txt-black-500">
                                    {{ $notification->getTimeAgo() }}
                                </span>
                                <div class="flex items-center gap-2">
                                    @if($notification->action_url)
                                        <x-myds.button
                                            :href="$notification->action_url"
                                            variant="primary"
                                            size="xs"
                                            onclick="@this.markNotificationAsRead({{ $notification->id }})"
                                        >
                                            {{ __('Lihat / View') }}
                                        </x-myds.button>
                                    @endif
                                    @if(!$notification->is_read)
                                        <x-myds.button
                                            type="button"
                                            variant="secondary"
                                            size="xs"
                                            wire:click="markNotificationAsRead({{ $notification->id }})"
                                        >
                                            {{ __('Tandai Dibaca / Mark Read') }}
                                        </x-myds.button>
                                    @endif
                                    <x-myds.button
                                        type="button"
                                        variant="danger-tertiary"
                                        size="xs"
                                        wire:click="deleteNotification({{ $notification->id }})"
                                        onclick="return confirm('Adakah anda pasti ingin menghapus notifikasi ini? / Are you sure you want to delete this notification?')"
                                    >
                                        <x-myds.icon name="trash" />
                                        <span class="sr-only">Delete</span>
                                    </x-myds.button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Pagination --}}
            <x-myds.card-body class="border-t otl-divider">
                {{ $notifications->links() }}
            </x-myds.card-body>
        @else
            <div class="px-6 py-12 text-center">
                <x-myds.icon name="inbox" class="mx-auto h-12 w-12 text-txt-black-300" />
                <div class="mt-2 text-heading-2xs text-txt-black-900">
                    {{ __('Tiada Notifikasi / No Notifications') }}
                </div>
                <div class="mt-1 text-body-sm text-txt-black-500">
                    {{ __('Anda tidak mempunyai notifikasi mengikut penapis yang dipilih / You don\'t have any notifications matching the selected filters') }}
                </div>
            </div>
        @endif
    </x-myds.card>

    {{-- Loading State --}}
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <x-myds.card>
            <x-myds.card-body class="flex items-center gap-3">
                <x-myds.spinner color="primary" size="medium" />
                <span class="text-body-md text-txt-black-700">{{ __('Memproses... / Processing...') }}</span>
            </x-myds.card-body>
        </x-myds.card>
    </div>
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
            <div class="mt-2 flex gap-3">
                <a href="#" aria-label="Facebook" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="facebook" class="w-5 h-5" /></a>
                <a href="#" aria-label="Twitter" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="twitter" class="w-5 h-5" /></a>
                <a href="#" aria-label="Instagram" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="instagram" class="w-5 h-5" /></a>
                <a href="#" aria-label="YouTube" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="youtube" class="w-5 h-5" /></a>
            </div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>
