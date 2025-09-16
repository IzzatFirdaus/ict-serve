@extends('layouts.app')

@section('title', __('Sahkan E-mel - ICTServe (iServe)'))

@section('content')
<a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900">
    Skip to main content
</a>
<div id="main-content" class="myds-container max-w-lg mx-auto py-12" tabindex="-1">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu p-8">
        <h1 class="myds-heading-md font-semibold text-txt-black-900 mb-3">{{ __('Sahkan E-mel Anda') }}</h1>
        @if (session('resent'))
            <x-myds.callout variant="success" class="mb-6">
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                    <circle cx="10" cy="10" r="8" stroke="currentColor" />
                    <path d="M7.5 10.5L9 12l3.5-3.5" stroke="currentColor" stroke-linecap="round"/>
                </svg>
                {{ __('Pautan pengesahan baharu telah dihantar ke alamat e-mel anda.') }}
            </x-myds.callout>
        @endif
        <p class="myds-body-sm text-txt-black-700 mb-2">{{ __('Sebelum meneruskan, sila semak e-mel anda untuk pautan pengesahan.') }}</p>
        <p class="myds-body-sm text-txt-black-700 mb-6">{{ __('Jika anda tidak menerima e-mel tersebut, anda boleh memintanya semula melalui butang di bawah.') }}</p>

        @if (Route::has('verification.resend'))
            <form method="POST" action="{{ route('verification.resend') }}" class="space-y-4">
                @csrf
                <x-myds.button type="submit" variant="primary" class="w-full" aria-label="Hantar semula e-mel pengesahan">
                    {{ __('Hantar Semula E-mel Pengesahan') }}
                </x-myds.button>
            </form>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="mt-6 text-center">
            @csrf
            <button
                type="submit"
                class="myds-body-sm text-txt-primary hover:text-txt-primary underline focus:outline-none focus:ring-2 focus:ring-fr-primary focus:ring-offset-2 rounded-md transition-colors"
                aria-label="Log keluar dari akaun anda"
            >
                {{ __('Log Keluar') }}
            </button>
        </form>
    </div>
</div>
@endsection
