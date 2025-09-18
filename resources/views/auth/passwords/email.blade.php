@extends('layouts.app')

@section('title', __('Tetapkan Semula Kata Laluan - ICTServe (iServe)'))

@section('content')
<a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900">
    Skip to main content
</a>
<div id="main-content" class="myds-container max-w-md mx-auto py-12" tabindex="-1">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu p-8">
        <h1 class="myds-heading-md font-semibold text-txt-black-900 mb-1">{{ __('Tetapkan Semula Kata Laluan') }}</h1>
        <p class="myds-body-sm text-txt-black-600 mb-6">{{ __('Masukkan emel anda untuk menerima pautan tetapan semula kata laluan') }}</p>

        @if (session('status'))
            <x-myds.callout variant="success" class="mb-4">{{ session('status') }}</x-myds.callout>
        @endif

        @if (Route::has('password.email'))
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5" novalidate aria-describedby="reset-email-desc">
            @csrf
            <x-myds.input
                name="email"
                type="email"
                label="{{ __('Alamat E-mel') }}"
                :value="old('email')"
                required
                autocomplete="email"
            />
            <x-myds.button type="submit" variant="primary" class="w-full">{{ __('Hantar pautan reset') }}</x-myds.button>
        </form>
        @else
            <x-myds.callout variant="warning">
                {{ __('Fungsi set semula kata laluan tidak tersedia pada persekitaran ini.') }}
            </x-myds.callout>
        @endif
    </div>
</div>
@endsection
