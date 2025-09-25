{{--
  Damage Report Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_damage_report')">
    <livewire:damage-report-form :report="$report" mode="edit" />
  </x-myds.panel>
@endsection
