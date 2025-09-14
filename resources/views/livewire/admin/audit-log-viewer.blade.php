<div>
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">
                        {{ __('Audit Trail / Jejak Audit') }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Pantau dan analisis aktiviti sistem / Monitor and analyze system activities') }}
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <button
                        wire:click="toggleFilters"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        {{ __('Penapis / Filters') }}
                    </button>
                    <button
                        wire:click="exportLogs"
                        class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('Eksport / Export') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Statistics Overview --}}
        <div class="px-6 py-4 bg-gray-50">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_logs']) }}</div>
                    <div class="text-xs text-gray-500">Total Log</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['unique_users']) }}</div>
                    <div class="text-xs text-gray-500">Pengguna Unik</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($stats['recent_24h']) }}</div>
                    <div class="text-xs text-gray-500">24 Jam Terakhir</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ !empty($stats['top_actions']) ? array_keys($stats['top_actions'])[0] : 'N/A' }}
                    </div>
                    <div class="text-xs text-gray-500">Aksi Teratas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    @if($show_filters)
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Search --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Carian / Search') }}
                        </label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('Cari pengguna, aksi, atau nota...') }}"
                            class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>

                    {{-- Action Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Aksi / Action') }}
                        </label>
                        <select wire:model.live="action" class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">{{ __('Semua Aksi / All Actions') }}</option>
                            @foreach($actions as $actionOption)
                                <option value="{{ $actionOption }}">{{ ucfirst($actionOption) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Model Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Jenis Model / Model Type') }}
                        </label>
                        <select wire:model.live="auditable_type" class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">{{ __('Semua Model / All Models') }}</option>
                            @foreach($auditableTypes as $type)
                                <option value="App\Models\{{ $type }}">{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- User Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Pengguna / User') }}
                        </label>
                        <select wire:model.live="user_id" class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">{{ __('Semua Pengguna / All Users') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Dari Tarikh / From Date') }}
                        </label>
                        <input
                            type="date"
                            wire:model.live="date_from"
                            class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Hingga Tarikh / To Date') }}
                        </label>
                        <input
                            type="date"
                            wire:model.live="date_to"
                            class="block w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        {{-- View Mode --}}
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">{{ __('Paparan / View') }}:</label>
                            <div class="flex rounded-md shadow-sm" role="group">
                                <button
                                    wire:click="setViewMode('detailed')"
                                    class="px-3 py-1 text-xs font-medium {{ $view_mode === 'detailed' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }} rounded-l-md border focus:z-10 focus:ring-2 focus:ring-blue-500"
                                >
                                    {{ __('Terperinci / Detailed') }}
                                </button>
                                <button
                                    wire:click="setViewMode('compact')"
                                    class="px-3 py-1 text-xs font-medium {{ $view_mode === 'compact' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }} border-t border-b border-r focus:z-10 focus:ring-2 focus:ring-blue-500"
                                >
                                    {{ __('Padat / Compact') }}
                                </button>
                                <button
                                    wire:click="setViewMode('timeline')"
                                    class="px-3 py-1 text-xs font-medium {{ $view_mode === 'timeline' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }} rounded-r-md border focus:z-10 focus:ring-2 focus:ring-blue-500"
                                >
                                    {{ __('Garis Masa / Timeline') }}
                                </button>
                            </div>
                        </div>

                        {{-- Per Page --}}
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">{{ __('Setiap Halaman / Per Page') }}:</label>
                            <select wire:model.live="per_page" class="block text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <button
                        wire:click="resetFilters"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('Set Semula / Reset') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Audit Logs List --}}
    <div class="bg-white rounded-lg shadow-sm">
        @if($logs->count() > 0)
            @if($view_mode === 'detailed')
                {{-- Detailed View --}}
                <div class="divide-y divide-gray-200">
                    @foreach($logs as $log)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150" wire:key="audit-{{ $log->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    {{-- Icon --}}
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{
                                                $log->action === 'created' ? 'bg-green-50 text-green-700 border-green-200' :
                                                ($log->action === 'updated' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                                                ($log->action === 'deleted' ? 'bg-red-50 text-red-700 border-red-200' :
                                                'bg-gray-50 text-gray-700 border-gray-200'))
                                            }}">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}
                                            </span>
                                            @if($log->auditable_id)
                                                <span class="text-sm text-gray-400">#{{ $log->auditable_id }}</span>
                                            @endif
                                        </div>

                                        <p class="mt-1 text-sm font-medium text-gray-900">
                                            @if($log->user)
                                                {{ $log->user->name }}
                                            @else
                                                {{ __('Sistem / System') }}
                                            @endif
                                        </p>

                                        @if($log->notes)
                                            <p class="mt-1 text-sm text-gray-600">{{ $log->notes }}</p>
                                        @endif

                                        <div class="mt-2 flex items-center space-x-4 text-xs text-gray-500">
                                            <span>{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                                            <span>{{ $log->ip_address }}</span>
                                            @if($log->old_values || $log->new_values)
                                                <button
                                                    wire:click="viewLogDetails({{ $log->id }})"
                                                    class="text-blue-600 hover:text-blue-800 font-medium"
                                                >
                                                    {{ $selected_log === $log->id ? __('Sembunyikan / Hide') : __('Lihat Perubahan / View Changes') }}
                                                </button>
                                            @endif
                                        </div>

                                        {{-- Change Details --}}
                                        @if($selected_log === $log->id && ($log->old_values || $log->new_values))
                                            <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    @if($log->old_values)
                                                        <div>
                                                            <h4 class="text-xs font-medium text-gray-700 mb-2">{{ __('Nilai Lama / Old Values') }}</h4>
                                                            <pre class="text-xs text-gray-600 bg-white p-2 rounded border">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                        </div>
                                                    @endif
                                                    @if($log->new_values)
                                                        <div>
                                                            <h4 class="text-xs font-medium text-gray-700 mb-2">{{ __('Nilai Baharu / New Values') }}</h4>
                                                            <pre class="text-xs text-gray-600 bg-white p-2 rounded border">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($view_mode === 'compact')
                {{-- Compact Table View --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Masa / Time') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Pengguna / User') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Aksi / Action') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Model') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('IP Address') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($logs as $log)
                                <tr wire:key="compact-{{ $log->id }}" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->user ? $log->user->name : 'System' }}
                                        </div>
                                        @if($log->user)
                                            <div class="text-sm text-gray-500">{{ $log->user->email }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border {{
                                            $log->action === 'created' ? 'bg-green-50 text-green-700 border-green-200' :
                                            ($log->action === 'updated' ? 'bg-blue-50 text-blue-700 border-blue-200' :
                                            ($log->action === 'deleted' ? 'bg-red-50 text-red-700 border-red-200' :
                                            'bg-gray-50 text-gray-700 border-gray-200'))
                                        }}">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}
                                        @if($log->auditable_id)
                                            <span class="text-gray-400">#{{ $log->auditable_id }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $log->ip_address }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Timeline View --}}
                <div class="flow-root px-6 py-4">
                    <ul class="-mb-8">
                        @foreach($logs as $log)
                            <li wire:key="timeline-{{ $log->id }}">
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    <strong>{{ $log->user ? $log->user->name : 'System' }}</strong>
                                                    {{ strtolower($log->action) }}
                                                    <strong>{{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}</strong>
                                                    @if($log->auditable_id)
                                                        #{{ $log->auditable_id }}
                                                    @endif
                                                </p>
                                                @if($log->notes)
                                                    <p class="mt-1 text-sm text-gray-600">{{ $log->notes }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>{{ $log->created_at->format('H:i') }}</time>
                                                <br>
                                                <span class="text-xs">{{ $log->created_at->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    {{ __('Tiada Log Audit / No Audit Logs') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Tiada aktiviti yang sepadan dengan penapis yang dipilih / No activities match the selected filters') }}
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
