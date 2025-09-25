{{--
  Grades Edit View — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_grade')">
    <livewire:grade-form :grade="$grade" mode="edit" />
  </x-myds.panel>
@endsection
