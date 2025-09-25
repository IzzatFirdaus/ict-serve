@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-gray-900">{{ __('messages.permissions') }}</h1>
    <a href="{{ route('permissions.create') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-primary-600 text-white">
      {{ __('messages.add_permission') }}
    </a>
  </div>

  <x-myds.panel>
    <livewire:permissions-table />
  </x-myds.panel>
@endsection
