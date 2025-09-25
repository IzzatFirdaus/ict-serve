@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_setting')">
    <livewire:setting-form mode="create" />
  </x-myds.panel>
@endsection
