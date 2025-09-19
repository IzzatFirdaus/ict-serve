@extends('layouts.app')

@section('title', __('Pilih Kata Laluan Baharu - ICTServe (iServe)'))

@section('content')
  <a
    href="#main-content"
    class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900"
  >
    Skip to main content
  </a>
  <div
    id="main-content"
    class="myds-container max-w-md mx-auto py-12"
    tabindex="-1"
  >
    <div
      class="bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu p-8"
    >
      <h1 class="myds-heading-md font-semibold text-txt-black-900 mb-1">
        {{ __('Pilih Kata Laluan Baharu') }}
      </h1>
      <p class="myds-body-sm text-txt-black-600 mb-6">
        {{ __('Masukkan emel dan kata laluan baharu anda') }}
      </p>

      @if (Route::has('password.update'))
        <form
          method="POST"
          action="{{ route('password.update') }}"
          class="space-y-5"
          novalidate
          aria-describedby="reset-desc"
        >
          @csrf
          <input type="hidden" name="token" value="{{ $token }}" />

          <x-myds.input
            name="email"
            type="email"
            label="{{ __('Alamat E-mel') }}"
            :value="old('email')"
            required
            autocomplete="email"
          />
          <x-myds.input
            name="password"
            type="password"
            label="{{ __('Kata Laluan Baharu') }}"
            required
            autocomplete="new-password"
          />
          <x-myds.input
            name="password_confirmation"
            type="password"
            label="{{ __('Sahkan Kata Laluan Baharu') }}"
            required
            autocomplete="new-password"
          />
          <x-myds.button type="submit" variant="primary" class="w-full">
            {{ __('Tetapkan semula kata laluan') }}
          </x-myds.button>
        </form>
      @else
        <x-myds.callout variant="warning">
          {{ __('Fungsi set semula kata laluan tidak tersedia pada persekitaran ini.') }}
        </x-myds.callout>
      @endif
    </div>
  </div>
@endsection
