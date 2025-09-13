<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6" role="form" aria-labelledby="login-heading">
        @csrf

        <h1 id="login-heading" class="myds-heading-md text-txt-black-900 text-center mb-6">Sign In to ICTServe</h1>

        <!-- Email Address -->
        <div class="myds-form-group">
            <x-myds.input
                type="email"
                id="email"
                name="email"
                label="Email Address"
                :value="old('email')"
                required
                autofocus
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
                autocomplete="current-password"
                aria-describedby="password-error"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />
        </div>

        <!-- Remember Me -->
        <div class="myds-form-group">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                       class="rounded border-otl-gray-300 text-txt-primary shadow-sm focus:ring-fr-primary focus:ring-2 focus:ring-offset-2"
                       name="remember"
                       aria-describedby="remember-description">
                <span id="remember-description" class="ml-2 myds-body-sm text-txt-black-700">{{ __('auth.remember_me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md"
                   href="{{ route('password.request') }}"
                   aria-label="Reset your password">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-myds.button
                type="submit"
                variant="primary"
                class="ml-auto"
                aria-label="Sign in to your account">
                {{ __('auth.login') }}
            </x-myds.button>
        </div>
    </form>
</x-guest-layout>
