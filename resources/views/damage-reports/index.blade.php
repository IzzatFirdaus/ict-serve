{{--
  Damage Reports Index — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.damage_reports_title') }}
    </h1>
    <x-myds.button :href="route('damage-reports.create')" variant="primary">
      {{ __('messages.add_damage_report') }}
    </x-myds.button>
  </div>

  <livewire:damage-reports-table />
@endsection
