{{--
  Helpdesk Comment Edit — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.edit_comment')">
    <livewire:helpdesk-comment-form :comment="$comment" mode="edit" />
  </x-myds.panel>
@endsection
