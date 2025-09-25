{{--
  Positions Create (Add) View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_position')">
    <livewire:position-form mode="create" />
  </x-myds.panel>
@endsection
