@extends('layouts.app')

@section('content')
<div class="myds-container max-w-lg mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-2">Verify your email</h1>
        @if (session('resent'))
            <x-myds.callout variant="success" class="mb-4">A new verification link has been sent to your email address.</x-myds.callout>
        @endif
        <p class="text-body-sm text-txt-black-700 mb-4">Before proceeding, please check your email for a verification link.</p>
        <p class="text-body-sm text-txt-black-700 mb-6">If you did not receive the email, you can request another one below.</p>

        @if (Route::has('verification.resend'))
            <form method="POST" action="{{ route('verification.resend') }}" class="space-y-4">
                @csrf
                <x-myds.button type="submit" variant="primary">Resend verification email</x-myds.button>
            </form>
        @endif
    </div>
</div>
@endsection
