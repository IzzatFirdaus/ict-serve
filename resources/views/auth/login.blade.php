<x-guest-layout>
    <main role="main">
        <h1 class="myds-heading-md font-semibold text-txt-black-900 mb-2 text-center">Log Masuk ke ICTServe</h1>
        <p class="myds-body-sm text-txt-black-700 mb-6 text-center">Gunakan akaun MOTAC anda untuk teruskan</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" role="form" aria-labelledby="login-heading">
            @csrf

            <!-- Email Address -->
            <div class="myds-form-group mb-4">
                <x-myds.input
                    id="email"
                    name="email"
                    type="email"
                    label="Alamat E-mel"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    aria-describedby="email-error"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
            </div>

            <!-- Password -->
            <div class="myds-form-group mb-4">
                <x-myds.input
                    id="password"
                    name="password"
                    type="password"
                    label="Kata Laluan"
                    required
                    autocomplete="current-password"
                    aria-describedby="password-error"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-6">
                <label for="remember_me" class="inline-flex items-center min-h-[44px]">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="h-4 w-4 text-primary-600 border-otl-gray-300 rounded focus:ring-2 focus:ring-primary-300"
                        name="remember"
                    >
                    <span class="ms-2 myds-body-sm text-txt-black-700">Ingat saya</span>
                </label>
            </div>

            <div class="flex flex-col items-stretch gap-4">
                <x-myds.button
                    type="submit"
                    variant="primary"
                    class="w-full min-h-[44px]"
                    aria-label="Log masuk ke ICTServe">
                    Log Masuk
                </x-myds.button>

                @if (Route::has('password.request'))
                    <a
                        class="min-h-[44px] flex items-center justify-center myds-body-sm text-txt-primary hover:text-txt-primary underline font-medium focus:outline-none focus:ring-2 focus:ring-primary-300 focus:ring-offset-2 rounded-md px-2 py-2"
                        href="{{ route('password.request') }}"
                    >
                        Terlupa kata laluan anda?
                    </a>
                @endif
            </div>
        </form>
    </main>
</x-guest-layout>
