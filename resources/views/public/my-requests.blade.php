@extends('layouts.app')

@section('title', 'My Requests')

@section('content')
<div class="bg-bg-white">
    <!-- Header Section -->
    <div class="bg-bg-primary-600 text-txt-white py-8">
        <div class="myds-container">
            <h1 class="myds-heading-lg mb-2">My Requests</h1>
            <p class="myds-body-base text-txt-white opacity-80">Track your equipment loan requests and damage complaints</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-bg-gray-50 border-b border-otl-divider">
        <div class="myds-container py-4">
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('public.loan-request') }}" class="inline-flex items-center px-4 py-2 bg-bg-primary-600 text-txt-white rounded-[var(--radius-m)] myds-body-sm font-medium hover:bg-bg-primary-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    New Loan Request
                </a>
                <a href="{{ route('public.damage-complaint.guest') }}" class="inline-flex items-center px-4 py-2 bg-bg-danger-600 text-txt-white rounded-[var(--radius-m)] myds-body-sm font-medium hover:bg-bg-danger-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Report Damage
                </a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="myds-container py-8">
        <!-- Loan Requests Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="myds-heading-md text-txt-black-900">Equipment Loan Requests</h2>
                <span class="myds-body-sm text-txt-black-500">{{ $loanRequests->total() }} total requests</span>
            </div>

            @if($loanRequests->count() > 0)
                <div class="bg-bg-white shadow-sm border border-otl-gray-200 rounded-[var(--radius-l)] overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-otl-divider">
                            <thead class="bg-bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Request #</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Purpose</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Period</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Submitted</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-bg-white divide-y divide-otl-divider">
                                @foreach($loanRequests as $request)
                                    <tr class="hover:bg-bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-primary">
                                            {{ $request->request_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="myds-body-sm text-txt-black-900">{{ Str::limit($request->purpose, 50) }}</div>
                                            <div class="myds-body-sm text-txt-black-500">{{ $request->location }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-900">
                                            <div>{{ $request->requested_from->format('M j') }} - {{ $request->requested_to->format('M j, Y') }}</div>
                                            <div class="myds-body-xs text-txt-black-500">{{ $request->requested_from->diffInDays($request->requested_to) + 1 }} days</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $loanStatusClasses = match ($request->status) {
                                                    'pending_bpm_review' => 'bg-bg-warning-100 text-txt-warning-800',
                                                    'approved_by_bpm' => 'bg-bg-primary-100 text-txt-primary',
                                                    'approved_by_admin' => 'bg-bg-success-100 text-txt-success-800',
                                                    'rejected' => 'bg-bg-danger-100 text-txt-danger-800',
                                                    'equipment_assigned' => 'bg-bg-primary-100 text-txt-primary',
                                                    'in_use' => 'bg-bg-success-100 text-txt-success-800',
                                                    'returned' => 'bg-bg-gray-100 text-txt-black-700',
                                                    default => 'bg-bg-gray-100 text-txt-black-700',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[var(--radius-full)] myds-body-xs font-medium {{ $loanStatusClasses }}">
                                                {{ ucwords(str_replace('_', ' ', $request->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-500">
                                            {{ $request->submitted_at?->format('M j, Y') ?? $request->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium">
                                            <button type="button" onclick="showLoanDetails('{{ $request->id }}')" class="text-txt-primary hover:text-txt-primary">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $loanRequests->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-bg-gray-50 rounded-[var(--radius-l)]">
                    <svg class="mx-auto h-12 w-12 text-txt-black-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 myds-body-sm font-medium text-txt-black-900">No loan requests</h3>
                    <p class="mt-1 myds-body-sm text-txt-black-500">Get started by creating a new equipment loan request.</p>
                    <div class="mt-6">
                        <a href="{{ route('public.loan-request') }}" class="inline-flex items-center px-4 py-2 border border-otl-primary shadow-sm myds-body-sm font-medium rounded-[var(--radius-m)] text-txt-white bg-bg-primary-600 hover:bg-bg-primary-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            New Loan Request
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Helpdesk Tickets Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="myds-heading-md text-txt-black-900">Damage Complaints & Support Tickets</h2>
                <span class="myds-body-sm text-txt-black-500">{{ $tickets->total() }} total tickets</span>
            </div>

            @if($tickets->count() > 0)
                <div class="bg-bg-white shadow-sm border border-otl-gray-200 rounded-[var(--radius-l)] overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-otl-divider">
                            <thead class="bg-bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Ticket #</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Assigned To</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-left myds-body-xs font-medium text-txt-black-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-bg-white divide-y divide-otl-divider">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-danger-600">
                                            {{ $ticket->ticket_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="myds-body-sm text-txt-black-900">{{ Str::limit($ticket->title, 50) }}</div>
                                            <div class="myds-body-sm text-txt-black-500">{{ $ticket->damage_type ? ucwords(str_replace('_', ' ', $ticket->damage_type)) : 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $ticketPriorityClasses = match ($ticket->priority) {
                                                    'low' => 'bg-bg-success-100 text-txt-success-800',
                                                    'medium' => 'bg-bg-warning-100 text-txt-warning-800',
                                                    'high' => 'bg-bg-danger-100 text-txt-danger-800',
                                                    'critical' => 'bg-bg-danger-200 text-txt-danger-900',
                                                    default => 'bg-bg-gray-100 text-txt-black-700',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[var(--radius-full)] myds-body-xs font-medium {{ $ticketPriorityClasses }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $ticketStatusClasses = match ($ticket->status) {
                                                    'pending' => 'bg-bg-warning-100 text-txt-warning-800',
                                                    'in_progress' => 'bg-bg-primary-100 text-txt-primary',
                                                    'resolved' => 'bg-bg-success-100 text-txt-success-800',
                                                    'closed' => 'bg-bg-gray-100 text-txt-black-700',
                                                    default => 'bg-bg-gray-100 text-txt-black-700',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[var(--radius-full)] myds-body-xs font-medium {{ $ticketStatusClasses }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-500">
                                            {{ $ticket->assignedTo?->name ?? 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-500">
                                            {{ $ticket->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium">
                                            <button type="button" onclick="showTicketDetails('{{ $ticket->id }}')" class="text-txt-danger-600 hover:text-txt-danger-900">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $tickets->links() }}
                </div>
            @else
                    <div class="text-center py-12 bg-bg-gray-50 rounded-[var(--radius-l)]">
                    <svg class="mx-auto h-12 w-12 text-txt-black-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                        <h3 class="mt-2 myds-body-sm font-medium text-txt-black-900">No damage complaints</h3>
                        <p class="mt-1 myds-body-sm text-txt-black-500">No issues reported yet. You can report damaged equipment or technical issues.</p>
                    <div class="mt-6">
                            <a href="{{ route('public.damage-complaint.guest') }}" class="inline-flex items-center px-4 py-2 border border-otl-danger shadow-sm myds-body-sm font-medium rounded-[var(--radius-m)] text-txt-white bg-bg-danger-600 hover:bg-bg-danger-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Report Damage
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Loan Request Details Modal -->
<div id="loanDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-txt-black-900">Loan Request Details</h3>
                <button type="button" onclick="closeLoanModal()" class="text-txt-black-500 hover:text-txt-black-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div id="loanDetailsContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Ticket Details Modal -->
<div id="ticketDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-txt-black-900">Ticket Details</h3>
                <button type="button" onclick="closeTicketModal()" class="text-txt-black-500 hover:text-txt-black-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div id="ticketDetailsContent" class="space-y-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showLoanDetails(requestId) {
    // This would typically fetch data via AJAX
    // For now, we'll show a placeholder
    document.getElementById('loanDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-otl-primary-300 mx-auto"></div>
            <p class="mt-2 text-sm text-gray-500">Loading request details...</p>
        </div>
    `;
    document.getElementById('loanDetailsModal').classList.remove('hidden');

    // Simulate loading
    setTimeout(() => {
        document.getElementById('loanDetailsContent').innerHTML = `
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-txt-black-900">Request Information</h4>
                    <p class="text-sm text-txt-black-700">Details would be loaded here via AJAX call to fetch specific request data.</p>
                </div>
            </div>
        `;
    }, 500);
}

function showTicketDetails(ticketId) {
    // This would typically fetch data via AJAX
    // For now, we'll show a placeholder
    document.getElementById('ticketDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-danger-600 mx-auto"></div>
            <p class="mt-2 text-sm text-gray-500">Loading ticket details...</p>
        </div>
    `;
    document.getElementById('ticketDetailsModal').classList.remove('hidden');

    // Simulate loading
    setTimeout(() => {
        document.getElementById('ticketDetailsContent').innerHTML = `
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-txt-black-900">Ticket Information</h4>
                    <p class="text-sm text-txt-black-700">Details would be loaded here via AJAX call to fetch specific ticket data.</p>
                </div>
            </div>
        `;
    }, 500);
}

function closeLoanModal() {
    document.getElementById('loanDetailsModal').classList.add('hidden');
}

function closeTicketModal() {
    document.getElementById('ticketDetailsModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const loanModal = document.getElementById('loanDetailsModal');
    const ticketModal = document.getElementById('ticketDetailsModal');

    if (event.target === loanModal) {
        loanModal.classList.add('hidden');
    }
    if (event.target === ticketModal) {
        ticketModal.classList.add('hidden');
    }
}
</script>
@endsection
