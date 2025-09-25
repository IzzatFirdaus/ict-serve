{{--
  Departments Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_department')">
    <livewire:department-form :department="$department" mode="edit" />
  </x-myds.panel>
@endsection
