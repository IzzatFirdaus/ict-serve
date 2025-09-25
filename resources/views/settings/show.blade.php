@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.setting_details')">
    <x-myds.summary-list>
      <x-myds.summary-list.item label="{{ __('messages.key') }}">{{ $setting->key ?? '-' }}</x-myds.summary-list.item>
      <x-myds.summary-list.item label="{{ __('messages.value') }}">{{ $setting->value ?? '-' }}</x-myds.summary-list.item>
      <x-myds.summary-list.item label="{{ __('messages.updated_at') }}">{{ optional($setting->updated_at)->format('d M Y') ?? '-' }}</x-myds.summary-list.item>
    </x-myds.summary-list>

    <div class="mt-6">
      <a href="{{ route('settings.edit', $setting) }}" class="text-primary-600">{{ __('messages.edit') }}</a>
      @include('settings._delete-modal', ['setting' => $setting])
    </div>
  </x-myds.panel>
@endsection
