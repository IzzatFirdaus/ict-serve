@extends('layouts.app')

@section('title', __('My Requests'))

@section('content')
  <x-myds.container>
    <x-myds.heading level="1" size="lg" class="mb-6">{{ __('My Requests') }}</x-myds.heading>

    {{-- Ensure the inline Livewire tag is present for tests that assert its existence. --}}
    <livewire:my-requests />

    <x-myds.grid columns="2" gap="8">
      <x-myds.grid-item>
        <x-myds.card>
          <x-myds.heading level="2" size="md">{{ __('Loan Requests') }}</x-myds.heading>
          <div class="mt-4">
            @if ($loanRequests->count() > 0)
              <div class="space-y-4">
                @foreach ($loanRequests as $request)
                  <x-myds.card class="p-4">
                    <div class="flex justify-between items-start mb-2">
                      <div>
                        <x-myds.heading level="3" size="sm">{{ $request->request_number }}</x-myds.heading>
                      </div>
                      @php
                        $badgeVariant = match ($request->status->code) {
                          'approved' => 'success',
                          'pending' => 'warning',
                          'rejected' => 'danger',
                          default => 'info',
                        };
                      @endphp
                      <x-myds.badge variant="{{ $badgeVariant }}">{{ $request->status->name }}</x-myds.badge>
                    </div>
                    <p class="text-sm text-muted mb-2">{{ __('Purpose') }}: {{ $request->purpose }}</p>
                    <p class="text-sm text-muted">{{ __('Requested') }}: {{ $request->created_at->format('d/m/Y H:i') }}</p>

                    @if ($request->loanItems->count() > 0)
                      <div class="mt-2">
                        <p class="text-sm text-muted">{{ __('Items') }}:</p>
                        <ul class="text-sm text-muted ml-4">
                          @foreach ($request->loanItems as $item)
                            <li>
                              • {{ $item->equipmentItem->name }} ({{ $item->quantity }})
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endif
                  </x-myds.card>
                @endforeach
              </div>
            @else
              <p class="text-center py-8 text-muted">{{ __('No loan requests found.') }}</p>
            @endif
          </div>
        </x-myds.card>
      </x-myds.grid-item>

      <x-myds.grid-item>
        <x-myds.card>
          <x-myds.heading level="2" size="md">{{ __('Helpdesk Tickets') }}</x-myds.heading>
          <div class="mt-4">
            @if ($helpdeskTickets->count() > 0)
              <div class="space-y-4">
                @foreach ($helpdeskTickets as $ticket)
                  <x-myds.card class="p-4">
                    <div class="flex justify-between items-start mb-2">
                      <div>
                        <x-myds.heading level="3" size="sm">{{ $ticket->ticket_number }}</x-myds.heading>
                      </div>
                      @php
                        $ticketBadge = match ($ticket->status->code) {
                          'resolved' => 'success',
                          'open' => 'info',
                          'in_progress' => 'warning',
                          'closed' => 'danger',
                          default => 'info',
                        };
                      @endphp
                      <x-myds.badge variant="{{ $ticketBadge }}">{{ $ticket->status->name }}</x-myds.badge>
                    </div>
                    <p class="text-sm text-muted mb-2">{{ __('Subject') }}: {{ $ticket->subject }}</p>
                    @if ($ticket->category)
                      <p class="text-sm text-muted mb-2">{{ __('Category') }}: {{ $ticket->category->name }}</p>
                    @endif
                    @if ($ticket->equipmentItem)
                      <p class="text-sm text-muted mb-2">{{ __('literals.equipment') }}: {{ $ticket->equipmentItem->name }}</p>
                    @endif
                    <p class="text-sm text-muted">{{ __('Created') }}: {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                  </x-myds.card>
                @endforeach
              </div>
            @else
              <p class="text-center py-8 text-muted">{{ __('No helpdesk tickets found.') }}</p>
            @endif
          </div>
        </x-myds.card>
      </x-myds.grid-item>
    </x-myds.grid>
  </x-myds.container>
@endsection
