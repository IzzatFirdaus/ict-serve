{{--
  Users Index (Browse) View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.users_title') }}
    </h1>
    <x-myds.button :href="route('users.create')" variant="primary">
      {{ __('messages.add_user') }}
    </x-myds.button>
  </div>
  <livewire:users-table />
@endsection
