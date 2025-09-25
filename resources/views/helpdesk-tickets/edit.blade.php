{{--
  Helpdesk Ticket Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_ticket')">
    <livewire:helpdesk-ticket-form :ticket="$ticket" mode="edit" />
  </x-myds.panel>
@endsection
