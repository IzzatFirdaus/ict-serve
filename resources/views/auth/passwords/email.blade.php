@extends('layouts.app')

@section('content')
<div class="myds-container max-w-md mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-1">Reset your password</h1>
        <p class="text-body-sm text-txt-black-600 mb-6">Enter your email to receive a password reset link</p>

        @if (session('status'))
            <x-myds.callout variant="success" class="mb-4">{{ session('status') }}</x-myds.callout>
        @endif

        @if (Route::has('password.email'))
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4" novalidate>
            @csrf
            <x-myds.input name="email" type="email" label="Email Address" :value="old('email')" required autocomplete="email" />
            <x-myds.button type="submit" variant="primary" class="w-full">Send reset link</x-myds.button>
        </form>
        @else
            <x-myds.callout variant="warning">Password reset is not available in this environment.</x-myds.callout>
        @endif
    </div>
</div>
@endsection
