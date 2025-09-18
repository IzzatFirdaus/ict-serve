@extends('layouts.app')

@section('title', __('Sahkan Kata Laluan - ICTServe (iServe)'))

@section('content')
<a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900">
    Skip to main content
</a>
<div id="main-content" class="myds-container max-w-md mx-auto py-12" tabindex="-1">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu p-8">
        <h1 class="myds-heading-md font-semibold text-txt-black-900 mb-2">{{ __('Sahkan Kata Laluan Anda') }}</h1>
        <p class="myds-body-sm text-txt-black-600 mb-6">{{ __('Sila masukkan kata laluan anda untuk meneruskan.') }}</p>

        @if (Route::has('password.confirm'))
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5" autocomplete="current-password" novalidate aria-describedby="password-confirm-desc">
                @csrf
                <x-myds.input
                    id="password"
                    name="password"
                    type="password"
                    label="{{ __('Kata Laluan') }}"
                    autocomplete="current-password"
                    required
                />
                <x-myds.button type="submit" variant="primary" class="w-full">{{ __('Sahkan') }}</x-myds.button>
            </form>

            @if (Route::has('password.request'))
                <p class="myds-body-xs text-txt-black-600 mt-4 text-center">
                    <a class="text-primary-600 hover:text-primary-700 myds-hover-underline" href="{{ route('password.request') }}">
                        {{ __('Lupa kata laluan?') }}
                    </a>
                </p>
            @endif
        @else
            <x-myds.callout variant="warning">
                {{ __('Fungsi pengesahan kata laluan tidak tersedia pada persekitaran ini. Sila hubungi pentadbir jika anda memerlukan akses.') }}
            </x-myds.callout>
        @endif
    </div>
</div>
@endsection
