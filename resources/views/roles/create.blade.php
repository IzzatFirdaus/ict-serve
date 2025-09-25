{{--
  Role Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_role')">
    <livewire:role-form mode="create" />
  </x-myds.panel>
@endsection
