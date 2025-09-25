{{--
  Equipment Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_equipment')">
    <livewire:equipment-form :equipment="$equipment" mode="edit" />
  </x-myds.panel>
@endsection
