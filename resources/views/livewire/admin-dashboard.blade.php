<x-myds.container variant="wide" class="min-h-screen">
    {{-- Header --}}
    <x-myds.card variant="basic" class="border-b border-otl-divider rounded-none">
        <div class="flex items-center justify-between">
            <div>
                <x-myds.heading level="1">Dashboard Pentadbir</x-myds.heading>
                <x-myds.text size="sm" variant="muted">Sistem Pengurusan ICTServe</x-myds.text>
            </div>
            <div class="flex items-center space-x-4">
                <x-myds.select
                    name="selectedPeriod"
                    wire:model.live="selectedPeriod"
                    :options="[
                        '7' => '7 hari lepas',
                        '30' => '30 hari lepas',
                        '90' => '90 hari lepas',
                        '365' => '1 tahun lepas'
                    ]"
                    size="sm"
                />
                <x-myds.button
                    variant="outline"
                    size="sm"
                    wire:click="exportRequests"
                    icon="📥"
                >
                    Eksport
                </x-myds.button>
            </div>
        </div>
    </x-myds.card>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mt-4">
            <x-myds.alert variant="success" dismissible>
                <strong>Berjaya!</strong> {{ session('message') }}
            </x-myds.alert>
        </div>
    @endif

    {{-- Navigation Tabs --}}
    <div class="mt-6">
        <x-myds.tabs :tabs="collect($tabs)->map(function($tab, $key) {
            return [
                'key' => $key,
                'label' => $tab['title'],
                'icon' => $tab['icon'] ?? null,
                'content' => ''
            ];
        })->toArray()"
        wire:model.live="activeTab" />
    </div>

    {{-- Main Content --}}
    <div class="py-6">
        {{-- Overview Tab --}}
        @if($activeTab === 'overview')
            {{-- Stats Grid --}}
            <x-myds.grid class="mb-8">
                <x-myds.grid-item span="3">
                    <x-myds.card>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">📄</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <x-myds.text size="sm" variant="muted">Jumlah Permohonan</x-myds.text>
                                <x-myds.heading level="2">{{ number_format($stats['total_requests']) }}</x-myds.heading>
                            </div>
                        </div>
                    </x-myds.card>
                </x-myds.grid-item>

                <x-myds.grid-item span="3">
                    <x-myds.card>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">⏱️</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <x-myds.text size="sm" variant="muted">Menunggu Kelulusan</x-myds.text>
                                <x-myds.heading level="2">{{ number_format($stats['pending_requests']) }}</x-myds.heading>
                            </div>
                        </div>
                    </x-myds.card>
                </x-myds.grid-item>

                <x-myds.grid-item span="3">
                    <x-myds.card>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">✅</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <x-myds.text size="sm" variant="muted">Pinjaman Aktif</x-myds.text>
                                <x-myds.heading level="2">{{ number_format($stats['active_loans']) }}</x-myds.heading>
                            </div>
                        </div>
                    </x-myds.card>
                </x-myds.grid-item>

                <x-myds.grid-item span="3">
                    <x-myds.card>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl">💻</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <x-myds.text size="sm" variant="muted">Peralatan Tersedia</x-myds.text>
                                <x-myds.heading level="2">{{ number_format($stats['available_equipment']) }}/{{ number_format($stats['total_equipment']) }}</x-myds.heading>
                            </div>
                        </div>
                    </x-myds.card>
                </x-myds.grid-item>
            </x-myds.grid>

            {{-- Recent Activity --}}
            <x-myds.card>
                <x-myds.heading level="3" class="mb-4">Aktiviti Terkini</x-myds.heading>
                <div class="space-y-4">
                    @foreach($recentActivity as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm">📄</span>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <x-myds.text weight="medium">{{ $activity['title'] }}</x-myds.text>
                                <x-myds.text size="sm" variant="muted">{{ $activity['description'] }}</x-myds.text>
                                <x-myds.text size="xs" variant="muted" class="mt-1">{{ $activity['time']->diffForHumans() }}</x-myds.text>
                            </div>
                            <div class="flex-shrink-0">
                                <x-myds.badge
                                    :variant="
                                        $activity['status'] === 'approved' ? 'success' :
                                        ($activity['status'] === 'rejected' ? 'danger' :
                                        ($activity['status'] === 'pending' ? 'warning' : 'secondary'))
                                    "
                                >
                                    {{ ucfirst($activity['status']) }}
                                </x-myds.badge>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-myds.card>
        @endif

        {{-- Requests Tab --}}
        @if($activeTab === 'requests')
            <x-myds.card>
                {{-- Toolbar --}}
                <div class="p-4 border-b border-otl-divider">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <x-myds.input
                                name="searchTerm"
                                wire:model.live.debounce.300ms="searchTerm"
                                placeholder="Cari permohonan..."
                                class="w-64"
                                icon="🔍"
                            />

                            <x-myds.select
                                name="statusFilter"
                                wire:model.live="statusFilter"
                                :options="$statusOptions"
                                size="sm"
                            />
                        </div>

                        {{-- Bulk Actions --}}
                        @if($showBulkActions)
                            <div class="flex items-center space-x-2">
                                <x-myds.text size="sm">{{ count($selectedRequests) }} dipilih</x-myds.text>
                                <x-myds.button
                                    variant="success"
                                    size="sm"
                                    wire:click="bulkApprove"
                                >
                                    Luluskan
                                </x-myds.button>
                                <x-myds.button
                                    variant="danger"
                                    size="sm"
                                    wire:click="bulkReject"
                                >
                                    Tolak
                                </x-myds.button>
                                <x-myds.button
                                    variant="outline"
                                    size="sm"
                                    wire:click="resetSelection"
                                >
                                    Batal
                                </x-myds.button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <x-myds.table>
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <x-myds.checkbox
                                    wire:model.live="selectAll"
                                    wire:click="toggleSelectAll"
                                />
                            </th>
                            <th wire:click="sortBy('reference_number')"
                                class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                No. Rujukan
                                @if($sortBy === 'reference_number')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Pemohon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Tujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Status</th>
                            <th wire:click="sortBy('created_at')"
                                class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Tarikh
                                @if($sortBy === 'created_at')
                                    <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loanRequests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <x-myds.checkbox
                                        wire:click="toggleRequestSelection({{ $request->id }})"
                                        :checked="in_array($request->id, $selectedRequests)"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-myds.text weight="medium">{{ $request->reference_number ?? 'N/A' }}</x-myds.text>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-myds.text weight="medium">{{ $request->user->name ?? 'N/A' }}</x-myds.text>
                                    <x-myds.text size="sm" variant="muted">{{ $request->user->email ?? 'N/A' }}</x-myds.text>
                                </td>
                                <td class="px-6 py-4">
                                    <x-myds.text class="max-w-xs truncate">{{ $request->purpose ?? 'N/A' }}</x-myds.text>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-myds.badge
                                        :variant="
                                            $request->status === 'approved' ? 'success' :
                                            ($request->status === 'rejected' ? 'danger' :
                                            ($request->status === 'pending' ? 'warning' :
                                            ($request->status === 'collected' ? 'primary' : 'secondary')))
                                        "
                                    >
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </x-myds.badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-myds.text size="sm" variant="muted">{{ $request->created_at->format('d/m/Y') }}</x-myds.text>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <x-myds.button variant="ghost" size="sm">Lihat</x-myds.button>
                                        <x-myds.button variant="ghost" size="sm">Edit</x-myds.button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-myds.table>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-otl-divider">
                    {{ $loanRequests->links() }}
                </div>
            </x-myds.card>
        @endif

        {{-- Equipment Tab --}}
        @if($activeTab === 'equipment')
            <x-myds.card>
                <div class="p-4 border-b border-otl-divider">
                    <div class="flex items-center justify-between">
                        <x-myds.heading level="3">Pengurusan Peralatan</x-myds.heading>
                        <x-myds.button icon="➕">
                            Tambah Peralatan
                        </x-myds.button>
                    </div>
                </div>

                <div class="p-6">
                    <x-myds.text variant="muted">Senarai peralatan akan dipaparkan di sini.</x-myds.text>
                </div>
            </x-myds.card>
        @endif

        {{-- Users Tab --}}
        @if($activeTab === 'users')
            <x-myds.card>
                <div class="p-4 border-b border-otl-divider">
                    <div class="flex items-center justify-between">
                        <x-myds.heading level="3">Pengurusan Pengguna</x-myds.heading>
                        <x-myds.button icon="➕">
                            Tambah Pengguna
                        </x-myds.button>
                    </div>
                </div>

                <div class="p-6">
                    <x-myds.text variant="muted">Senarai pengguna akan dipaparkan di sini.</x-myds.text>
                </div>
            </x-myds.card>
        @endif

        {{-- Reports Tab --}}
        @if($activeTab === 'reports')
            <x-myds.card>
                <div class="p-4 border-b border-otl-divider">
                    <x-myds.heading level="3">Laporan dan Analitik</x-myds.heading>
                </div>

                <div class="p-6">
                    <x-myds.text variant="muted">Laporan dan carta akan dipaparkan di sini.</x-myds.text>
                </div>
            </x-myds.card>
        @endif
    </div>
</x-myds.container>
