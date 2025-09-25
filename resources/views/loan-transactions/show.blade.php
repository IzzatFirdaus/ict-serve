{{--
  Loan Transaction Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.transaction_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.transaction_number') }}</th>
        <td>{{ $transaction->reference_number }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.loan_application') }}</th>
        <td>{{ optional($transaction->application)->reference_number ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.processed_at') }}</th>
        <td>{{ $transaction->processed_at?->format('d M Y') ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('loan-transactions.edit', $transaction)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:loan-transaction-delete-modal :transaction="$transaction" />
    </div>
  </x-myds.panel>
@endsection
