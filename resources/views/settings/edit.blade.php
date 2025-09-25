@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_setting')">
    <livewire:setting-form :setting="$setting" mode="edit" />
  </x-myds.panel>
@endsection
