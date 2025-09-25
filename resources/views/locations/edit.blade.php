{{--
  Locations Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_location')">
    <livewire:location-form :location="$location" mode="edit" />
  </x-myds.panel>
@endsection
