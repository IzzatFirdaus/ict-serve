{{--
  Equipment Sub-Categories Index — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.equipment_subcategories_title') }}
    </h1>
    <x-myds.button :href="route('equipment-sub-categories.create')" variant="primary">
      {{ __('messages.add_equipment_subcategory') }}
    </x-myds.button>
  </div>

  <livewire:equipment-sub-categories-table />
@endsection
