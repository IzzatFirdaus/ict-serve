{{--
  Equipment Category Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.equipment_category_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.name') }}</th>
        <td>{{ $category->name }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.parent') }}</th>
        <td>{{ optional($category->parent)->name ?? '-' }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('equipment-categories.edit', $category)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:equipment-category-delete-modal :category="$category" />
    </div>
  </x-myds.panel>
@endsection
