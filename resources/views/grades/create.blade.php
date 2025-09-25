{{--
  Grades Create (Add) View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_grade')">
    <livewire:grade-form mode="create" />
  </x-myds.panel>
@endsection
