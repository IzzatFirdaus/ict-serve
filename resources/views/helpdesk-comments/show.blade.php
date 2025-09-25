{{--
  Helpdesk Comment Show — MYDS, bilingual, accessible
--}}
@extends('layouts.app')

@section('content')
  <x-myds.panel :title="__('messages.comment_details')">
    <x-myds.summary-list>
      <tr>
        <th>{{ __('messages.author') }}</th>
        <td>{{ optional($comment->author)->name ?? '-' }}</td>
      </tr>
      <tr>
        <th>{{ __('messages.comment') }}</th>
        <td>{{ $comment->body }}</td>
      </tr>
    </x-myds.summary-list>
    <div class="mt-6 flex gap-3">
      <x-myds.button :href="route('helpdesk-comments.edit', $comment)" variant="primary">
        {{ __('messages.edit') }}
      </x-myds.button>
      <livewire:helpdesk-comment-delete-modal :comment="$comment" />
    </div>
  </x-myds.panel>
@endsection
