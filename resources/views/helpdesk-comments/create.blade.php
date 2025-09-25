{{--
  Helpdesk Comment Create — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.add_comment')">
    <livewire:helpdesk-comment-form mode="create" />
  </x-myds.panel>
@endsection
