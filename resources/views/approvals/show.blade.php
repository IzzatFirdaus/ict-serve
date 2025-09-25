{{--
  Approval Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.approval_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.reference') }}</th>
        <td>{{ $approval->reference ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>{{ ucfirst($approval->status ?? '-') }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('approvals.edit', $approval)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:approval-delete-modal :approval="$approval" />
    </div>
  </x-myds.panel>
@endsection
