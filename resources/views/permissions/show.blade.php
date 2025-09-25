@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.permission_details')">
    <x-myds.summary-list>
      <x-myds.summary-list.item label="{{ __('messages.name') }}">{{ $permission->name ?? '-' }}</x-myds.summary-list.item>
      <x-myds.summary-list.item label="{{ __('messages.guard_name') }}">{{ $permission->guard_name ?? '-' }}</x-myds.summary-list.item>
      <x-myds.summary-list.item label="{{ __('messages.created_at') }}">{{ optional($permission->created_at)->format('d M Y') ?? '-' }}</x-myds.summary-list.item>
    </x-myds.summary-list>

    <div class="mt-6">
      <a href="{{ route('permissions.edit', $permission) }}" class="text-primary-600">{{ __('messages.edit') }}</a>
      @include('permissions._delete-modal', ['permission' => $permission])
    </div>
  </x-myds.panel>
@endsection
