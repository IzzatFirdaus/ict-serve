{{--
  Approval Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_approval')">
    <livewire:approval-form mode="create" />
  </x-myds.panel>
@endsection
