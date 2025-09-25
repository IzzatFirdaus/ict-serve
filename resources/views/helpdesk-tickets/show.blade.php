{{--
  Helpdesk Ticket Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.ticket_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.ticket_number') }}</th>
        <td>{{ $ticket->reference_number ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.reported_by') }}</th>
        <td>{{ optional($ticket->reporter)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>{{ ucfirst($ticket->status ?? '-') }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('helpdesk-tickets.edit', $ticket)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:helpdesk-ticket-delete-modal :ticket="$ticket" />
    </div>
  </x-myds.panel>
@endsection
