{{--
  Loan Application Item Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.item_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.equipment') }}</th>
        <td>{{ optional($item->equipment)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.quantity') }}</th>
        <td>{{ $item->quantity }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('loan-application-items.edit', $item)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:loan-application-item-delete-modal :item="$item" />
    </div>
  </x-myds.panel>
@endsection
