<x-guest-layout>
    {{--
        Register view — resources/views/auth/register.blade.php
        - Follows MYDS & MyGovEA principles: accessible, citizen‑centric, consistent tokens/components.
        - Fields: name, email, password, password_confirmation
        - Server-side validation errors are surfaced inline and in an alert summary (aria-live).
    --}}

    <x-myds.container class="py-12">
        <div class="max-w-md mx-auto">
            <x-myds.card class="p-6">
                <div class="mb-6 text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center mb-4" aria-hidden="true">
                        <x-myds.icon name="user-plus" class="w-6 h-6 text-primary-600" />
                    </div>
                    <x-myds.heading level="1" class="mb-1 text-center">
                        {{ __('auth.register_title') ?? 'Create your account' }}
                    </x-myds.heading>
                    <x-myds.text size="sm" variant="muted">
                        {{ __('auth.register_subtitle') ?? 'Daftar untuk mengakses perkhidmatan ICT Serve (iServe)' }}
                    </x-myds.text>
                </div>

                {{-- Global form error summary for accessibility --}}
                @if ($errors->any())
                    <div class="mb-4" role="alert" aria-live="assertive">
                        <x-myds.callout variant="danger" dismissible="false">
                            <x-slot name="title">
                                {{ __('common.fix_errors') ?? 'Sila betulkan ralat berikut' }}
                            </x-slot>

                            <ul class="mt-2 list-disc pl-5 text-sm text-danger-800">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-myds.callout>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="space-y-4">
                        {{-- Full name --}}
                        <div>
                            <x-myds.input
                                id="name"
                                name="name"
                                type="text"
                                label="{{ __('auth.name') ?? 'Full name' }}"
                                :value="old('name')"
                                required
                                autofocus
                                :error="$errors->first('name')"
                                aria-describedby="{{ $errors->has('name') ? 'name-error' : '' }}"
                                placeholder="{{ __('auth.name_placeholder') ?? 'Nama penuh' }}"
                            />
                            @error('name')
                                <p id="name-error" class="mt-1 text-sm text-danger-600" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <x-myds.input
                                id="email"
                                name="email"
                                type="email"
                                label="{{ __('auth.email') ?? 'Email address' }}"
                                :value="old('email')"
                                required
                                :error="$errors->first('email')"
                                aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                                placeholder="{{ __('auth.email_placeholder') ?? 'nama@motac.gov.my' }}"
                                autocomplete="username"
                            />
                            @error('email')
                                <p id="email-error" class="mt-1 text-sm text-danger-600" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <x-myds.input
                                id="password"
                                name="password"
                                type="password"
                                label="{{ __('auth.password') ?? 'Password' }}"
                                required
                                :error="$errors->first('password')"
                                aria-describedby="{{ $errors->has('password') ? 'password-error' : 'password-help' }}"
                                placeholder="{{ __('auth.password_placeholder') ?? 'Pilih kata laluan yang selamat' }}"
                                autocomplete="new-password"
                            />

                            <p id="password-help" class="mt-1 text-xs text-txt-black-500">
                                {{ __('auth.password_help') ?? 'Minimum 8 characters. Use a mix of letters and numbers.' }}
                            </p>

                            @error('password')
                                <p id="password-error" class="mt-1 text-sm text-danger-600" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Confirm password --}}
                        <div>
                            <x-myds.input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                label="{{ __('auth.confirm_password') ?? 'Confirm password' }}"
                                required
                                :error="$errors->first('password_confirmation')"
                                aria-describedby="{{ $errors->has('password_confirmation') ? 'password-confirmation-error' : '' }}"
                                placeholder="{{ __('auth.confirm_password_placeholder') ?? 'Ulang kata laluan' }}"
                                autocomplete="new-password"
                            />
                            @error('password_confirmation')
                                <p id="password-confirmation-error" class="mt-1 text-sm text-danger-600" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:text-primary-700 underline">
                            <x-myds.icon name="arrow-left" class="w-4 h-4 inline mr-1" aria-hidden="true" />
                            {{ __('auth.already_registered') ?? 'Already registered?' }}
                        </a>

                        <x-myds.button type="submit" variant="primary" class="inline-flex items-center" aria-label="{{ __('auth.register') ?? 'Register' }}">
                            <x-myds.icon name="user-plus" class="w-4 h-4 mr-2" aria-hidden="true" />
                            {{ __('auth.register') ?? 'Register' }}
                        </x-myds.button>
                    </div>
                </form>
            </x-myds.card>

            {{-- Terms and privacy notice (minimal, citizen-centric) --}}
            <p class="mt-4 text-xs text-txt-black-500 text-center">
                {{ __('auth.terms_notice') ?? 'By registering you agree to our Terms of Use and Privacy Policy.' }}
            </p>
        </div>
    </x-myds.container>
</x-guest-layout>
