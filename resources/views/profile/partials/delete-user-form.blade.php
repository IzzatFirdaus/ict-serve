<section class="space-y-6">
    <header>
        <h2 class="myds-heading-2xs font-medium text-txt-black-900">
            {{ __('auth.delete_account') }}
        </h2>

        <p class="mt-1 myds-body-sm text-txt-black-600">
            {{ __('auth.delete_account_warning') }}
        </p>
    </header>

    <x-myds.button
        variant="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('auth.delete_account') }}</x-myds.button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="myds-heading-2xs font-medium text-txt-black-900">
                {{ __('auth.delete_account_confirmation') }}
            </h2>

            <p class="mt-1 myds-body-sm text-txt-black-600">
                {{ __('auth.delete_account_password_prompt') }}
            </p>

            <div class="mt-6">
                <x-myds.input
                    type="password"
                    id="password"
                    name="password"
                    label="Password"
                    class="mt-1 block w-3/4"
                    placeholder="Password"
                    aria-describedby="password-deletion-error"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" id="password-deletion-error" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-myds.button variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('auth.cancel') }}
                </x-myds.button>

                <x-myds.button variant="danger">
                    {{ __('auth.delete_account') }}
                </x-myds.button>
            </div>
        </form>
    </x-modal>
</section>
