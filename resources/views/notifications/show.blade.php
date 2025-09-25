{{--
  Notification Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.notification_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.title') }}</th>
        <td>{{ $notification->title }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.message') }}</th>
        <td>{{ $notification->message }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('notifications.edit', $notification)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:notification-delete-modal :notification="$notification" />
    </div>
  </x-myds.panel>
@endsection
