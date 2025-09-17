{{--
    ICTServe (iServe) – Tickets Card View
    MYDS & MyGovEA Compliant: Grid, tokens, icons, a11y, clear hierarchy
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
                            {{-- Ticket Number with Status Dot --}}
                            <div class="flex items-center gap-2 mb-2">
                                @if($ticket->isOverdue())
                                    <span class="myds-tag myds-tag-danger myds-tag-dot" aria-label="Overdue"></span>
                                @elseif($ticket->isNew())
                                    <span class="myds-tag myds-tag-success myds-tag-dot" aria-label="New"></span>
                                @else
                                    <span class="myds-tag myds-tag-primary myds-tag-dot" aria-label="In Progress"></span>
                                @endif
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
                                <i class="myds-icon-folder text-txt-black-400 w-4 h-4" aria-hidden="true"></i>
                                <span class="text-body-xs text-txt-black-500">
                                    {{ $ticket->category->name }}
                                </span>
                            </div>
                        </div>
                        {{-- Checkbox --}}
                        <div class="ml-3 flex-shrink-0">
                            <input type="checkbox"
                                   wire:model.live="selectedTickets"
                                   value="{{ $ticket->id }}"
                                   class="myds-checkbox"
                                   aria-label="Select ticket {{ $ticket->ticket_number }}">
                        </div>
                    </header>

                    {{-- Card Body --}}
                    <div class="myds-card-body">
                        {{-- Description --}}
                        <p class="text-body-sm text-txt-black-700 mb-4 line-clamp-2">
                            {{ Str::limit($ticket->description, 120) }}
                        </p>
                        {{-- Status & Priority Badges --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span class="myds-tag myds-tag-{{
                                $ticket->status->code === 'new' ? 'warning' :
                                ($ticket->status->code === 'in_progress' ? 'primary' :
                                ($ticket->status->code === 'resolved' ? 'success' : 'default'))
                            }}">
                                {{ $ticket->status->name }}
                            </span>
                            <span class="myds-tag myds-tag-{{
                                $ticket->priority === 'critical' ? 'danger' :
                                ($ticket->priority === 'high' ? 'warning' :
                                ($ticket->priority === 'medium' ? 'primary' : 'success'))
                            }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        {{-- Assigned To --}}
                        <div class="flex items-center gap-2 mb-4">
                            @if($ticket->assignedToUser)
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-primary-600 flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ mb_substr($ticket->assignedToUser->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-body-xs text-txt-black-900">
                                        {{ $ticket->assignedToUser->name }}
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="h-6 w-6 rounded-full bg-washed flex items-center justify-center">
                                        <i class="myds-icon-user text-txt-black-300 w-4 h-4" aria-hidden="true"></i>
                                    </div>
                                    <span class="text-body-xs text-txt-black-400 italic">
                                        Belum ditugaskan / Unassigned
                                    </span>
                                </div>
                            @endif
                        </div>
                        {{-- Equipment Item (if any) --}}
                        @if($ticket->equipmentItem)
                            <div class="flex items-center gap-2 mb-4 p-2 bg-washed rounded radius-m">
                                <i class="myds-icon-device-desktop text-txt-black-400 w-4 h-4" aria-hidden="true"></i>
                                <span class="text-body-xs text-txt-black-700">
                                    {{ $ticket->equipmentItem->brand }} {{ $ticket->equipmentItem->model }}
                                </span>
                            </div>
                        @endif
                        {{-- Date and Time Info --}}
                        <div class="flex items-center justify-between text-body-xs text-txt-black-500">
                            <div class="flex items-center gap-1">
                                <i class="myds-icon-clock w-3 h-3" aria-hidden="true"></i>
                                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($ticket->due_at)
                                <div class="flex items-center gap-1 {{ $ticket->isOverdue() ? 'text-danger-600' : '' }}">
                                    <i class="myds-icon-calendar w-3 h-3" aria-hidden="true"></i>
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
                        {{-- User Info --}}
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-txt-black-500 flex items-center justify-center">
                                <span class="text-xs font-medium text-white">
                                    {{ mb_substr($ticket->user->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="text-body-xs text-txt-black-500">
                                {{ $ticket->user->name }}
                            </span>
                        </div>
                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            {{-- View Details --}}
                            <button class="myds-btn myds-btn-tertiary myds-btn-icon" title="Lihat Butiran / View Details" aria-label="View">
                                <i class="myds-icon-eye w-4 h-4" aria-hidden="true"></i>
                            </button>
                            {{-- Attachments --}}
                            @if(!empty($ticket->file_attachments))
                                <a href="{{ route('helpdesk.attachments', $ticket->id) }}"
                                   class="myds-btn myds-btn-tertiary myds-btn-icon relative"
                                   title="Lampiran / Attachments"
                                   aria-label="Attachments">
                                    <i class="myds-icon-paperclip w-4 h-4" aria-hidden="true"></i>
                                    <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold text-white bg-danger-600 rounded-full">
                                        {{ count($ticket->file_attachments) }}
                                    </span>
                                </a>
                            @endif
                            {{-- Assignment (Admin/Supervisor only) --}}
                            @if(in_array(Auth::user()->role, ['ict_admin', 'supervisor']))
                                <a href="{{ route('helpdesk.assign', $ticket->id) }}"
                                   class="myds-btn myds-btn-tertiary myds-btn-icon"
                                   title="Tugaskan / Assign"
                                   aria-label="Assign">
                                    <i class="myds-icon-user-plus w-4 h-4" aria-hidden="true"></i>
                                </a>
                            @endif
                            {{-- Quick Actions Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="myds-btn myds-btn-tertiary myds-btn-icon"
                                    aria-haspopup="menu"
                                    aria-expanded="false"
                                    aria-label="Tindakan Cepat / Quick Actions">
                                    <i class="myds-icon-dots-horizontal w-4 h-4" aria-hidden="true"></i>
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
            <i class="myds-icon-inbox text-txt-black-200 text-6xl mb-4" aria-hidden="true"></i>
            <h3 class="myds-heading-xs text-txt-black-700 mb-2">
                Tiada tiket ditemui / No tickets found
            </h3>
            <p class="text-body-sm text-txt-black-500 mb-6">
                Cuba ubah penapis anda atau cipta tiket baharu / Try adjusting your filters or create a new ticket
            </p>
            <a href="{{ route('helpdesk.create-enhanced') }}"
               class="myds-btn myds-btn-primary flex items-center gap-2"
               aria-label="Cipta Tiket Baharu / Create New Ticket">
                <i class="myds-icon-plus w-5 h-5" aria-hidden="true"></i>
                Cipta Tiket Baharu / Create New Ticket
            </a>
        </div>
    @endif
</div>
