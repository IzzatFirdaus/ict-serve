<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="myds-container max-w-md mx-auto py-10">
        <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
            <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-1">Sign in to iServe</h1>
            <p class="text-body-sm text-txt-black-600 mb-6">Use your MOTAC account to continue</p>

            @if(session('status'))
                <x-myds.callout variant="success" class="mb-4">{{ session('status') }}</x-myds.callout>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate class="space-y-4">
                @csrf

                <x-myds.input
                    name="email"
                    type="email"
                    label="Email Address"
                    :value="old('email')"
                    autocomplete="email"
                    required
                />

                <x-myds.input
                    name="password"
                    type="password"
                    label="Password"
                    autocomplete="current-password"
                    required
                />

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-primary-600 border-otl-gray-300 rounded">
                    <span class="text-body-sm text-txt-black-700">Remember me</span>
                </label>

                <x-myds.button type="submit" variant="primary" class="w-full">Sign in</x-myds.button>
            </form>

            @if (Route::has('register'))
                <p class="text-body-sm text-txt-black-600 mt-6 text-center">
                    No account?
                    <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 myds-hover-underline">Register</a>
                </p>
            @endif
        </div>
    </div>
</x-guest-layout>

