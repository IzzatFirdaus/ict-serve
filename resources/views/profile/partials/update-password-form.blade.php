<section>
    <header>
        <h2 class="myds-heading-2xs font-medium text-txt-black-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 myds-body-sm text-txt-black-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-myds.input
                type="password"
                id="update_password_current_password"
                name="current_password"
                label="Current Password"
                autocomplete="current-password"
                aria-describedby="current-password-error"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" id="current-password-error" />
        </div>

        <div>
            <x-myds.input
                type="password"
                id="update_password_password"
                name="password"
                label="New Password"
                autocomplete="new-password"
                aria-describedby="new-password-error"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" id="new-password-error" />
        </div>

        <div>
            <x-myds.input
                type="password"
                id="update_password_password_confirmation"
                name="password_confirmation"
                label="Confirm Password"
                autocomplete="new-password"
                aria-describedby="confirm-password-error"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" id="confirm-password-error" />
        </div>

        <div class="flex items-center gap-4">
            <x-myds.button variant="primary">{{ __('Save') }}</x-myds.button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="myds-body-sm text-txt-success"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
