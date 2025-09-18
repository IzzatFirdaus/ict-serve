{{--
    ICTServe (iServe) – Audit Trail Viewer
    MYDS & MyGovEA Compliant: Grid, tokens, icons, a11y, citizen-centric, clear hierarchy
--}}

{{-- Skiplink for accessibility --}}
<a href="#main-content" class="myds-skip-link bg-primary-50 text-primary-600 focus:outline-none focus:ring-2 focus:ring-fr-primary px-4 py-2 absolute left-0 top-0 z-50 -translate-y-full focus:translate-y-0 transition shadow-context-menu">
    <span>Skip to main content</span>
</a>

<div class="bg-washed min-h-screen pb-16">
    {{-- Masthead/Header (optional, for agency branding/navigation) --}}
    @include('partials.masthead')

    <main id="main-content" class="max-w-6xl mx-auto px-4 md:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-txt-black-500">
                <li>
                    <a href="{{ route('dashboard') }}" class="hover:underline text-primary-600 focus-visible:underline">Utama</a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                        <path d="M7 6l5 4-5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </li>
                <li>
                    <span class="text-txt-black-700 font-medium">Audit Trail</span>
                </li>
            </ol>
        </nav>

        <section class="bg-white shadow-card rounded-lg mb-8">
            <div class="px-6 py-5 border-b otl-divider flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold text-txt-black-900 flex items-center gap-2">
                        {{-- MYDS "activity" (list/checklist) icon --}}
                        <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="16" rx="3" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M7 8h10M7 12h10M7 16h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        {{ __('Audit Trail / Jejak Audit') }}
                    </h1>
                    <p class="mt-1 text-base text-txt-black-500">
                        {{ __('Pantau dan analisis aktiviti sistem / Monitor and analyze system activities') }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        wire:click="toggleFilters"
                        type="button"
                        class="inline-flex items-center gap-2 bg-white border otl-gray-300 text-txt-black-700 px-4 py-2 rounded radius-s shadow-button hover:bg-washed focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                        aria-pressed="{{ $show_filters ? 'true' : 'false' }}"
                        aria-label="Toggle filters"
                    >
                        {{-- MYDS filter icon --}}
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M3 5h14M6 9h8M9 13h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <span>{{ __('Penapis / Filters') }}</span>
                    </button>
                    <button
                        wire:click="exportLogs"
                        type="button"
                        class="inline-flex items-center gap-2 bg-primary-600 text-white px-4 py-2 rounded radius-s shadow-button hover:bg-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                        aria-label="{{ __('Eksport / Export') }}"
                    >
                        {{-- MYDS download icon --}}
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M10 3v9m0 0l-3-3m3 3l3-3M4 14.5V17a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ __('Eksport / Export') }}</span>
                    </button>
                </div>
            </div>
            {{-- Statistics Overview --}}
            <div class="px-6 py-4 bg-washed">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-txt-black-900">{{ number_format($stats['total_logs']) }}</div>
                        <div class="text-xs text-txt-black-500">Total Log</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary-600">{{ number_format($stats['unique_users']) }}</div>
                        <div class="text-xs text-txt-black-500">Pengguna Unik</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-success-600">{{ number_format($stats['recent_24h']) }}</div>
                        <div class="text-xs text-txt-black-500">24 Jam Terakhir</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-warning-600">
                            {{ !empty($stats['top_actions']) ? array_keys($stats['top_actions'])[0] : 'N/A' }}
                        </div>
                        <div class="text-xs text-txt-black-500">Aksi Teratas</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Filters --}}
        @if($show_filters)
            <section aria-label="Audit Log Filters" class="bg-white shadow-card rounded-lg mb-8">
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <x-myds.input
                            label="{{ __('Carian / Search') }}"
                            wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('Cari pengguna, aksi, atau nota...') }}"
                        />
                        <x-myds.select
                            label="{{ __('Aksi / Action') }}"
                            wire:model.live="action"
                            :options="collect(['all' => __('Semua Aksi / All Actions')] + array_combine($actions, array_map('ucfirst', $actions)))"
                        />
                        <x-myds.select
                            label="{{ __('Jenis Model / Model Type') }}"
                            wire:model.live="auditable_type"
                            :options="collect(['all' => __('Semua Model / All Models')] + collect($auditableTypes)->mapWithKeys(fn($type) => ['App\Models\\'.$type => ucwords(str_replace('_', ' ', $type))])->toArray())"
                        />
                        <x-myds.select
                            label="{{ __('Pengguna / User') }}"
                            wire:model.live="user_id"
                            :options="collect(['all' => __('Semua Pengguna / All Users')] + collect($users)->mapWithKeys(fn($user) => [$user->id => $user->name.' ('.$user->email.')'])->toArray())"
                        />
                        <x-myds.date-field
                            label="{{ __('Dari Tarikh / From Date') }}"
                            wire:model.live="date_from"
                        />
                        <x-myds.date-field
                            label="{{ __('Hingga Tarikh / To Date') }}"
                            wire:model.live="date_to"
                        />
                    </div>
                    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-medium text-txt-black-700">{{ __('Paparan / View') }}:</label>
                                <div class="flex rounded-md shadow-button" role="group">
                                    @foreach(['detailed' => __('Terperinci / Detailed'), 'compact' => __('Padat / Compact'), 'timeline' => __('Garis Masa / Timeline')] as $mode => $label)
                                        <button
                                            wire:click="setViewMode('{{ $mode }}')"
                                            type="button"
                                            class="px-3 py-1 text-xs font-medium
                                                {{ $view_mode === $mode
                                                    ? 'bg-primary-600 text-white'
                                                    : 'bg-white text-txt-black-700 border otl-gray-300 hover:bg-primary-50' }}
                                                focus-visible:ring-2 focus-visible:ring-fr-primary
                                                {{ $loop->first ? 'rounded-l radius-s' : ($loop->last ? 'rounded-r radius-s' : '') }}"
                                            aria-pressed="{{ $view_mode === $mode ? 'true' : 'false' }}"
                                        >
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-medium text-txt-black-700">{{ __('Setiap Halaman / Per Page') }}:</label>
                                <select wire:model.live="per_page" class="block text-sm border otl-gray-300 rounded radius-s focus:ring-fr-primary focus:ring-2 px-2 py-1">
                                    @foreach([10, 25, 50, 100] as $num)
                                        <option value="{{ $num }}">{{ $num }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button
                            wire:click="resetFilters"
                            type="button"
                            class="inline-flex items-center gap-2 bg-white border otl-gray-300 text-txt-black-700 px-4 py-2 rounded radius-s shadow-button hover:bg-washed focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                        >
                            {{-- MYDS refresh icon --}}
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M4 4v4h4M16 16v-4h-4M6 8a6 6 0 1 1 2 8.485M14 12a6 6 0 1 0-2-8.485" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ __('Set Semula / Reset') }}</span>
                        </button>
                    </div>
                </div>
            </section>
        @endif

        {{-- Audit Logs List --}}
        <section class="bg-white shadow-card rounded-lg">
            @if($logs->count() > 0)
                @if($view_mode === 'detailed')
                    {{-- Detailed View --}}
                    <div class="divide-y divide-gray-100">
                        @foreach($logs as $log)
                            <div class="px-6 py-4 hover:bg-primary-50 focus-within:bg-primary-50 transition-colors duration-150" wire:key="audit-{{ $log->id }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-4">
                                        {{-- Icon: MYDS info or note icon --}}
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-washed flex items-center justify-center">
                                                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                                                    <circle cx="10" cy="10" r="9" stroke="currentColor" stroke-width="1.5"/>
                                                    <path d="M10 6.5a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5zM10 10v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border
                                                    @if($log->action === 'created') bg-success-50 text-success-700 border-success-200
                                                    @elseif($log->action === 'updated') bg-primary-50 text-primary-700 border-primary-200
                                                    @elseif($log->action === 'deleted') bg-danger-50 text-danger-700 border-danger-200
                                                    @else bg-gray-50 text-txt-black-700 border-otl-gray-300 @endif
                                                ">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                                <span class="text-sm text-txt-black-500">
                                                    {{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}
                                                </span>
                                                @if($log->auditable_id)
                                                    <span class="text-sm text-txt-black-400">#{{ $log->auditable_id }}</span>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-txt-black-900">
                                                {{ $log->user ? $log->user->name : __('Sistem / System') }}
                                            </p>
                                            @if($log->notes)
                                                <p class="mt-1 text-sm text-txt-black-700">{{ $log->notes }}</p>
                                            @endif
                                            <div class="mt-2 flex items-center gap-4 text-xs text-txt-black-500">
                                                <span>{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                                                <span>{{ $log->ip_address }}</span>
                                                @if($log->old_values || $log->new_values)
                                                    <button
                                                        wire:click="viewLogDetails({{ $log->id }})"
                                                        class="text-primary-600 hover:text-primary-800 font-medium focus-visible:underline"
                                                    >
                                                        {{ $selected_log === $log->id ? __('Sembunyikan / Hide') : __('Lihat Perubahan / View Changes') }}
                                                    </button>
                                                @endif
                                            </div>
                                            @if($selected_log === $log->id && ($log->old_values || $log->new_values))
                                                <div class="mt-3 p-3 bg-washed rounded radius-s">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        @if($log->old_values)
                                                            <div>
                                                                <h4 class="text-xs font-medium text-txt-black-700 mb-2">{{ __('Nilai Lama / Old Values') }}</h4>
                                                                <pre class="text-xs text-txt-black-700 bg-white p-2 rounded border otl-divider">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                            </div>
                                                        @endif
                                                        @if($log->new_values)
                                                            <div>
                                                                <h4 class="text-xs font-medium text-txt-black-700 mb-2">{{ __('Nilai Baharu / New Values') }}</h4>
                                                                <pre class="text-xs text-txt-black-700 bg-white p-2 rounded border otl-divider">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
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
                        <table class="min-w-full" role="table" aria-describedby="audit-compact-table-caption">
                            <caption id="audit-compact-table-caption" class="sr-only">Ringkasan audit log</caption>
                            <thead class="bg-washed border-b otl-divider">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">{{ __('Masa / Time') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">{{ __('Pengguna / User') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">{{ __('Aksi / Action') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">{{ __('Model') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 uppercase tracking-wider">{{ __('IP Address') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($logs as $log)
                                    <tr wire:key="compact-{{ $log->id }}" class="hover:bg-primary-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-900">
                                            {{ $log->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-txt-black-900">
                                                {{ $log->user ? $log->user->name : 'System' }}
                                            </div>
                                            @if($log->user)
                                                <div class="text-sm text-txt-black-500">{{ $log->user->email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border
                                                @if($log->action === 'created') bg-success-50 text-success-700 border-success-200
                                                @elseif($log->action === 'updated') bg-primary-50 text-primary-700 border-primary-200
                                                @elseif($log->action === 'deleted') bg-danger-50 text-danger-700 border-danger-200
                                                @else bg-gray-50 text-txt-black-700 border-otl-gray-300 @endif
                                            ">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-900">
                                            {{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}
                                            @if($log->auditable_id)
                                                <span class="text-txt-black-400">#{{ $log->auditable_id }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-500">
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
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-washed" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex gap-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 20 20" aria-hidden="true">
                                                        <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                                        <path d="M10 6.5a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5zM10 10v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between gap-4">
                                                <div>
                                                    <p class="text-sm text-txt-black-900">
                                                        <strong>{{ $log->user ? $log->user->name : 'System' }}</strong>
                                                        {{ strtolower($log->action) }}
                                                        <strong>{{ ucwords(str_replace('_', ' ', class_basename($log->auditable_type))) }}</strong>
                                                        @if($log->auditable_id)
                                                            #{{ $log->auditable_id }}
                                                        @endif
                                                    </p>
                                                    @if($log->notes)
                                                        <p class="mt-1 text-sm text-txt-black-700">{{ $log->notes }}</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
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
                <div class="px-6 py-4 border-t otl-divider">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-txt-black-200" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="6" width="16" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M9 12h6m-6 4h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <h3 class="mt-2 text-md font-semibold text-txt-black-900">
                        {{ __('Tiada Log Audit / No Audit Logs') }}
                    </h3>
                    <p class="mt-1 text-sm text-txt-black-500">
                        {{ __('Tiada aktiviti yang sepadan dengan penapis yang dipilih / No activities match the selected filters') }}
                    </p>
                </div>
            @endif
        </section>

        {{-- Loading State --}}
        <div wire:loading class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-context-menu">
                <div class="flex items-center gap-3">
                    <svg class="animate-spin h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-md text-txt-black-700">{{ __('Memproses... / Processing...') }}</span>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.footer')
</div>
