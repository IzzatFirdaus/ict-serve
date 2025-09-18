{{--
  ICTServe (iServe) — Ticket list (MYDS & MyGovEA compliant)
  - Accessible: skip link, aria labels, keyboard-focusable controls, aria-live for updates
  - MYDS tokens/components: myds-container, myds-card, myds-btn, myds-select, myds-table, myds-tag, myds-icon-*
  - Bilingual copy (Malay / English)
  - Expected Livewire properties/methods:
    $tickets, $statuses, $categories, $filterStatus, $filterCategory, $filterPriority, $search,
    refreshList(), openTicket($id), export(), canAssign($ticket)
--}}

<div class="myds-container myds-py-6" id="helpdesk-ticket-list" role="region" aria-labelledby="ticket-list-title">
    {{-- Skip link for keyboard users --}}
    <a href="#ticket-table" class="myds-skip-link">Skip to ticket list / Langkau ke senarai tiket</a>

    {{-- Page header --}}
    <header class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 id="ticket-list-title" class="myds-heading-lg flex items-center gap-3">
                    <i class="myds-icon-list-bullet" aria-hidden="true"></i>
                    Senarai Tiket Bantuan ICT / ICT Helpdesk Tickets
                </h1>
                <p class="myds-text-body-md text-myds-gray-600 mt-1">
                    Lihat, tapis dan urus tiket bantuan — Citizen‑centric, accessible. / View, filter and manage helpdesk tickets.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('helpdesk.create') }}" class="myds-btn myds-btn-primary" aria-label="Cipta tiket baru / Create ticket">
                    <i class="myds-icon-plus-circle mr-2" aria-hidden="true"></i>
                    Cipta Tiket / Create Ticket
                </a>

                <button wire:click="refreshList" class="myds-btn myds-btn-tertiary" aria-label="Segar semula / Refresh list">
                    <i class="myds-icon-refresh" aria-hidden="true"></i>
                </button>

                <button wire:click="export" class="myds-btn myds-btn-ghost" aria-label="Eksport senarai / Export list">
                    <i class="myds-icon-download" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- Filters & Search --}}
    <section class="mb-6">
        <form class="myds-card myds-card-elevated p-4 grid grid-cols-1 md:grid-cols-4 gap-4 items-end" role="search" aria-label="Filters and search">
            <div>
                <label for="search" class="myds-label sr-only">Carian / Search</label>
                <input id="search" type="search" wire:model.debounce.500ms="search" class="myds-input" placeholder="Cari tajuk, no. tiket, pemohon... / Search title, ticket no., requester..." aria-label="Search tickets" />
            </div>

            <div>
                <label for="filter-status" class="myds-label">Status</label>
                <select id="filter-status" wire:model="filterStatus" class="myds-select" aria-label="Filter by status">
                    <option value="">Semua / All</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->code }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="filter-category" class="myds-label">Kategori / Category</label>
                <select id="filter-category" wire:model="filterCategory" class="myds-select" aria-label="Filter by category">
                    <option value="">Semua / All</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="filter-priority" class="myds-label">Keutamaan / Priority</label>
                <select id="filter-priority" wire:model="filterPriority" class="myds-select" aria-label="Filter by priority">
                    <option value="">Semua / All</option>
                    <option value="low">Rendah / Low</option>
                    <option value="medium">Sederhana / Medium</option>
                    <option value="high">Tinggi / High</option>
                    <option value="critical">Kritikal / Critical</option>
                </select>
            </div>
        </form>
    </section>

    {{-- Tickets table --}}
    <section id="ticket-table" tabindex="0" aria-label="Ticket table with filters and actions">
        <div class="myds-card myds-card-elevated">
            <div class="myds-card-header flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="myds-icon-table" aria-hidden="true"></i>
                    <div class="myds-heading-2xs">Keputusan Carian / Search results</div>
                </div>
                <div class="myds-text-body-xs text-myds-gray-500">
                    {{ $tickets->total() }} tiket / tickets
                </div>
            </div>

            <div class="myds-card-body p-0">
                <div class="overflow-x-auto">
                    <table class="myds-table w-full" role="table" aria-describedby="ticket-table-desc">
                        <caption id="ticket-table-desc" class="sr-only">Senarai tiket bantuan ICT — mengandungi tajuk, pemohon, status, keutamaan, kategori, tarikh dan tindakan. / ICT helpdesk ticket list — includes title, requester, status, priority, category, created date and actions.</caption>
                        <thead class="myds-table-head">
                            <tr>
                                <th class="myds-table-th w-12 text-center" scope="col" aria-label="Row number">#</th>
                                <th class="myds-table-th" scope="col">No. Tiket / Ticket No.</th>
                                <th class="myds-table-th" scope="col">Tajuk / Title</th>
                                <th class="myds-table-th" scope="col">Pemohon / Requester</th>
                                <th class="myds-table-th" scope="col">Status</th>
                                <th class="myds-table-th" scope="col">Keutamaan / Priority</th>
                                <th class="myds-table-th" scope="col">Kategori / Category</th>
                                <th class="myds-table-th" scope="col">Dicipta / Created</th>
                                <th class="myds-table-th w-40" scope="col">Tindakan / Actions</th>
                            </tr>
                        </thead>

                        <tbody class="myds-table-body">
                            @forelse($tickets as $idx => $ticket)
                                <tr class="myds-table-row">
                                    <td class="myds-table-td text-center">{{ $tickets->firstItem() + $idx }}</td>

                                    <td class="myds-table-td">
                                        <a href="javascript:void(0)" wire:click.prevent="openTicket({{ $ticket->id }})" class="underline text-primary-600 hover:text-primary-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary" aria-label="Open ticket {{ $ticket->ticket_number }}">
                                            <span class="font-mono">{{ $ticket->ticket_number }}</span>
                                        </a>
                                    </td>

                                    <td class="myds-table-td">
                                        <div class="font-medium text-myds-black-900 truncate" title="{{ $ticket->title }}">{{ $ticket->title }}</div>
                                        @if(!empty($ticket->summary))
                                            <div class="myds-text-body-xs text-myds-gray-500 truncate" title="{{ $ticket->summary }}">{{ $ticket->summary }}</div>
                                        @endif
                                    </td>

                                    <td class="myds-table-td">
                                        <div class="text-sm text-myds-gray-700">{{ $ticket->user?->name ?? '-' }}</div>
                                    </td>

                                    <td class="myds-table-td">
                                        {{-- Non-colour indicator + tag --}}
                                        <span class="inline-flex items-center gap-2">
                                            @if($ticket->status->code === 'new')
                                                <i class="myds-icon-circle myds-text-warning-600" aria-hidden="true" title="New"></i>
                                            @elseif($ticket->status->code === 'in_progress')
                                                <i class="myds-icon-circle myds-text-primary-600" aria-hidden="true" title="In progress"></i>
                                            @elseif($ticket->status->code === 'resolved')
                                                <i class="myds-icon-check myds-text-success-600" aria-hidden="true" title="Resolved"></i>
                                            @else
                                                <i class="myds-icon-circle myds-text-myds-gray-400" aria-hidden="true" title="{{ $ticket->status->name }}"></i>
                                            @endif

                                            <x-myds.tag :variant="($ticket->status->color ?? 'default')" size="small">
                                                {{ $ticket->status->name }}
                                            </x-myds.tag>
                                        </span>
                                    </td>

                                    <td class="myds-table-td">
                                        @php
                                            $priorityVariant = $ticket->priority === 'critical' ? 'danger' : ($ticket->priority === 'high' ? 'warning' : ($ticket->priority === 'medium' ? 'primary' : 'success'));
                                        @endphp
                                        <x-myds.tag :variant="$priorityVariant" size="small">
                                            {{ ucfirst($ticket->priority) }}
                                        </x-myds.tag>
                                    </td>

                                    <td class="myds-table-td">
                                        <div class="text-sm text-myds-gray-700">{{ $ticket->category?->name ?? '-' }}</div>
                                    </td>

                                    <td class="myds-table-td">
                                        <time class="text-sm text-myds-gray-600" datetime="{{ $ticket->created_at->toIso8601String() }}">{{ $ticket->created_at->format('d/m/Y H:i') }}</time>
                                    </td>

                                    <td class="myds-table-td">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="openTicket({{ $ticket->id }})" class="myds-btn myds-btn-tertiary myds-btn-icon" aria-label="Lihat / View ticket">
                                                <i class="myds-icon-eye" aria-hidden="true"></i>
                                            </button>

                                            @if(method_exists($this, 'canAssign') && $this->canAssign($ticket))
                                                <a href="{{ route('helpdesk.assignment', $ticket) }}" class="myds-btn myds-btn-primary myds-btn-icon" aria-label="Tugaskan / Assign ticket">
                                                    <i class="myds-icon-user-plus" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="myds-table-td py-12">
                                        <div class="myds-panel myds-panel-info myds-text-center p-6">
                                            <i class="myds-icon-inbox myds-text-gray-400 text-4xl mb-2" aria-hidden="true"></i>
                                            <div class="myds-heading-3xs mb-1">Tiada tiket dijumpai / No tickets found</div>
                                            <p class="myds-text-body-sm text-myds-gray-600">Sila ubah penapis carian atau cipta tiket baru. / Try changing filters or create a new ticket.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="myds-card-footer px-6 py-4 flex items-center justify-between">
                <div class="text-body-xs text-myds-gray-600">
                    Menunjukkan {{ $tickets->firstItem() ?? 0 }}–{{ $tickets->lastItem() ?? 0 }} daripada {{ $tickets->total() }} tiket / Showing {{ $tickets->firstItem() ?? 0 }}–{{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} tickets
                </div>

                <div>
                    {{ $tickets->links('vendor.pagination.myds') }}
                </div>
            </div>
        </div>
    </section>

    {{-- Live region for accessible notifications --}}
    <div aria-live="polite" class="sr-only" id="helpdesk-live-messages">
        @if(session('success')) {{ session('success') }} @endif
        @if(session('error')) {{ session('error') }} @endif
    </div>

    {{-- Visual toast notifications (non-blocking) --}}
    @if(session('success'))
        <div class="fixed bottom-6 right-6 z-50 myds-panel myds-panel-success myds-shadow-card max-w-sm" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,5000)">
            <div class="flex items-center gap-3 p-3">
                <i class="myds-icon-check-circle myds-text-success-600" aria-hidden="true"></i>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-6 right-6 z-50 myds-panel myds-panel-danger myds-shadow-card max-w-sm" x-data="{ show:true }" x-show="show" x-init="setTimeout(()=>show=false,5000)">
            <div class="flex items-center gap-3 p-3">
                <i class="myds-icon-x-circle myds-text-danger-600" aria-hidden="true"></i>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        </div>
    @endif
</div>
