{{--
  Equipment Sub-Category Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.equipment_subcategory_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $subcategory->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.category') }}</th>
        <td>{{ optional($subcategory->category)->name ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('equipment-sub-categories.edit', $subcategory)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:equipment-sub-category-delete-modal :subcategory="$subcategory" />
    </div>
  </x-myds.panel>
@endsection
