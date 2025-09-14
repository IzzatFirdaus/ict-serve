<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6" role="form" aria-labelledby="register-heading">
        @csrf

        <h1 id="register-heading" class="myds-heading-md text-txt-black-900 text-center mb-6">Create Your Account</h1>

        <!-- Name -->
        <div class="myds-form-group">
            <x-myds.input
                type="text"
                id="name"
                name="name"
                label="Full Name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                aria-describedby="name-error"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" id="name-error" />
        </div>
<<<<<<< HEAD

        <!-- Email Address -->
        <div class="myds-form-group">
            <x-myds.input
                type="email"
                id="email"
                name="email"
                label="Email Address"
                :value="old('email')"
                required
                autocomplete="username"
                aria-describedby="email-error"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
        </div>

        <!-- Password -->
        <div class="myds-form-group">
            <x-myds.input
                type="password"
                id="password"
                name="password"
                label="Password"
                required
                autocomplete="new-password"
                aria-describedby="password-error password-help"
            />
            <p id="password-help" class="myds-body-xs text-txt-black-500 mt-1">Password must be at least 8 characters long</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />
        </div>

        <!-- Confirm Password -->
        <div class="myds-form-group">
            <x-myds.input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                label="Confirm Password"
                required
                autocomplete="new-password"
                aria-describedby="password-confirmation-error"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" id="password-confirmation-error" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md"
               href="{{ route('login') }}"
               aria-label="Sign in to existing account">
                {{ __('auth.already_registered') }}
            </a>

            <x-myds.button
                type="submit"
                variant="primary"
                class="ml-auto"
                aria-label="Create your account">
                {{ __('auth.register') }}
            </x-myds.button>
        </div>
    </form>
</x-guest-layout>
=======
    </div>
</div>
@extends('layouts.app')

@section('content')
<div class="myds-container max-w-md mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-1">Create an account</h1>
        <p class="text-body-sm text-txt-black-600 mb-6">Register to access iServe</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
            @csrf
            <x-myds.input name="name" label="Full Name" :value="old('name')" required autocomplete="name" />
            <x-myds.input name="email" type="email" label="Email Address" :value="old('email')" required autocomplete="email" />
            <x-myds.input name="password" type="password" label="Password" required autocomplete="new-password" />
            <x-myds.input name="password_confirmation" type="password" label="Confirm Password" required autocomplete="new-password" />
            <x-myds.button type="submit" variant="primary" class="w-full">Create account</x-myds.button>
        </form>
    </div>
</div>
@endsection
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
