{{--
  Role Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.role_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $role->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.permissions') }}</th>
        <td>{{ collect(optional($role->permissions))->pluck('name')->join(', ') ?: '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('roles.edit', $role)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:role-delete-modal :role="$role" />
    </div>
  </x-myds.panel>
@endsection
