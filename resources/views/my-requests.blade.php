@extends('layouts.app')

@section('title', __('My Requests'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('My Requests') }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Loan Requests -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">{{ __('Loan Requests') }}</h2>
                </div>
                <div class="p-6">
                    @if($loanRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($loanRequests as $request)
                                <div class="p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-900">{{ $request->request_number }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($request->status->code === 'approved') bg-green-100 text-green-800
                                            @elseif($request->status->code === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status->code === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $request->status->name }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ __('Purpose') }}: {{ $request->purpose }}</p>
                                    <p class="text-sm text-gray-500">{{ __('Requested') }}: {{ $request->created_at->format('d/m/Y H:i') }}</p>
                                    @if($request->loanItems->count() > 0)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">{{ __('Items') }}:</p>
                                            <ul class="text-sm text-gray-500 ml-4">
                                                @foreach($request->loanItems as $item)
                                                    <li>• {{ $item->equipmentItem->name }} ({{ $item->quantity }})</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">{{ __('No loan requests found.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Helpdesk Tickets -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">{{ __('Helpdesk Tickets') }}</h2>
                </div>
                <div class="p-6">
                    @if($helpdeskTickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($helpdeskTickets as $ticket)
                                <div class="p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-medium text-gray-900">{{ $ticket->ticket_number }}</h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($ticket->status->code === 'resolved') bg-green-100 text-green-800
                                            @elseif($ticket->status->code === 'open') bg-blue-100 text-blue-800
                                            @elseif($ticket->status->code === 'in_progress') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->status->code === 'closed') bg-gray-100 text-gray-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $ticket->status->name }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ __('Subject') }}: {{ $ticket->subject }}</p>
                                    @if($ticket->category)
                                        <p class="text-sm text-gray-600 mb-2">{{ __('Category') }}: {{ $ticket->category->name }}</p>
                                    @endif
                                    @if($ticket->equipmentItem)
                                        <p class="text-sm text-gray-600 mb-2">{{ __('Equipment') }}: {{ $ticket->equipmentItem->name }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500">{{ __('Created') }}: {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">{{ __('No helpdesk tickets found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
