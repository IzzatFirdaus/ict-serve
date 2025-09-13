<x-guest-layout>
    <div class="mb-6">
        <h1 class="myds-heading-md text-txt-black-900 text-center mb-4">Reset Password</h1>
        <p class="myds-body-sm text-txt-black-700 text-center">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6" role="form" aria-labelledby="reset-password-heading">
        @csrf

        <div id="reset-password-heading" class="sr-only">Password Reset Form</div>

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
                aria-describedby="email-error"
                placeholder="Enter your registered email address"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
        </div>

        <div class="flex items-center justify-center mt-6">
            <x-myds.button
                type="submit"
                variant="primary"
                aria-label="Send password reset link to your email">
                {{ __('auth.email_password_reset_link') }}
            </x-myds.button>
        </div>

        <div class="text-center mt-4">
            <a class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md"
               href="{{ route('login') }}"
               aria-label="Back to sign in page">
                {{ __('auth.back_to_sign_in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
