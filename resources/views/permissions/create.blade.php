@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_permission')">
    <livewire:permission-form mode="create" />
  </x-myds.panel>
@endsection
