{{--
  Departments Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.department_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $department->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.code') }}</th>
        <td>{{ $department->code ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.parent') }}</th>
        <td>{{ $department->parent?->name ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('departments.edit', $department)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:department-delete-modal :department="$department" />
    </div>
  </x-myds.panel>
@endsection
