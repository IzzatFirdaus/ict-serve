{{--
  Notifications Index — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.notifications_title') }}
    </h1>
    <x-myds.button :href="route('notifications.create')" variant="primary">
      {{ __('messages.add_notification') }}
    </x-myds.button>
  </div>

  <livewire:notifications-table />
@endsection
