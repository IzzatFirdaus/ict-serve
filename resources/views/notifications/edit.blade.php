{{--
  Notification Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_notification')">
    <livewire:notification-form :notification="$notification" mode="edit" />
  </x-myds.panel>
@endsection
