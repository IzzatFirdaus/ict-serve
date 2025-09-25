{{--
  Equipment Category Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_equipment_category')">
    <livewire:equipment-category-form :category="$category" mode="edit" />
  </x-myds.panel>
@endsection
