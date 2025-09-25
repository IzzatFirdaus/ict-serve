{{--
  Loan Application Item Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_item')">
    <livewire:loan-application-item-form mode="create" />
  </x-myds.panel>
@endsection
