{{--
  Helpdesk Tickets Index — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.helpdesk_tickets_title') }}
    </h1>
    <x-myds.button :href="route('helpdesk-tickets.create')" variant="primary">
      {{ __('messages.add_ticket') }}
    </x-myds.button>
  </div>

  <livewire:helpdesk-tickets-table />
@endsection
