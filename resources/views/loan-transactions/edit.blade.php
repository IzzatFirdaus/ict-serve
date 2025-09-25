{{--
  Loan Transaction Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_transaction')">
    <livewire:loan-transaction-form :transaction="$transaction" mode="edit" />
  </x-myds.panel>
@endsection
