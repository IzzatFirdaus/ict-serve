@section('title', "Ticket {$ticket->ticket_number} - ICTServe")

<div class="myds-container mx-auto px-4 py-8 max-w-4xl">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <div class="flex items-center space-x-4 mb-2">
                    <a href="{{ route('helpdesk.my-tickets') }}"
                       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to My Tickets
                    </a>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Ticket #{{ $ticket->ticket_number }}</h1>
                <p class="text-gray-600">{{ $ticket->title }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $ticket->ticketStatus->color ?? 'gray' }}-100 text-{{ $ticket->ticketStatus->color ?? 'gray' }}-800">
                    {{ $ticket->ticketStatus->name ?? 'Unknown' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Status Progress --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Ticket Progress</h3>
        <div class="relative">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Progress</span>
                <span class="text-sm text-gray-500">{{ $statusProgress['current'] }} of {{ $statusProgress['total'] }} steps</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: {{ $statusProgress['percentage'] }}%"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-500">
                <span>Open</span>
                <span>Assigned</span>
                <span>In Progress</span>
                <span>Resolved</span>
                <span>Closed</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Description --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                <div class="prose prose-sm max-w-none">
                    @if($showFullDescription || strlen($ticket->description) <= 300)
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</p>
                    @else
                        <p class="text-gray-700 whitespace-pre-wrap">{{ substr($ticket->description, 0, 300) }}...</p>
                        <button wire:click="toggleDescription"
                                class="mt-2 text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Show More
                        </button>
                    @endif

                    @if($showFullDescription && strlen($ticket->description) > 300)
                        <button wire:click="toggleDescription"
                                class="mt-2 text-primary-600 hover:text-primary-800 text-sm font-medium">
                            Show Less
                        </button>
                    @endif
                </div>
            </div>

            {{-- Attachments --}}
            @if($ticket->attachments && count($ticket->attachments) > 0)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Attachments</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($ticket->attachments as $attachment)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    @php
                                        $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment }}</p>
                                    <p class="text-sm text-gray-500">{{ strtoupper($extension) }} file</p>
                                </div>
                                <div class="ml-3">
                                    <button wire:click="downloadAttachment('{{ $attachment }}')"
                                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Resolution (if resolved) --}}
            @if($ticket->resolved_at)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-green-900 mb-4">Resolution</h3>
                    @if($ticket->resolution)
                        <p class="text-green-800 mb-4">{{ $ticket->resolution }}</p>
                    @endif
                    @if($ticket->resolution_notes)
                        <div class="text-sm text-green-700">
                            <strong>Notes:</strong> {{ $ticket->resolution_notes }}
                        </div>
                    @endif
                    <div class="mt-4 text-sm text-green-600">
                        Resolved on {{ $ticket->resolved_at->format('F j, Y \a\t g:i A') }}
                        @if($ticket->resolvedBy)
                            by {{ $ticket->resolvedBy->name }}
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Ticket Details --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ticket Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="text-sm text-gray-900">{{ $ticket->created_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Category</dt>
                        <dd class="text-sm text-gray-900">{{ $ticket->category->name ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Priority</dt>
                        <dd>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->color() }}">
                                {{ $ticket->priority->label() }}
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Urgency</dt>
                        <dd>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->urgency->color() }}">
                                {{ $ticket->urgency->label() }}
                            </span>
                        </dd>
                    </div>

                    @if($ticket->equipmentItem)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Equipment</dt>
                            <dd class="text-sm text-gray-900">
                                {{ $ticket->equipmentItem->name }}
                                @if($ticket->equipmentItem->serial_number)
                                    <br><span class="text-gray-500">S/N: {{ $ticket->equipmentItem->serial_number }}</span>
                                @endif
                            </dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="text-sm text-gray-900">{{ $ticket->location }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Phone</dt>
                        <dd class="text-sm text-gray-900">{{ $ticket->contact_phone }}</dd>
                    </div>

                    @if($ticket->due_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                            <dd class="text-sm {{ $ticket->isOverdue() ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                {{ $ticket->due_at->format('F j, Y \a\t g:i A') }}
                                @if($ticket->isOverdue())
                                    <span class="text-xs text-red-500">(Overdue)</span>
                                @endif
                            </dd>
                        </div>
                    @endif

                    @if($ticket->assignedTo)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
                            <dd class="text-sm text-gray-900">{{ $ticket->assignedTo->name }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- SLA Information --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-blue-900 mb-4">Service Level Agreement</h3>
                <p class="text-sm text-blue-800 mb-2">
                    Response time target based on priority: <strong>{{ $ticket->priority->label() }}</strong>
                </p>
                @if($ticket->response_time)
                    <p class="text-sm text-blue-700">
                        Response time: <strong>{{ number_format($ticket->response_time, 1) }} hours</strong>
                    </p>
                @endif
                @if($ticket->resolution_time)
                    <p class="text-sm text-blue-700">
                        Resolution time: <strong>{{ number_format($ticket->resolution_time, 1) }} hours</strong>
                    </p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('helpdesk.my-tickets') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View All Tickets
                    </a>

                    <a href="{{ route('helpdesk.create-ticket') }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Ticket
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
