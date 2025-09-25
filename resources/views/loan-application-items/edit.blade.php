{{--
  Loan Application Item Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_item')">
    <livewire:loan-application-item-form :item="$item" mode="edit" />
  </x-myds.panel>
@endsection
