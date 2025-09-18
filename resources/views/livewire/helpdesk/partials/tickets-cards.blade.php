{{--
    ICTServe (iServe) – Tickets Card View
    MYDS & MyGovEA Compliant: Grid, tokens, icons, a11y, clear hierarchy
    Updates:
    - Uses MYDS tag, avatar, and icon primitives for status, assignment, actions.
    - Responsive 12/8/4 grid, with accessible structure and ARIA.
    - Non-colour indicators and accessible labels for all interactive elements.
    - Follows MYDS spacing, shadow, card, and button conventions.
--}}

<div class="myds-p-6">
    @if($tickets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tickets as $ticket)
                <article
                    class="myds-card myds-card-bordered myds-shadow-card transition-shadow duration-200 hover:myds-shadow-context-menu focus-within:myds-shadow-context-menu"
                    tabindex="0"
                    aria-labelledby="ticket-title-{{ $ticket->id }}"
                >
                    {{-- Card Header --}}
                    <header class="myds-card-header border-b otl-divider flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            {{-- Status Dot & Ticket Number --}}
                            <div class="flex items-center gap-2 mb-2">
                                <x-myds.tag
                                    :variant="$ticket->isOverdue() ? 'danger' : ($ticket->isNew() ? 'success' : 'primary')"
                                    dot="true"
                                    size="small"
                                    :mode="'pill'"
                                    :aria-label="$ticket->isOverdue() ? 'Overdue' : ($ticket->isNew() ? 'New' : 'In Progress')"
                                />
                                <span class="text-body-xs font-mono text-txt-black-500">
                                    {{ $ticket->ticket_number }}
                                </span>
                            </div>
                            {{-- Title --}}
                            <h3 id="ticket-title-{{ $ticket->id }}" class="myds-heading-2xs text-txt-black-900 truncate mb-2">
                                {{ $ticket->title }}
                            </h3>
                            {{-- Category --}}
                            <div class="flex items-center gap-2">
                                <x-myds.icon name="folder" class="w-4 h-4 text-txt-black-400" />
                                <span class="text-body-xs text-txt-black-500">
                                    {{ $ticket->category->name }}
                                </span>
                            </div>
                        </div>
                        {{-- Checkbox --}}
                        <div class="ml-3 flex-shrink-0">
                            <x-myds.checkbox
                                wire:model.live="selectedTickets"
                                value="{{ $ticket->id }}"
                                aria-label="Select ticket {{ $ticket->ticket_number }}"
                            />
                        </div>
                    </header>

                    {{-- Card Body --}}
                    <div class="myds-card-body">
                        <p class="text-body-sm text-txt-black-700 mb-4 line-clamp-2">
                            {{ Str::limit($ticket->description, 120) }}
                        </p>
                        <div class="flex items-center gap-2 mb-4">
                            <x-myds.tag
                                :variant="match($ticket->status->code) {
                                    'new' => 'warning',
                                    'in_progress' => 'primary',
                                    'resolved', 'closed' => 'success',
                                    default => 'default'
                                }"
                            >{{ $ticket->status->name }}</x-myds.tag>
                            <x-myds.tag
                                :variant="match($ticket->priority) {
                                    'critical' => 'danger',
                                    'high' => 'warning',
                                    'medium' => 'primary',
                                    default => 'success'
                                }"
                            >{{ ucfirst($ticket->priority) }}</x-myds.tag>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            @if($ticket->assignedToUser)
                                <div class="flex items-center gap-2">
                                    <x-myds.avatar :name="$ticket->assignedToUser->name" size="xs" />
                                    <span class="text-body-xs text-txt-black-900">
                                        {{ $ticket->assignedToUser->name }}
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <x-myds.avatar :name="'?'" size="xs" />
                                    <span class="text-body-xs text-txt-black-400 italic">
                                        Belum ditugaskan / Unassigned
                                    </span>
                                </div>
                            @endif
                        </div>
                        @if($ticket->equipmentItem)
                            <div class="flex items-center gap-2 mb-4 p-2 bg-washed rounded radius-m">
                                <x-myds.icon name="device-desktop" class="w-4 h-4 text-txt-black-400" />
                                <span class="text-body-xs text-txt-black-700">
                                    {{ $ticket->equipmentItem->brand }} {{ $ticket->equipmentItem->model }}
                                </span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between text-body-xs text-txt-black-500">
                            <div class="flex items-center gap-1">
                                <x-myds.icon name="clock" class="w-3 h-3" />
                                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($ticket->due_at)
                                <div class="flex items-center gap-1 {{ $ticket->isOverdue() ? 'text-danger-600' : '' }}">
                                    <x-myds.icon name="calendar" class="w-3 h-3" />
                                    <span>Due: {{ $ticket->due_at->format('d/m/Y') }}</span>
                                    @if($ticket->isOverdue())
                                        <span class="text-danger-600 font-medium">(Overdue)</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <footer class="myds-card-footer flex items-center justify-between border-t otl-divider px-5 py-3 bg-washed rounded-b-xl">
                        <div class="flex items-center gap-2">
                            <x-myds.avatar :name="$ticket->user->name" size="xs" />
                            <span class="text-body-xs text-txt-black-500">
                                {{ $ticket->user->name }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('helpdesk.show', $ticket->id) }}"
                               class="myds-btn myds-btn-tertiary myds-btn-icon"
                               title="Lihat Butiran / View Details" aria-label="View">
                                <x-myds.icon name="eye" class="w-4 h-4" />
                            </a>
                            @if(!empty($ticket->file_attachments))
                                <a href="{{ route('helpdesk.attachments', $ticket->id) }}"
                                   class="myds-btn myds-btn-tertiary myds-btn-icon relative"
                                   title="Lampiran / Attachments"
                                   aria-label="Attachments">
                                    <x-myds.icon name="paper-clip" class="w-4 h-4" />
                                    <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-danger-600 rounded-full">
                                        {{ count($ticket->file_attachments) }}
                                    </span>
                                </a>
                            @endif
                            @if(in_array(Auth::user()->role, ['ict_admin', 'supervisor']))
                                <a href="{{ route('helpdesk.assign', $ticket->id) }}"
                                   class="myds-btn myds-btn-tertiary myds-btn-icon"
                                   title="Tugaskan / Assign"
                                   aria-label="Assign">
                                    <x-myds.icon name="user-plus" class="w-4 h-4" />
                                </a>
                            @endif
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="myds-btn myds-btn-tertiary myds-btn-icon"
                                    aria-haspopup="menu"
                                    :aria-expanded="open.toString()"
                                    aria-label="Tindakan Cepat / Quick Actions">
                                    <x-myds.icon name="dots-horizontal" class="w-4 h-4" />
                                </button>
                                <div x-show="open"
                                     x-transition
                                     @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 bg-bg-white-0 shadow-context-menu rounded-lg border otl-divider z-20"
                                     role="menu"
                                     aria-label="Tindakan Tiket / Ticket Actions">
                                    @if(!$ticket->isClosed())
                                        <div class="py-1">
                                            <div class="px-4 py-2 text-xs font-medium text-txt-black-500 border-b otl-divider">
                                                Kemaskini Status / Update Status
                                            </div>
                                            @foreach($statuses as $status)
                                                @if($status->id !== $ticket->status_id)
                                                    <button wire:click="updateTicketStatus({{ $ticket->id }}, '{{ $status->code }}')"
                                                            @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-sm text-txt-black-900 hover:bg-washed transition"
                                                            role="menuitem">
                                                        {{ $status->name }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(auth()->user()->role === 'ict_admin' || auth()->user()->role === 'supervisor')
                                        <div class="py-1 border-t otl-divider">
                                            <div class="px-4 py-2 text-xs font-medium text-txt-black-500">
                                                Tugaskan / Assign To
                                            </div>
                                            @foreach($technicians as $tech)
                                                @if($tech->id !== $ticket->assigned_to)
                                                    <button wire:click="assignTicket({{ $ticket->id }}, {{ $tech->id }})"
                                                            @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-sm text-txt-black-900 hover:bg-washed transition"
                                                            role="menuitem">
                                                        {{ $tech->name }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </footer>
                </article>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-12 flex flex-col items-center justify-center">
            <x-myds.icon name="inbox" class="text-txt-black-200 text-6xl mb-4" />
            <h3 class="myds-heading-xs text-txt-black-700 mb-2">
                Tiada tiket ditemui / No tickets found
            </h3>
            <p class="text-body-sm text-txt-black-500 mb-6">
                Cuba ubah penapis anda atau cipta tiket baharu / Try adjusting your filters or create a new ticket
            </p>
            <a href="{{ route('helpdesk.create-enhanced') }}"
               class="myds-btn myds-btn-primary flex items-center gap-2"
               aria-label="Cipta Tiket Baharu / Create New Ticket">
                <x-myds.icon name="plus" class="w-5 h-5" />
                Cipta Tiket Baharu / Create New Ticket
            </a>
        </div>
    @endif
</div>
