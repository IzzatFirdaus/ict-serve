@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-gray-900">{{ __('messages.settings') }}</h1>
    <a href="{{ route('settings.create') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-primary-600 text-white">
      {{ __('messages.add_setting') }}
    </a>
  </div>

  <x-myds.panel>
    <livewire:settings-table />
  </x-myds.panel>
@endsection
