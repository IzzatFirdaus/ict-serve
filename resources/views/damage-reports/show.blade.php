{{--
  Damage Report Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.damage_report_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.report_number') }}</th>
        <td>{{ $report->reference_number ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.reported_by') }}</th>
        <td>{{ optional($report->reporter)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.status') }}</th>
        <td>{{ ucfirst($report->status ?? '-') }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('damage-reports.edit', $report)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:damage-report-delete-modal :report="$report" />
    </div>
  </x-myds.panel>
@endsection
