{{--
    ICTServe (iServe) — Tickets Table (MYDS + MyGovEA compliant)
    - Uses MYDS tokens/components for colours, spacing, icons, accessible patterns
    - Citizen-centric: responsive, ARIA, keyboard, non-colour status indicators, clear hierarchy
    - Follows MYDS Table, Tag, Avatar, Button, Icon, Pagination primitives
--}}

<div class="myds-card myds-card-bordered">
    <div class="myds-card-body p-0 overflow-x-auto" role="region" aria-labelledby="tickets-table-title">
        <h2 id="tickets-table-title" class="sr-only">Senarai Tiket / Tickets List</h2>
        <table class="myds-table min-w-full" role="table" aria-describedby="tickets-table-caption">
            <caption id="tickets-table-caption" class="sr-only">
                Jadual senarai tiket dengan pilihan, nombor tiket, tajuk, status, keutamaan, ditugaskan, tarikh dicipta dan tindakan.
            </caption>
            <thead class="myds-table-head">
                <tr>
                    <th scope="col" class="myds-table-th w-12">
                        <x-myds.checkbox
                            wire:model.live="selectAll"
                            id="select_all"
                            aria-label="Pilih semua tiket / Select all tickets"
                        />
                    </th>
                    <th scope="col" class="myds-table-th cursor-pointer" wire:click="sortBy('ticket_number')">
                        <div class="flex items-center space-x-2">
                            <span>Nombor Tiket / Ticket Number</span>
                            @if($sortBy === 'ticket_number')
                                <x-myds.icon :name="'chevron-'.($sortDirection === 'asc' ? 'up' : 'down')" class="myds-text-gray-500" />
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="myds-table-th cursor-pointer" wire:click="sortBy('title')">
                        <div class="flex items-center space-x-2">
                            <span>Tajuk / Title</span>
                            @if($sortBy === 'title')
                                <x-myds.icon :name="'chevron-'.($sortDirection === 'asc' ? 'up' : 'down')" class="myds-text-gray-500" />
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="myds-table-th">Status</th>
                    <th scope="col" class="myds-table-th cursor-pointer" wire:click="sortBy('priority')">
                        <div class="flex items-center space-x-2">
                            <span>Keutamaan / Priority</span>
                            @if($sortBy === 'priority')
                                <x-myds.icon :name="'chevron-'.($sortDirection === 'asc' ? 'up' : 'down')" class="myds-text-gray-500" />
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="myds-table-th">Ditugaskan / Assigned To</th>
                    <th scope="col" class="myds-table-th cursor-pointer text-right" wire:click="sortBy('created_at')">
                        <div class="flex items-center justify-end space-x-2">
                            <span>Dicipta / Created</span>
                            @if($sortBy === 'created_at')
                                <x-myds.icon :name="'chevron-'.($sortDirection === 'asc' ? 'up' : 'down')" class="myds-text-gray-500" />
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="myds-table-th text-right">Tindakan / Actions</th>
                </tr>
            </thead>
            <tbody class="myds-table-body">
                @forelse($tickets as $ticket)
                    <tr class="myds-table-row hover:bg-washed focus-within:bg-washed" tabindex="0">
                        <!-- Checkbox -->
                        <td class="myds-table-td">
                            <x-myds.checkbox
                                wire:model.live="selectedTickets"
                                value="{{ $ticket->id }}"
                                id="ticket_select_{{ $ticket->id }}"
                                aria-label="Pilih tiket {{ $ticket->ticket_number }}"
                            />
                        </td>
                        <!-- Ticket Number -->
                        <td class="myds-table-td">
                            <div class="flex items-center gap-3">
                                <x-myds.tag
                                    :variant="$ticket->isOverdue() ? 'danger' : ($ticket->isNew() ? 'success' : 'primary')"
                                    dot="true"
                                    size="small"
                                    :aria-label="$ticket->isOverdue() ? 'Overdue' : ($ticket->isNew() ? 'New' : 'In Progress')"
                                />
                                <div class="text-body-sm font-mono text-txt-black-700">
                                    {{ $ticket->ticket_number }}
                                </div>
                            </div>
                        </td>
                        <!-- Title -->
                        <td class="myds-table-td">
                            <div class="max-w-xs">
                                <div class="text-body-sm font-medium text-txt-black-900 truncate" title="{{ $ticket->title }}">
                                    {{ $ticket->title }}
                                </div>
                                <div class="text-body-xs text-txt-black-500 truncate" title="{{ Str::limit($ticket->description, 120) }}">
                                    {{ Str::limit($ticket->description, 60) }}
                                </div>
                            </div>
                        </td>
                        <!-- Status -->
                        <td class="myds-table-td">
                            @php
                                $statusVariant = match($ticket->status->code) {
                                    'new' => 'warning',
                                    'in_progress' => 'primary',
                                    'resolved', 'closed' => 'success',
                                    default => 'default',
                                };
                            @endphp
                            <x-myds.tag :variant="$statusVariant">{{ $ticket->status->name }}</x-myds.tag>
                            <span class="sr-only">Status: {{ $ticket->status->name }}</span>
                        </td>
                        <!-- Priority -->
                        <td class="myds-table-td">
                            @php
                                $priorityVariant = match($ticket->priority) {
                                    'critical' => 'danger',
                                    'high' => 'warning',
                                    'medium' => 'primary',
                                    'low' => 'success',
                                    default => 'default',
                                };
                            @endphp
                            <x-myds.tag :variant="$priorityVariant">{{ ucfirst($ticket->priority) }}</x-myds.tag>
                        </td>
                        <!-- Assigned To -->
                        <td class="myds-table-td">
                            @if($ticket->assignedToUser)
                                <div class="flex items-center gap-2">
                                    <x-myds.avatar :name="$ticket->assignedToUser->name" size="sm" />
                                    <div class="text-body-sm text-txt-black-700 truncate">
                                        {{ $ticket->assignedToUser->name }}
                                    </div>
                                </div>
                            @else
                                <div class="text-body-sm italic text-txt-black-500">
                                    Belum ditugaskan / Unassigned
                                </div>
                            @endif
                        </td>
                        <!-- Created Date -->
                        <td class="myds-table-td text-right">
                            <div class="text-body-sm text-txt-black-700">
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </div>
                            <div class="text-body-xs text-txt-black-500">
                                {{ $ticket->created_at->format('H:i') }}
                            </div>
                        </td>
                        <!-- Actions -->
                        <td class="myds-table-td text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View -->
                                <a href="{{ route('helpdesk.show', $ticket->id) }}"
                                   class="myds-button myds-button-tertiary myds-button-sm"
                                   title="Lihat Butiran / View details"
                                   aria-label="Lihat butiran tiket {{ $ticket->ticket_number }}">
                                    <x-myds.icon name="eye" />
                                </a>
                                <!-- Attachments -->
                                @if(!empty($ticket->file_attachments))
                                    <a href="{{ route('helpdesk.attachments', $ticket->id) }}"
                                       class="relative myds-button myds-button-tertiary myds-button-sm"
                                       title="Lampiran / Attachments"
                                       aria-label="Buka lampiran untuk tiket {{ $ticket->ticket_number }}">
                                        <x-myds.icon name="paper-clip" />
                                        <span class="myds-badge myds-badge-danger absolute -top-1 -right-2 text-xs" aria-hidden="true">
                                            {{ count($ticket->file_attachments) }}
                                        </span>
                                    </a>
                                @endif
                                <!-- Assign (Admin/Supervisor) -->
                                @if(in_array(auth()->user()->role, ['ict_admin', 'supervisor']))
                                    <a href="{{ route('helpdesk.assign', $ticket->id) }}"
                                       class="myds-button myds-button-tertiary myds-button-sm"
                                       title="Tugaskan / Assign"
                                       aria-label="Tugaskan tiket {{ $ticket->ticket_number }}">
                                        <x-myds.icon name="user-plus" />
                                    </a>
                                @endif
                                <!-- Quick status/actions dropdown -->
                                @if(!$ticket->isClosed())
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="myds-button myds-button-tertiary myds-button-sm"
                                                aria-haspopup="menu"
                                                :aria-expanded="open.toString()"
                                                title="Tindakan Cepat / Quick actions"
                                                aria-label="Tindakan cepat untuk tiket {{ $ticket->ticket_number }}">
                                            <x-myds.icon name="dots-horizontal" />
                                        </button>
                                        <div x-show="open"
                                             x-transition
                                             @click.away="open = false"
                                             class="myds-card myds-card-elevated absolute right-0 mt-2 w-48 z-30"
                                             role="menu"
                                             aria-label="Menu tindakan tiket {{ $ticket->ticket_number }}">
                                            <div class="py-1">
                                                <div class="px-4 py-2 text-body-xs text-txt-black-500 border-b otl-divider">Kemaskini Status / Update Status</div>
                                                @foreach($statuses as $status)
                                                    @if($status->id !== $ticket->status_id)
                                                        <button wire:click="updateTicketStatus({{ $ticket->id }}, '{{ $status->code }}')"
                                                                @click="open = false"
                                                                class="block w-full text-left px-4 py-2 text-body-sm text-txt-black-900 hover:bg-washed"
                                                                role="menuitem">
                                                            {{ $status->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if(in_array(auth()->user()->role, ['ict_admin', 'supervisor']))
                                                <div class="py-1 border-t otl-divider">
                                                    <div class="px-4 py-2 text-body-xs text-txt-black-500">Tugaskan / Assign To</div>
                                                    @foreach($technicians as $tech)
                                                        @if($tech->id !== $ticket->assigned_to)
                                                            <button wire:click="assignTicket({{ $ticket->id }}, {{ $tech->id }})"
                                                                    @click="open = false"
                                                                    class="block w-full text-left px-4 py-2 text-body-sm hover:bg-washed"
                                                                    role="menuitem">
                                                                {{ $tech->name }}
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="myds-table-td py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <x-myds.icon name="inbox" class="myds-text-gray-400 text-6xl" />
                                <h3 class="myds-heading-2xs text-txt-black-700">Tiada tiket ditemui / No tickets found</h3>
                                <p class="text-body-sm text-txt-black-500">
                                    Cuba ubah penapis atau cipta tiket baharu / Try changing filters or create a new ticket
                                </p>
                                <a href="{{ route('helpdesk.create-enhanced') }}"
                                   class="myds-button myds-button-primary mt-3"
                                   aria-label="Cipta Tiket Baharu / Create new ticket">
                                    <x-myds.icon name="plus" class="mr-2" />
                                    Cipta Tiket / Create Ticket
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Pagination / Controls --}}
    <div class="myds-card-body border-t otl-divider flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-body-sm text-txt-black-500">
            <span>Memaparkan {{ $tickets->firstItem() ?: 0 }}–{{ $tickets->lastItem() ?: 0 }} daripada {{ $tickets->total() }} tiket</span>
        </div>
        <div>
            {{ $tickets->links() }}
        </div>
    </div>
</div>
