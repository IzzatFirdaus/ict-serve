{{--
  Loan Application Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.loan_application_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.application_number') }}</th>
        <td>{{ $application->reference_number }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.applicant') }}</th>
        <td>{{ optional($application->user)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>{{ ucfirst($application->status) }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.submitted_at') }}</th>
        <td>{{ $application->created_at?->format('d M Y') ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>

    <div class="mt-6">
      <h3 class="font-poppins text-lg font-medium text-gray-900">{{ __('messages.items') }}</h3>
      <livewire:loan-application-items-list :application="$application" />
    </div>

    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('loan-applications.edit', $application)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:loan-application-delete-modal :application="$application" />
    </div>
  </x-myds.panel>
@endsection
