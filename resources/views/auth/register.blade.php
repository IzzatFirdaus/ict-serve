<x-guest-layout>
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

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

