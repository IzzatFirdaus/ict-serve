<div class="min-h-screen bg-gray-50">
    {{-- Header --}}
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Dashboard Pentadbir</h1>
                    <p class="text-sm text-gray-600">Sistem Pengurusan ICTServe</p>
                </div>
                <div class="flex items-center space-x-4">
                    <select wire:model.live="selectedPeriod" class="text-sm border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                        <option value="7">7 hari lepas</option>
                        <option value="30">30 hari lepas</option>
                        <option value="90">90 hari lepas</option>
                        <option value="365">1 tahun lepas</option>
                    </select>
                    <button wire:click="exportRequests" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <x-icon name="download" class="w-4 h-4 mr-2" />
                        Eksport
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="p-4 bg-success-50 border border-success-200 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-icon name="check-circle" class="h-5 w-5 text-success-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-success-800">
                            {{ session('message') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Navigation Tabs --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-6">
            <nav class="flex space-x-8" aria-label="Tabs">
                @foreach($tabs as $tabKey => $tab)
                    <button wire:click="setActiveTab('{{ $tabKey }}')"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200
                                {{ $activeTab === $tabKey 
                                    ? 'bg-primary-100 text-primary-700 border-b-2 border-primary-500' 
                                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100' }}">
                        <x-icon name="{{ $tab['icon'] }}" class="w-5 h-5 mr-2" />
                        {{ $tab['title'] }}
                    </button>
                @endforeach
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{-- Overview Tab --}}
        @if($activeTab === 'overview')
            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="document-text" class="h-8 w-8 text-primary-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Jumlah Permohonan</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_requests']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="clock" class="h-8 w-8 text-warning-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Kelulusan</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pending_requests']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="check-circle" class="h-8 w-8 text-success-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pinjaman Aktif</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ number_format($stats['active_loans']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icon name="desktop-computer" class="h-8 w-8 text-primary-600" />
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Peralatan Tersedia</dt>
                                    <dd class="text-2xl font-semibold text-gray-900">{{ number_format($stats['available_equipment']) }}/{{ number_format($stats['total_equipment']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aktiviti Terkini</h3>
                    <div class="space-y-4">
                        @foreach($recentActivity as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                        <x-icon name="document-text" class="w-4 h-4 text-primary-600" />
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $activity['time']->diffForHumans() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($activity['status'] === 'approved') bg-success-100 text-success-800
                                        @elseif($activity['status'] === 'rejected') bg-danger-100 text-danger-800
                                        @elseif($activity['status'] === 'pending') bg-warning-100 text-warning-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($activity['status']) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Requests Tab --}}
        @if($activeTab === 'requests')
            <div class="bg-white shadow rounded-lg">
                {{-- Toolbar --}}
                <div class="px-4 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <input wire:model.live.debounce.300ms="searchTerm" 
                                       type="text" 
                                       placeholder="Cari permohonan..." 
                                       class="block w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-icon name="search" class="h-5 w-5 text-gray-400" />
                                </div>
                            </div>
                            
                            <select wire:model.live="statusFilter" class="text-sm border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bulk Actions --}}
                        @if($showBulkActions)
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">{{ count($selectedRequests) }} dipilih</span>
                                <button wire:click="bulkApprove" 
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-success-600 hover:bg-success-700">
                                    Luluskan
                                </button>
                                <button wire:click="bulkReject" 
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-danger-600 hover:bg-danger-700">
                                    Tolak
                                </button>
                                <button wire:click="resetSelection" 
                                        class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Batal
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" 
                                           wire:model.live="selectAll" 
                                           wire:click="toggleSelectAll"
                                           class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                </th>
                                <th wire:click="sortBy('reference_number')" 
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                    No. Rujukan
                                    @if($sortBy === 'reference_number')
                                        <x-icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4 inline ml-1" />
                                    @endif
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th wire:click="sortBy('created_at')" 
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                    Tarikh
                                    @if($sortBy === 'created_at')
                                        <x-icon name="{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }}" class="w-4 h-4 inline ml-1" />
                                    @endif
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loanRequests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" 
                                               wire:click="toggleRequestSelection({{ $request->id }})"
                                               @if(in_array($request->id, $selectedRequests)) checked @endif
                                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $request->reference_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->user->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $request->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="max-w-xs truncate">{{ $request->purpose ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($request->status === 'approved') bg-success-100 text-success-800
                                            @elseif($request->status === 'rejected') bg-danger-100 text-danger-800
                                            @elseif($request->status === 'pending') bg-warning-100 text-warning-800
                                            @elseif($request->status === 'collected') bg-primary-100 text-primary-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button class="text-primary-600 hover:text-primary-900">Lihat</button>
                                            <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $loanRequests->links() }}
                </div>
            </div>
        @endif

        {{-- Equipment Tab --}}
        @if($activeTab === 'equipment')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Pengurusan Peralatan</h3>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            <x-icon name="plus" class="w-4 h-4 mr-2" />
                            Tambah Peralatan
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-500">Senarai peralatan akan dipaparkan di sini.</p>
                </div>
            </div>
        @endif

        {{-- Users Tab --}}
        @if($activeTab === 'users')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Pengurusan Pengguna</h3>
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                            <x-icon name="plus" class="w-4 h-4 mr-2" />
                            Tambah Pengguna
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-500">Senarai pengguna akan dipaparkan di sini.</p>
                </div>
            </div>
        @endif

        {{-- Reports Tab --}}
        @if($activeTab === 'reports')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-4 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Laporan dan Analitik</h3>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-500">Laporan dan carta akan dipaparkan di sini.</p>
                </div>
            </div>
        @endif
    </div>
</div>