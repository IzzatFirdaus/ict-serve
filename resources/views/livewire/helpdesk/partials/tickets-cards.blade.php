<!-- Tickets Card View -->
<div class="p-6">
    @if($tickets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tickets as $ticket)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                    <!-- Card Header -->
                    <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <!-- Ticket Number with Status Indicator -->
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($ticket->isOverdue())
                                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                    @elseif($ticket->isNew())
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    @else
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    @endif
                                    <span class="text-sm font-mono text-gray-600 dark:text-gray-400">
                                        {{ $ticket->ticket_number }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate mb-2">
                                    {{ $ticket->title }}
                                </h3>

                                <!-- Category -->
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $ticket->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Checkbox -->
                            <div class="flex-shrink-0 ml-3">
                                <input type="checkbox"
                                       wire:model.live="selectedTickets"
                                       value="{{ $ticket->id }}"
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5">
                        <!-- Description -->
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">
                            {{ Str::limit($ticket->description, 120) }}
                        </p>

                        <!-- Status & Priority Badges -->
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                       {{ $ticket->status->code === 'new' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                                          ($ticket->status->code === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                                          ($ticket->status->code === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                           'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300')) }}">
                                {{ $ticket->status->name }}
                            </span>

                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                       {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' :
                                          ($ticket->priority === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' :
                                          ($ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300')) }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>

                        <!-- Assigned To -->
                        <div class="flex items-center space-x-2 mb-4">
                            @if($ticket->assignedToUser)
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr($ticket->assignedToUser->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $ticket->assignedToUser->name }}
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 italic">
                                        Belum ditugaskan / Unassigned
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Equipment Item (if any) -->
                        @if($ticket->equipmentItem)
                            <div class="flex items-center space-x-2 mb-4 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $ticket->equipmentItem->brand }} {{ $ticket->equipmentItem->model }}
                                </span>
                            </div>
                        @endif

                        <!-- Date and Time Info -->
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            @if($ticket->due_at)
                                <div class="flex items-center space-x-1 {{ $ticket->isOverdue() ? 'text-red-500' : '' }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3l4 4m5-4a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Due: {{ $ticket->due_at->format('d/m/Y') }}</span>
                                    @if($ticket->isOverdue())
                                        <span class="text-red-500 font-medium">(Overdue)</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="px-5 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 rounded-b-xl">
                        <div class="flex items-center justify-between">
                            <!-- User Info -->
                            <div class="flex items-center space-x-2">
                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-500 flex items-center justify-center">
                                    <span class="text-xs font-medium text-white">
                                        {{ substr($ticket->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $ticket->user->name }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <!-- View Details -->
                                <button class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>

                                <!-- Quick Actions Menu -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open"
                                         x-transition
                                         @click.away="open = false"
                                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-20 border border-gray-200 dark:border-gray-700">

                                        <!-- Status Update Options -->
                                        @if(!$ticket->isClosed())
                                            <div class="py-1">
                                                <div class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                                                    Kemaskini Status / Update Status
                                                </div>
                                                @foreach($statuses as $status)
                                                    @if($status->id !== $ticket->status_id)
                                                        <button wire:click="updateTicketStatus({{ $ticket->id }}, '{{ $status->code }}')"
                                                                @click="open = false"
                                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            {{ $status->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Assignment Options (Admin/Supervisor only) -->
                                        @if(auth()->user()->role === 'ict_admin' || auth()->user()->role === 'supervisor')
                                            <div class="py-1 border-t border-gray-200 dark:border-gray-600">
                                                <div class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                                                    Tugaskan / Assign To
                                                </div>
                                                @foreach($technicians as $tech)
                                                    @if($tech->id !== $ticket->assigned_to)
                                                        <button wire:click="assignTicket({{ $ticket->id }}, {{ $tech->id }})"
                                                                @click="open = false"
                                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            {{ $tech->name }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                Tiada tiket ditemui / No tickets found
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                Cuba ubah penapis anda atau cipta tiket baharu / Try adjusting your filters or create a new ticket
            </p>
            <a href="{{ route('helpdesk.create-enhanced') }}"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Cipta Tiket Baharu / Create New Ticket
            </a>
        </div>
    @endif
</div>
