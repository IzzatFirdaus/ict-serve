{{--
  Equipment Sub-Category Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_equipment_subcategory')">
    <livewire:equipment-sub-category-form :subcategory="$subcategory" mode="edit" />
  </x-myds.panel>
@endsection
