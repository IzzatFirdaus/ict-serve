{{--
  Damage Report Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_damage_report')">
    <livewire:damage-report-form mode="create" />
  </x-myds.panel>
@endsection
