{{--
  Helpdesk Category Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_helpdesk_category')">
    <livewire:helpdesk-category-form mode="create" />
  </x-myds.panel>
@endsection
