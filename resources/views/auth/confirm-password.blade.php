<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6" role="form" aria-labelledby="confirm-heading">
        @csrf

        <h1 id="confirm-heading" class="myds-heading-md text-txt-black-900 text-center mb-6">Confirm Your Password</h1>

        <div class="mb-4 myds-body-sm text-txt-black-600 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
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

        <div class="flex justify-end mt-6">
            <x-myds.button
                type="submit"
                variant="primary"
                aria-label="Confirm password and continue">
                {{ __('Confirm') }}
            </x-myds.button>
        </div>
    </form>
</x-guest-layout>
