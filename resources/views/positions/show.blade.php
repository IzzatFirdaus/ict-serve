{{--
  Positions Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.position_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.title') }}</th>
        <td>{{ $position->title }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.grade') }}</th>
        <td>{{ optional($position->grade)->name ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('positions.edit', $position)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:position-delete-modal :position="$position" />
    </div>
  </x-myds.panel>
@endsection
