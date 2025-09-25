{{--
  Users Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.user_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $user->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.email') }}</th>
        <td>{{ $user->email }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.role') }}</th>
        <td>{{ $user->role->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.department') }}</th>
        <td>{{ $user->department->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>
          <x-myds.pill :class="$user->is_active ? 'bg-success-100 text-success-800' : 'bg-danger-100 text-danger-800'">
            {{ $user->is_active ? __('messages.active') : __('messages.inactive') }}
          </x-myds.pill>
        </td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('users.edit', $user)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:user-delete-modal :user="$user" />
    </div>
  </x-myds.panel>
@endsection
