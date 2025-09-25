{{--
  Positions Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_position')">
    <livewire:position-form :position="$position" mode="edit" />
  </x-myds.panel>
@endsection
