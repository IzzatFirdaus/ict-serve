{{--
  Equipment Category Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_equipment_category')">
    <livewire:equipment-category-form mode="create" />
  </x-myds.panel>
@endsection
