@extends('layouts.app')

@section('content')
<div class="space-y-4">
  <x-myds.notification type="success" icon="✔">
    {{ __('Operation completed successfully.') }}
  </x-myds.notification>

  <x-myds.notification type="error" icon="✖">
    {{ __('An error occurred while processing your request.') }}
  </x-myds.notification>

  <x-myds.notification type="warning" icon="⚠">
    {{ __('Please review the information and try again.') }}
  </x-myds.notification>
</div>
@endsection
