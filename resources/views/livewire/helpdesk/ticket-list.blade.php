<div class="bg-background-light dark:bg-background-dark min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <x-myds.header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="font-poppins text-2xl font-semibold text-black-900 dark:text-white">
                        Senarai Tiket Sokongan Saya
                    </h1>
                    <p class="font-inter text-sm text-black-500 dark:text-black-400 mt-2">
                        Lihat dan urus permintaan sokongan ICT anda
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <x-myds.button variant="primary" class="w-full md:w-auto">
                        <x-myds.icon name="plus" size="16" class="mr-2" />
                        Cipta Aduan Baru
                    </x-myds.button>
                </div>
            </div>
        </x-myds.header>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Total Tickets -->
            <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-primary-100 dark:bg-primary-900 rounded-lg">
                        <x-myds.icon name="document" size="24" class="text-primary-600 dark:text-primary-400" />
                    </div>
                    <div class="ml-4">
                        <p class="font-inter text-xs font-medium text-black-500 dark:text-black-400">Jumlah</p>
                        <p class="font-poppins text-xl font-semibold text-black-900 dark:text-white">{{ $counts['total'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Open Tickets -->
            <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-warning-100 dark:bg-warning-900 rounded-lg">
                        <x-myds.icon name="clock" size="24" class="text-warning-600 dark:text-warning-400" />
                    </div>
                    <div class="ml-4">
                        <p class="font-inter text-xs font-medium text-black-500 dark:text-black-400">Terbuka</p>
                        <p class="font-poppins text-xl font-semibold text-black-900 dark:text-white">{{ $counts['open'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Closed Tickets -->
            <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-success-100 dark:bg-success-900 rounded-lg">
                        <x-myds.icon name="check-circle" size="24" class="text-success-600 dark:text-success-400" />
                    </div>
                    <div class="ml-4">
                        <p class="font-inter text-xs font-medium text-black-500 dark:text-black-400">Selesai</p>
                        <p class="font-poppins text-xl font-semibold text-black-900 dark:text-white">{{ $counts['closed'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Overdue Tickets -->
            <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-danger-100 dark:bg-danger-900 rounded-lg">
                        <x-myds.icon name="warning-triangle" size="24" class="text-danger-600 dark:text-danger-400" />
                    </div>
                    <div class="ml-4">
                        <p class="font-inter text-xs font-medium text-black-500 dark:text-black-400">Tertunggak</p>
                        <p class="font-poppins text-xl font-semibold text-black-900 dark:text-white">{{ $counts['overdue'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label for="search" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                        Carian
                    </label>
                    <x-myds.input
                        type="text"
                        id="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari menggunakan nombor tiket, tajuk, atau huraian"
                        class="w-full"
                    />
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="filterStatus" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                        Status
                    </label>
                    <x-myds.select wire:model.live="filterStatus" id="filterStatus">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </x-myds.select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="filterCategory" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                        Kategori
                    </label>
                    <x-myds.select wire:model.live="filterCategory" id="filterCategory">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-myds.select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <label for="filterPriority" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                        Keutamaan
                    </label>
                    <x-myds.select wire:model.live="filterPriority" id="filterPriority">
                        <option value="">Semua Keutamaan</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->value }}">{{ $priority->label() }}</option>
                        @endforeach
                    </x-myds.select>
                </div>
            </div>

            <!-- Clear Filters -->
            @if($search || $filterStatus || $filterCategory || $filterPriority)
                <div class="mt-4">
                    <x-myds.button variant="secondary" size="small" wire:click="clearFilters">
                        <x-myds.icon name="cross" size="14" class="mr-2" />
                        Kosongkan Penapis
                    </x-myds.button>
                </div>
            @endif
        </div>

        <!-- Tickets Table -->
        <div class="bg-white dark:bg-dialog border border-divider rounded-lg overflow-hidden">
            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-divider">
                        <thead class="bg-washed dark:bg-black-100">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <button wire:click="sortBy('ticket_number')" class="flex items-center space-x-1 hover:text-primary-600 dark:hover:text-primary-400">
                                        <span class="font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                            No. Tiket
                                        </span>
                                        @if($sortField === 'ticket_number')
                                            <x-myds.icon
                                                name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                size="14"
                                                class="text-primary-600 dark:text-primary-400"
                                            />
                                        @endif
                                    </button>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <button wire:click="sortBy('title')" class="flex items-center space-x-1 hover:text-primary-600 dark:hover:text-primary-400">
                                        <span class="font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                            Tajuk
                                        </span>
                                        @if($sortField === 'title')
                                            <x-myds.icon
                                                name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                size="14"
                                                class="text-primary-600 dark:text-primary-400"
                                            />
                                        @endif
                                    </button>
                                </th>
                                <th class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                    Keutamaan
                                </th>
                                <th class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <button wire:click="sortBy('created_at')" class="flex items-center space-x-1 hover:text-primary-600 dark:hover:text-primary-400">
                                        <span class="font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                            Dicipta
                                        </span>
                                        @if($sortField === 'created_at')
                                            <x-myds.icon
                                                name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}"
                                                size="14"
                                                class="text-primary-600 dark:text-primary-400"
                                            />
                                        @endif
                                    </button>
                                </th>
                                <th class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider">
                                    Tindakan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-dialog divide-y divide-divider">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-washed dark:hover:bg-black-100">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-inter text-sm font-medium text-black-900 dark:text-white">
                                            {{ $ticket->ticket_number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-inter text-sm font-medium text-black-900 dark:text-white">
                                            {{ $ticket->title }}
                                        </div>
                                        <div class="font-inter text-sm text-black-500 dark:text-black-400 truncate max-w-xs">
                                            {{ $ticket->description }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-inter text-sm text-black-900 dark:text-white">
                                            {{ $ticket->category->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'low' => 'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300',
                                                'medium' => 'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300',
                                                'high' => 'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300',
                                                'critical' => 'bg-danger-200 text-danger-800 dark:bg-danger-800 dark:text-danger-200'
                                            ];
                                            $colorClass = $priorityColors[$ticket->priority->value] ?? 'bg-black-100 text-black-700 dark:bg-black-800 dark:text-black-300';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-inter text-xs font-medium {{ $colorClass }}">
                                            {{ $ticket->priority->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = $ticket->ticketStatus->color ?? 'gray';
                                            $statusColorClass = match($statusColor) {
                                                'blue' => 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300',
                                                'yellow' => 'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300',
                                                'green' => 'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300',
                                                'red' => 'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300',
                                                default => 'bg-black-100 text-black-700 dark:bg-black-800 dark:text-black-300'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-inter text-xs font-medium {{ $statusColorClass }}">
                                            {{ $ticket->ticketStatus->name ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-inter text-sm text-black-500 dark:text-black-400">
                                        <div>{{ $ticket->created_at->format('j M Y') }}</div>
                                        <div class="text-xs">{{ $ticket->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-inter text-sm font-medium">
                                        <x-myds.button
                                            variant="secondary"
                                            size="small"
                                            onclick="window.location.href='{{ route('helpdesk.ticket.detail', $ticket->ticket_number) }}'"
                                        >
                                            <x-myds.icon name="eye-show" size="14" class="mr-1" />
                                            Lihat
                                        </x-myds.button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-washed dark:bg-black-100 border-t border-divider">
                    {{ $tickets->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <x-myds.icon name="document" size="48" class="text-black-400 mx-auto mb-4" />
                    <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-2">
                        Tiada tiket dijumpai
                    </h3>
                    <p class="font-inter text-sm text-black-500 dark:text-black-400 mb-4">
                        @if($search || $filterStatus || $filterCategory || $filterPriority)
                            Cuba laraskan penapis atau istilah carian anda.
                        @else
                            Anda belum mencipta sebarang tiket sokongan lagi.
                        @endif
                    </p>
                    <x-myds.button variant="primary">
                        <x-myds.icon name="plus" size="16" class="mr-2" />
                        Cipta Tiket Pertama Anda
                    </x-myds.button>
                </div>
            @endif
        </div>
    </div>
</div>
