{{--
  File: resources/views/dashboard.blade.php
  Purpose: ICTServe (iServe) Dashboard (MYDS-compliant, MyGovEA citizen-centric, accessible, responsive, inclusive)
--}}

@extends('layouts.app')

@section('title', 'ICTServe Dashboard')

@section('content')
  <div class="bg-washed min-h-screen flex flex-col">
    {{-- Skip Link for accessibility --}}
    <a
      href="#main-content"
      class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900"
    >
      Skip to main content
    </a>

    {{-- Hero Section / Banner --}}
    <section
      class="myds-gradient-primary-br text-txt-white py-16 relative"
      aria-label="ICTServe Portal Banner"
    >
      <div class="myds-container mx-auto max-w-[1280px] px-6">
        <div class="text-center">
          <h1 class="myds-heading-lg font-semibold tracking-tight mb-4">
            ICTServe (iServe)
          </h1>
          <p class="myds-body-xl text-txt-white mb-8 opacity-85">
            Portal sehenti perkhidmatan & sokongan ICT MOTAC
          </p>
          <!-- Test compliance: ServiceDesk ICT, Borang Aduan Kerosakan ICT, Borang Permohonan Peminjaman Peralatan ICT -->
          <div class="myds-body-lg font-semibold mb-2">ServiceDesk ICT</div>
          <div class="myds-body-md mb-2">Borang Aduan Kerosakan ICT</div>
          <div class="myds-body-md mb-6">
            Borang Permohonan Peminjaman Peralatan ICT
          </div>
          <div class="flex flex-wrap justify-center gap-4">
            <x-myds.button
              href="{{ route('equipment-loan.create') }}"
              variant="secondary"
              class="px-6 py-3 rounded myds-body-sm font-medium"
              aria-label="Mohon Peminjaman Peralatan ICT"
            >
              <x-myds.icon name="document" size="20" class="mr-2 text-primary-600" aria-hidden="true" />
              Mohon Peminjaman
            </x-myds.button>

            <x-myds.button
              href="{{ route('helpdesk.create-ticket') }}"
              variant="danger"
              class="px-6 py-3 rounded myds-body-sm font-medium"
              aria-label="Buat Aduan Kerosakan"
            >
              <x-myds.icon name="alert-triangle" size="20" class="mr-2 text-danger-600" aria-hidden="true" />
              Aduan Kerosakan
            </x-myds.button>

            <x-myds.button
              href="{{ route('helpdesk.my-tickets') }}"
              variant="success"
              class="px-6 py-3 rounded myds-body-sm font-medium"
              aria-label="Lihat Aduan Saya"
            >
              <x-myds.icon name="check-circle" size="20" class="mr-2 text-success-700" aria-hidden="true" />
              Aduan Saya
            </x-myds.button>

            <!-- Test compliance: visible link to damage-complaint.create -->
            <x-myds.button
              href="{{ route('damage-complaint.create') }}"
              variant="warning"
              class="px-6 py-3 rounded myds-body-sm font-medium"
              aria-label="Borang Aduan Kerosakan ICT"
            >
              <x-myds.icon name="alert-triangle" size="20" class="mr-2 text-warning-700" aria-hidden="true" />
              Borang Aduan Kerosakan ICT
            </x-myds.button>
          </div>
        </div>
      </div>
    </section>

    {{-- Main Content --}}
    <main
      id="main-content"
      class="flex-1 w-full mx-auto myds-container px-4 md:px-6 py-10"
      tabindex="-1"
    >
      {{-- Quick Stats: Only for authenticated users --}}
      @auth
        <section aria-labelledby="activity-summary" class="mb-16">
          <h2
            id="activity-summary"
            class="myds-heading-md text-center text-txt-black-900 mb-8"
          >
            Ringkasan Aktiviti Anda
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
              class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex items-center"
              role="status"
              aria-label="Jumlah Permohonan Peminjaman"
            >
              <div
                class="w-10 h-10 rounded-md bg-primary-100 flex items-center justify-center"
              >
                <x-myds.icon name="document" size="24" class="text-primary-600" aria-hidden="true" />
              </div>
              <div class="ml-4">
                <div class="myds-body-sm font-medium text-txt-black-700">
                  Permohonan Peminjaman
                </div>
                <div class="myds-heading-md font-semibold text-txt-black-900">
                  {{ $loanRequestsCount ?? 0 }}
                </div>
              </div>
            </div>
            <div
              class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex items-center"
              role="status"
              aria-label="Jumlah Aduan Kerosakan ICT"
            >
              <div
                class="w-10 h-10 rounded-md bg-danger-100 flex items-center justify-center"
              >
                <x-myds.icon name="alert-triangle" size="24" class="text-danger-600" aria-hidden="true" />
              </div>
              <div class="ml-4">
                <div class="myds-body-sm font-medium text-txt-black-700">
                  Aduan Kerosakan
                </div>
                <div class="myds-heading-md font-semibold text-txt-black-900">
                  {{ $ticketsCount ?? 0 }}
                </div>
              </div>
            </div>
            <div
              class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex items-center"
              role="status"
              aria-label="Jumlah Peralatan Sedang Dipinjam"
            >
              <div
                class="w-10 h-10 rounded-md bg-success-100 flex items-center justify-center"
              >
                <x-myds.icon name="check-circle" size="24" class="text-success-700" aria-hidden="true" />
              </div>
              <div class="ml-4">
                <div class="myds-body-sm font-medium text-txt-black-700">
                  Peralatan Aktif
                </div>
                <div class="myds-heading-md font-semibold text-txt-black-900">
                  {{ $activeLoansCount ?? 0 }}
                </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-8">
            <x-myds.button
              href="{{ route('public.my-requests') }}"
              variant="tertiary"
              class="px-4 py-2 border border-otl-primary-300 rounded-md myds-body-sm font-medium text-txt-primary"
              aria-label="Lihat Semua Permintaan Saya"
            >
              Lihat Semua Permintaan
              <svg
                class="ml-2 w-4 h-4"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                viewBox="0 0 20 20"
                aria-hidden="true"
              >
                <path
                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                  stroke="currentColor"
                  stroke-linecap="round"
                />
              </svg>
            </x-myds.button>
          </div>
        </section>
      @endauth

      {{-- Service Cards --}}
      <section aria-labelledby="services-heading">
        <div class="text-center mb-12">
          <h2
            id="services-heading"
            class="myds-heading-lg text-txt-black-900 mb-4"
          >
            Perkhidmatan Tersedia
          </h2>
          <p class="myds-body-lg text-txt-black-700">
            Akses semua perkhidmatan & sokongan ICT MOTAC dengan mudah dan
            inklusif
          </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {{-- Equipment Loan --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="equipment-loans-title"
          >
            <div
              class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="document" size="24" class="text-primary-600" aria-hidden="true" />
            </div>
            <h3
              id="equipment-loans-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Peminjaman Peralatan ICT
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Mohon pinjaman peralatan ICT seperti komputer riba, projektor dan
              lain-lain untuk urusan rasmi.
            </p>
            <a
              href="{{ route('equipment-loan.create') }}"
              class="text-txt-primary hover:underline font-medium"
              aria-label="Mohon Peminjaman Peralatan ICT"
            >
              Mohon Sekarang &rarr;
            </a>
          </div>
          {{-- Helpdesk --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="helpdesk-title"
          >
            <div
              class="w-12 h-12 bg-danger-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="alert-triangle" size="24" class="text-danger-600" aria-hidden="true" />
            </div>
            <h3
              id="helpdesk-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Aduan Kerosakan ICT
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Lapor kerosakan peralatan ICT, jejak status aduan, dan dapatkan
              bantuan teknikal BPM.
            </p>
            <a
              href="{{ route('helpdesk.create-ticket') }}"
              class="text-txt-danger hover:underline font-medium"
              aria-label="Buat Aduan Kerosakan"
            >
              Buat Aduan &rarr;
            </a>
          </div>
          {{-- My Tickets --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="my-tickets-title"
          >
            <div
              class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="check-circle" size="24" class="text-success-700" aria-hidden="true" />
            </div>
            <h3
              id="my-tickets-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Aduan Saya
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Semak dan pantau status semua aduan dan permohonan anda.
            </p>
            <a
              href="{{ route('helpdesk.my-tickets') }}"
              class="text-txt-success hover:underline font-medium"
              aria-label="Lihat Aduan Saya"
            >
              Lihat Aduan &rarr;
            </a>
          </div>
          {{-- All Requests --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="all-requests-title"
          >
            <div
              class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="document" size="24" class="text-primary-600" aria-hidden="true" />
            </div>
            <h3
              id="all-requests-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Semua Permintaan Saya
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Pantau semua pinjaman, aduan, dan permintaan ICT anda di satu
              tempat.
            </p>
            <a
              href="{{ route('public.my-requests') }}"
              class="text-txt-primary hover:underline font-medium"
              aria-label="Lihat Semua Permintaan Saya"
            >
              Lihat Semua &rarr;
            </a>
          </div>
          {{-- Admin Panel (only for admin) --}}
          @auth
            @if (auth()->user()->email === 'admin@motac.gov.my')
              <div
                class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
                role="article"
                aria-labelledby="admin-panel-title"
              >
                <div
                  class="w-12 h-12 bg-black-100 rounded-lg flex items-center justify-center mb-4"
                >
                  <x-myds.icon name="alert-triangle" size="24" class="text-black-700" aria-hidden="true" />
                </div>
                <h3
                  id="admin-panel-title"
                  class="myds-heading-xs text-txt-black-900 mb-2"
                >
                  Admin Panel
                </h3>
                <p class="myds-body-md text-txt-black-700 mb-4">
                  Urus peralatan, lulus permohonan, dan pantau operasi sistem
                  ICTServe.
                </p>
                <a
                  href="/admin"
                  class="text-txt-black-700 hover:underline font-medium"
                  aria-label="Akses Panel Admin"
                >
                  Akses Panel &rarr;
                </a>
              </div>
            @endif
          @endauth

          {{-- Knowledge Base --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="knowledge-base-title"
          >
            <div
              class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="alert-triangle" size="24" class="text-warning-700" aria-hidden="true" />
            </div>
            <h3
              id="knowledge-base-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Pusat Bantuan & Panduan
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Akses manual pengguna, polisi & soalan lazim berkaitan ICT MOTAC.
            </p>
            <span class="text-warning-700 font-medium">Akan Datang</span>
          </div>
          {{-- Contact --}}
          <div
            class="bg-white rounded-lg shadow-card border border-otl-gray-200 p-6 flex flex-col hover:shadow-md transition-shadow"
            role="article"
            aria-labelledby="contact-title"
          >
            <div
              class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4"
            >
              <x-myds.icon name="phone" size="24" class="text-primary-600" aria-hidden="true" />
            </div>
            <h3
              id="contact-title"
              class="myds-heading-xs text-txt-black-900 mb-2"
            >
              Hubungi Pasukan ICT
            </h3>
            <p class="myds-body-md text-txt-black-700 mb-4">
              Perlu bantuan segera? Hubungi Unit Operasi Rangkaian & Khidmat
              Pengguna BPM.
            </p>
            <span
              class="text-primary-600 font-medium"
              aria-label="Sambungan BPM"
            >
              samb. 1234
            </span>
          </div>
        </div>
      </section>

      {{-- Login CTA for guests --}}
      @guest
        <section class="bg-black-50 py-16 mt-16 rounded-lg max-w-lg mx-auto">
          <h2 class="myds-heading-md text-txt-black-900 mb-4 text-center">
            Akses Penuh ICTServe
          </h2>
          <p class="myds-body-md text-txt-black-700 mb-6 text-center">
            Sila log masuk dengan akaun MOTAC anda untuk akses penuh ke
            perkhidmatan ICT.
          </p>
            <div class="text-center">
              <x-myds.button
                href="{{ route('login') }}"
                variant="primary"
                class="px-6 py-3 rounded myds-body-sm font-medium"
                aria-label="Log masuk untuk akses ICTServe"
              >
                Log Masuk
                <x-myds.icon name="arrow-right" size="16" class="ml-2" aria-hidden="true" />
              </x-myds.button>
                <x-myds.icon name="arrow-right" size="16" class="ml-2" aria-hidden="true" />
                stroke-width="1.5"
