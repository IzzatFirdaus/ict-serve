{{--
  Approval Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_approval')">
    <livewire:approval-form :approval="$approval" mode="edit" />
  </x-myds.panel>
@endsection
