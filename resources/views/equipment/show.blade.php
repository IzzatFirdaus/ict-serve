{{--
  Equipment Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.equipment_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $equipment->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.category') }}</th>
        <td>{{ optional($equipment->category)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.location') }}</th>
        <td>{{ optional($equipment->location)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>{{ $equipment->status ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('equipment.edit', $equipment)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:equipment-delete-modal :equipment="$equipment" />
    </div>
  </x-myds.panel>
@endsection
