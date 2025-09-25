{{--
  Locations Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.location_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $location->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.code') }}</th>
        <td>{{ $location->code ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.address') }}</th>
        <td>{{ $location->address ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('locations.edit', $location)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:location-delete-modal :location="$location" />
    </div>
  </x-myds.panel>
@endsection
