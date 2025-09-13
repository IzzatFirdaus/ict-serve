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
