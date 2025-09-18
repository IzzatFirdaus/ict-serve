{{--
    ICTServe (iServe) Helpdesk Ticket List
    - Combines all features from previous index.blade.php and index-enhanced.blade.php.
    - Conforms to MYDS guidelines (grid, color, typography, icons, components).
    - Applies MyGovEA citizen-centric and accessibility principles.
    - Responsive: 12/8/4 grid, optimized for desktop, tablet, and mobile.
    - All controls and contrast meet WCAG AA.
--}}

<div class="min-h-screen bg-bg-washed dark:bg-bg-washed">
    {{-- Skip Link for Accessibility --}}
    <a href="#main-content" class="myds-skip-link">Skip to main content</a>

    {{-- Masthead/Header --}}
    <x-myds.masthead>
        <x-myds.masthead-header>
            <x-myds.masthead-title>ICTServe Helpdesk</x-myds.masthead-title>
            {{-- (Optional) Add masthead trigger or language selector here --}}
        </x-myds.masthead-header>
        <x-myds.masthead-content>
            <x-myds.masthead-section title="Bantuan ICT" icon="support-agent">
                {{-- (Optional) Info or quick links --}}
            </x-myds.masthead-section>
        </x-myds.masthead-content>
    </x-myds.masthead>

    {{-- Announce Bar/Phase Banner (optional, e.g., Beta status) --}}
    {{--
    <x-myds.announce-bar>
        <x-myds.announce-bar-tag variant="beta" />
        <x-myds.announce-bar-description>
            Versi Beta. Sila beri maklum balas anda untuk penambahbaikan.
        </x-myds.announce-bar-description>
    </x-myds.announce-bar>
    --}}

    <main id="main-content" tabindex="0" class="myds-container max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Header Section with Stats --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-heading-m md:text-heading-l font-semibold text-txt-black-900 dark:text-txt-black-900">
                        Senarai Tiket Bantuan / Helpdesk Tickets
                    </h1>
                    <p class="text-body-base text-txt-black-700 dark:text-txt-black-700 mt-1">
                        Urus dan pantau tiket bantuan anda / Manage and monitor your ICT support tickets
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <x-myds.button :href="route('helpdesk.create')" variant="primary" size="sm" class="flex items-center">
                        <x-myds.button-icon>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </x-myds.button-icon>
                        Lapor Kerosakan Baharu / New Issue Report
                    </x-myds.button>
                    <x-myds.button :href="route('helpdesk.sla-tracker')" variant="secondary" size="sm" class="flex items-center">
                        <x-myds.button-icon>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </x-myds.button-icon>
                        SLA Tracker
                    </x-myds.button>
                    <x-myds.button wire:click="resetFilters" variant="tertiary" size="sm" class="flex items-center">
                        <x-myds.button-icon>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </x-myds.button-icon>
                        Reset
                    </x-myds.button>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4 mb-2">
                <x-myds.panel color="info">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-xs text-primary-200">Jumlah / Total</p>
                            <p class="text-heading-s font-semibold">{{ $stats['total'] ?? 0 }}</p>
                        </div>
                        <x-myds.icon name="list-bullet" class="w-7 h-7 text-primary-100" />
                    </div>
                </x-myds.panel>
                <x-myds.panel color="warning">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-xs text-warning-100">Baharu / New</p>
                            <p class="text-heading-s font-semibold">{{ $stats['open'] ?? 0 }}</p>
                        </div>
                        <x-myds.icon name="clock" class="w-7 h-7 text-warning-100" />
                    </div>
                </x-myds.panel>
                <x-myds.panel color="primary">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-xs text-primary-100">Dalam Proses / In Progress</p>
                            <p class="text-heading-s font-semibold">{{ $stats['in_progress'] ?? 0 }}</p>
                        </div>
                        <x-myds.icon name="arrow-path" class="w-7 h-7 text-primary-100" />
                    </div>
                </x-myds.panel>
                <x-myds.panel color="success">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-xs text-success-100">Selesai / Resolved</p>
                            <p class="text-heading-s font-semibold">{{ $stats['resolved'] ?? 0 }}</p>
                        </div>
                        <x-myds.icon name="check-circle" class="w-7 h-7 text-success-100" />
                    </div>
                </x-myds.panel>
                <x-myds.panel color="danger">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-body-xs text-danger-100">Lewat Tempoh / Overdue</p>
                            <p class="text-heading-s font-semibold">{{ $stats['overdue'] ?? 0 }}</p>
                        </div>
                        <x-myds.icon name="exclamation-triangle" class="w-7 h-7 text-danger-100" />
                    </div>
                </x-myds.panel>
            </div>
        </div>

        {{-- Filters Section --}}
        <section class="mb-8">
            <div class="myds-card bg-bg-white-0 dark:bg-bg-white-0 rounded-xl shadow-card border border-otl-gray-200 dark:border-otl-gray-200 mb-6">
                <div class="p-6">
                    {{-- Basic Filters --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="md:col-span-2">
                            <x-myds.input
                                label="Cari / Search"
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Cari nombor tiket, tajuk atau deskripsi…"
                                icon="search"
                                class="w-full"
                                aria-label="Search tickets"
                            />
                        </div>
                        <div>
                            <x-myds.select
                                label="Status"
                                wire:model.live="statusFilter"
                                class="w-full"
                                aria-label="Filter by status"
                            >
                                <option value="all">Semua Status / All Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->code ?? $status->name }}">{{ $status->name_my ?? $status->name_en ?? $status->name }}</option>
                                @endforeach
                            </x-myds.select>
                        </div>
                        <div>
                            <x-myds.select
                                label="Kategori / Category"
                                wire:model.live="categoryFilter"
                                class="w-full"
                                aria-label="Filter by category"
                            >
                                <option value="all">Semua Kategori / All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id ?? $category->name }}">{{ $category->name_my ?? $category->name_en ?? $category->name }}</option>
                                @endforeach
                            </x-myds.select>
                        </div>
                    </div>
                    {{-- Advanced Filters Toggle & View Mode --}}
                    <div class="flex items-center justify-between">
                        <button
                            type="button"
                            wire:click="toggleAdvancedFilters"
                            class="inline-flex items-center px-4 py-2 text-body-sm font-medium text-txt-black-700 dark:text-txt-black-300 hover:text-primary-600 focus:outline-none"
                            aria-expanded="{{ $showAdvancedFilters ? 'true' : 'false' }}"
                            aria-controls="advanced-filters"
                        >
                            <svg class="w-4 h-4 mr-2 transition-transform {{ $showAdvancedFilters ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            Penapis Lanjutan / Advanced Filters
                        </button>
                        <div class="flex items-center space-x-2">
                            <label class="text-body-sm font-medium text-txt-black-700 dark:text-txt-black-300">Paparan / View:</label>
                            <div class="flex bg-bg-washed dark:bg-bg-washed rounded-lg p-1">
                                <button wire:click="$set('viewMode', 'list')" type="button"
                                    class="px-3 py-1 rounded text-sm focus:outline-none {{ $viewMode === 'list' ? 'bg-bg-white-0 dark:bg-bg-white-0 text-primary-600 font-semibold shadow' : 'text-txt-black-500' }}">
                                    Senarai / List
                                </button>
                                <button wire:click="$set('viewMode', 'card')" type="button"
                                    class="px-3 py-1 rounded text-sm focus:outline-none {{ $viewMode === 'card' ? 'bg-bg-white-0 dark:bg-bg-white-0 text-primary-600 font-semibold shadow' : 'text-txt-black-500' }}">
                                    Kad / Card
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- Advanced Filters --}}
                    @if($showAdvancedFilters)
                        <div id="advanced-filters" class="border-t border-otl-gray-200 dark:border-otl-gray-200 mt-4 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <x-myds.select
                                        label="Keutamaan / Priority"
                                        wire:model.live="priorityFilter"
                                        class="w-full"
                                    >
                                        <option value="all">Semua / All</option>
                                        <option value="low">Rendah / Low</option>
                                        <option value="medium">Sederhana / Medium</option>
                                        <option value="high">Tinggi / High</option>
                                        <option value="critical">Kritikal / Critical</option>
                                    </x-myds.select>
                                </div>
                                <div>
                                    <x-myds.select
                                        label="Ditugaskan / Assigned To"
                                        wire:model.live="assigneeFilter"
                                        class="w-full"
                                    >
                                        <option value="all">Semua / All</option>
                                        <option value="unassigned">Belum Ditugaskan / Unassigned</option>
                                        @foreach($technicians as $tech)
                                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                        @endforeach
                                    </x-myds.select>
                                </div>
                                <div>
                                    <x-myds.select
                                        label="Tarikh / Date Range"
                                        wire:model.live="dateFilter"
                                        class="w-full"
                                    >
                                        <option value="all">Semua Tarikh / All Dates</option>
                                        <option value="today">Hari Ini / Today</option>
                                        <option value="week">Minggu Ini / This Week</option>
                                        <option value="month">Bulan Ini / This Month</option>
                                        <option value="overdue">Lewat Tempoh / Overdue</option>
                                    </x-myds.select>
                                </div>
                                <div>
                                    <x-myds.select
                                        label="Item Per Halaman / Items Per Page"
                                        wire:model.live="perPage"
                                        class="w-full"
                                    >
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </x-myds.select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="myTicketsOnly"
                                        class="myds-checkbox mr-2"
                                    >
                                    <span class="text-body-sm text-txt-black-700 dark:text-txt-black-300">
                                        Hanya tiket saya sahaja / My tickets only
                                    </span>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Bulk Actions --}}
        @if(!empty($selectedTickets))
            <div class="bg-primary-50 dark:bg-primary-950 border border-primary-200 dark:border-primary-800 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center space-x-4">
                        <span class="text-body-sm font-medium text-primary-900 dark:text-primary-100">
                            {{ count($selectedTickets) }} tiket dipilih / tickets selected
                        </span>
                        <select wire:model="bulkAction"
                            class="myds-select px-3 py-1 border border-primary-200 dark:border-primary-600 rounded text-sm focus:ring-2 focus:ring-primary-600 focus:border-primary-600 dark:bg-primary-950 dark:text-white"
                        >
                            <option value="">Pilih tindakan / Select action</option>
                            <option value="delete">Padam / Delete</option>
                            <option value="update_status">Kemaskini Status / Update Status</option>
                            <option value="update_priority">Kemaskini Keutamaan / Update Priority</option>
                            <option value="assign">Tugaskan / Assign</option>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-myds.button wire:click="executeBulkAction" variant="primary" size="sm">
                            Jalankan / Execute
                        </x-myds.button>
                        <x-myds.button wire:click="$set('selectedTickets', [])" variant="secondary" size="sm">
                            Batal / Cancel
                        </x-myds.button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Loading State --}}
        <div wire:loading.delay wire:target="search,statusFilter,categoryFilter,priorityFilter,assigneeFilter,dateFilter,perPage,myTicketsOnly"
             class="text-center py-4">
            <x-myds.spinner color="primary" size="medium" />
            <div class="inline-flex items-center px-4 py-2 text-body-sm text-txt-black-500">Memuatkan... / Loading...</div>
        </div>

        {{-- Tickets Content --}}
        <div wire:loading.remove wire:target="search,statusFilter,categoryFilter,priorityFilter,assigneeFilter,dateFilter,perPage,myTicketsOnly">
            <div class="myds-card bg-bg-white-0 dark:bg-bg-white-0 rounded-xl shadow-card border border-otl-gray-200 dark:border-otl-gray-200">
                @if($tickets->count() > 0)
                    @if($viewMode === 'list')
                        @include('livewire.helpdesk.partials.tickets-table', ['tickets' => $tickets])
                    @else
                        @include('livewire.helpdesk.partials.tickets-cards', ['tickets' => $tickets])
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12">
                        <x-myds.icon name="inbox" class="mx-auto h-12 w-12 text-txt-black-400 dark:text-txt-black-400 mb-4" />
                        <h3 class="mt-4 text-heading-xs font-medium text-txt-black-900 dark:text-txt-black-900">Tiada tiket dijumpai / No tickets found</h3>
                        <p class="mt-2 text-txt-black-700 dark:text-txt-black-700">
                            @if($this->search || $this->statusFilter !== 'all' || $this->categoryFilter !== 'all')
                                Cuba laras carian atau penapis anda / Try adjusting your search or filters
                            @else
                                Anda belum melaporkan sebarang isu lagi / You haven't reported any issues yet
                            @endif
                        </p>
                        <div class="mt-6">
                            <x-myds.button :href="route('helpdesk.create')" variant="primary" size="sm" class="flex items-center">
                                <x-myds.button-icon>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </x-myds.button-icon>
                                Lapor Kerosakan Pertama / Report First Issue
                            </x-myds.button>
                        </div>
                    </div>
                @endif
            </div>
            {{-- Pagination --}}
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        </div>
    </main>

    {{-- Toast Messages --}}
    @if (session('success'))
        <x-myds.toast variant="success" :show="true">
            {{ session('success') }}
        </x-myds.toast>
    @endif
    @if (session('error'))
        <x-myds.toast variant="danger" :show="true">
            {{ session('error') }}
        </x-myds.toast>
    @endif

    {{-- Footer --}}
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
</div>
