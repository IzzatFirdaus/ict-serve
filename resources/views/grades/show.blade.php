{{--
  Grades Show (Read/Details) View — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.grade_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $grade->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.level') }}</th>
        <td>{{ $grade->level ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('grades.edit', $grade)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:grade-delete-modal :grade="$grade" />
    </div>
  </x-myds.panel>
@endsection
