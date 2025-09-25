@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_role')">
    <livewire:role-form :role="$role" mode="edit" />
  </x-myds.panel>
@endsection
