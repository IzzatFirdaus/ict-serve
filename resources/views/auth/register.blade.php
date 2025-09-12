<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
<<<<<<< HEAD

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
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
