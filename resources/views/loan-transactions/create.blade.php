{{--
  Loan Transaction Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_transaction')">
    <livewire:loan-transaction-form mode="create" />
  </x-myds.panel>
@endsection
