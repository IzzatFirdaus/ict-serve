{{--
  Users Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_user')">
    <livewire:user-form :user="$user" mode="edit" />
  </x-myds.panel>
@endsection
