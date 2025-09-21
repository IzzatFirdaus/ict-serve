{{--
  File: resources/views/home.blade.php
  Purpose: Home/Dashboard for ICTServe (iServe)
  MYDS-compliant (Design, Develop, Icons, Colour)
  MyGovEA citizen-centric, accessible, and inclusive
--}}

@extends('layouts.app')

@section('content')
  {{-- Skip Link for accessibility --}}
  <a
    href="#main-content"
    class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 z-50 bg-primary-600 text-white px-4 py-2 rounded-md"
  >
    Skip to main content
  </a>

  <div class="bg-washed min-h-screen flex flex-col py-8">
    <main
      id="main-content"
      tabindex="-1"
      class="flex-1 flex justify-center items-start"
    >
      <section class="w-full max-w-lg mx-auto">
        {{-- Card: Welcome Panel --}}
        <div
          class="bg-white rounded-xl shadow-card border border-otl-gray-200 overflow-hidden"
        >
          {{-- Header: Home Icon and Title --}}
          <header class="flex items-center gap-3 px-6 py-5 bg-primary-600">
            <x-myds.icon name="home" size="24" class="text-white" aria-hidden="true" />
            <span class="myds-heading-xs font-semibold text-white">
              Dashboard
            </span>
          </header>
          <div class="px-6 py-8 text-center bg-washed">
            @if (session('status'))
              {{-- MYDS Success Callout --}}
              <x-myds.callout variant="success" class="mb-6">
                <div class="flex items-center gap-2">
                  <x-myds.icon name="check-circle" size="20" class="text-success-700" aria-hidden="true" />
                  <span class="myds-body-sm text-success-700">
                    {{ session('status') }}
                  </span>
                </div>
              </x-myds.callout>
            @endif

            <h2 class="myds-heading-md font-bold text-success-700 mb-2">
              Selamat Datang!
            </h2>
            <p class="myds-body-md text-txt-black-500 mb-6">
              Anda telah berjaya log masuk ke ICTServe (iServe).
            </p>
            <div class="flex flex-wrap justify-center gap-4">
              <x-myds.button href="{{ route('dashboard') }}" variant="primary" size="md" aria-label="Pergi ke Dashboard ICTServe">Dashboard ICTServe</x-myds.button>
              <x-myds.button href="{{ route('helpdesk.create-ticket') }}" variant="secondary" size="md" aria-label="Buat Aduan Kerosakan ICT">Buat Aduan Kerosakan</x-myds.button>
              <x-myds.button href="{{ route('equipment-loan.create') }}" variant="secondary" size="md" aria-label="Mohon Peminjaman Peralatan ICT">Mohon Peminjaman ICT</x-myds.button>
            </div>
          </div>
        </div>
        {{-- Accessibility Note --}}
        <div
          class="mt-6 text-center text-txt-black-500 myds-body-xs"
          aria-live="polite"
        >
          <span>
            Untuk bantuan akses atau pertanyaan, hubungi Unit Operasi Rangkaian
            &amp; Khidmat Pengguna BPM (
            <a
              href="tel:1234"
              class="text-primary-600 hover:underline"
              aria-label="Hubungi sambungan 1234"
            >
              ext. 1234
            </a>
            ).
          </span>
        </div>
      </section>
    </main>
  </div>
@endsection
