@extends('layouts.app')

@section('content')
<div class="myds-container max-w-md mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-1">Choose a new password</h1>
        <p class="text-body-sm text-txt-black-600 mb-6">Enter your email and new password</p>

        @if (Route::has('password.update'))
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <x-myds.input name="email" type="email" label="Email Address" :value="old('email')" required autocomplete="email" />
            <x-myds.input name="password" type="password" label="New Password" required autocomplete="new-password" />
            <x-myds.input name="password_confirmation" type="password" label="Confirm New Password" required autocomplete="new-password" />
            <x-myds.button type="submit" variant="primary" class="w-full">Reset password</x-myds.button>
        </form>
        @else
            <x-myds.callout variant="warning">Password reset is not available in this environment.</x-myds.callout>
        @endif
    </div>
</div>
@endsection

