@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_permission')">
    <livewire:permission-form :permission="$permission" mode="edit" />
  </x-myds.panel>
@endsection
