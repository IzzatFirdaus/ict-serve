<section>
    <header>
        <h2 class="myds-heading-2xs font-medium text-txt-black-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 myds-body-sm text-txt-black-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-myds.input
                type="text"
                id="name"
                name="name"
                label="Name"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                aria-describedby="name-error"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" id="name-error" />
        </div>

        <div>
            <x-myds.input
                type="email"
                id="email"
                name="email"
                label="Email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                aria-describedby="email-error"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" id="email-error" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="myds-body-sm mt-2 text-txt-black-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline myds-body-sm text-txt-primary hover:text-txt-black-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium myds-body-sm text-txt-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-myds.button variant="primary">{{ __('Save') }}</x-myds.button>

            @if (session('status') === 'profile-updated')
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
