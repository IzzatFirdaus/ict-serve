{{--
  Helpdesk Ticket Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_ticket')">
    <livewire:helpdesk-ticket-form mode="create" />
  </x-myds.panel>
@endsection
