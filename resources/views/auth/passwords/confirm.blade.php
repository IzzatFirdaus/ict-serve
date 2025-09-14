@extends('layouts.app')

@section('content')
<div class="myds-container max-w-md mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-2">Confirm your password</h1>
        <p class="text-body-sm text-txt-black-600 mb-6">Please confirm your password before continuing.</p>

        @if (Route::has('password.confirm'))
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <x-myds.input
                    id="password"
                    name="password"
                    type="password"
                    label="Password"
                    autocomplete="current-password"
                    required
                />

                <x-myds.button type="submit" variant="primary" class="w-full">Confirm</x-myds.button>
            </form>

            @if (Route::has('password.request'))
                <p class="text-body-sm text-txt-black-600 mt-4 text-center">
                    <a class="text-primary-600 hover:text-primary-700 myds-hover-underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                </p>
            @endif
        @else
            <x-myds.callout variant="warning">
                Password confirmation is not available in this environment. Please contact the administrator if you need access.
            </x-myds.callout>
        @endif
    </div>
</div>
@endsection
