{{--
  File: resources/views/welcome.blade.php
  Purpose:
  - MYDS-compliant (Design, Develop, Icons, Colour)
  - MYGOVEA citizen-centric, accessible, and inclusive
  - For ICTServe (iServe) MOTAC intranet landing page
  - Responsive, high-contrast, keyboard-accessible, all ARIA and accessibility best practices
--}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ICTServe (iServe) – MOTAC ICT Service Desk</title>
    <!-- MYDS Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans bg-washed text-black min-h-screen flex flex-col">
    {{-- Skip link for accessibility --}}
    <x-myds.skip-link href="#main-content">Skip to main content</x-myds.skip-link>

    {{-- MYDS Navbar --}}
    <x-myds.navbar>
      <x-myds.navbar-logo src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="MOTAC" href="/" />
      <x-myds.navbar-menu>
        <x-myds.navbar-menu-item href="/">Utama</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="/informasi">Informasi</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="/muat-turun">Muat Turun</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="/direktori">Direktori</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="/servicedesk" active="true">ServiceDesk ICT</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="https://webmail.mygovuc.gov.my" target="_blank">Webmail MyGovUC 3.0</x-myds.navbar-menu-item>
        <x-myds.navbar-menu-item href="/my-integriti">MY Integriti</x-myds.navbar-menu-item>
      </x-myds.navbar-menu>
      <x-myds.navbar-action>
        <x-myds.button variant="ghost" size="sm" aria-label="Cari dalam laman (Search)">
          <x-myds.icon name="search" size="20" />
        </x-myds.button>
      </x-myds.navbar-action>
    </x-myds.navbar>

    {{-- Banner & Breadcrumb --}}
    <section class="w-full bg-gradient-to-r from-primary-100 via-white to-primary-50 shadow-inner" aria-label="Page intro">
      <x-myds.container class="py-8">
        <x-myds.heading level="1" size="lg" class="font-semibold text-txt-black-900 tracking-tight">
          Borang Aduan Kerosakan ICT
        </x-myds.heading>
        <x-myds.breadcrumb>
          <x-myds.breadcrumb-item>
            <x-myds.breadcrumb-link href="/">Utama</x-myds.breadcrumb-link>
          </x-myds.breadcrumb-item>
          <x-myds.breadcrumb-separator />
          <x-myds.breadcrumb-item>
            <x-myds.breadcrumb-page>ServiceDesk ICT</x-myds.breadcrumb-page>
          </x-myds.breadcrumb-item>
        </x-myds.breadcrumb>
      </x-myds.container>
    </section>

    {{-- Main Content --}}
    <main id="main-content" class="flex-1 bg-washed py-10 px-2">
      <x-myds.container>
        <x-myds.grid columns="12" gap="8">
          <x-myds.grid-item span="4" />
          <x-myds.grid-item span="4">
            <x-myds.card class="relative p-8">
              <span class="absolute top-6 right-8 myds-body-sm text-txt-black-500 uppercase tracking-wider select-none" aria-label="Form reference code">
                PK.(S).MOTAC.07.(L1)
              </span>
              <x-myds.heading level="2" size="md" class="font-medium text-txt-black-900 mb-6" id="page-title">
                Aduan Kerosakan ICT
              </x-myds.heading>
              <form action="{{ route('public.helpdesk.store') }}" method="POST" class="flex flex-col gap-5" autocomplete="on" novalidate aria-describedby="form-intro" role="form" aria-labelledby="page-title">
                @csrf
                <p id="form-intro" class="myds-body-sm text-txt-black-500 mb-4">
                  Sila isikan borang aduan di bawah. Medan bertanda
                  <span aria-hidden="true" class="text-danger-600">*</span>
                  adalah wajib diisi.
                </p>
                <x-myds.form-input id="full_name" label="Nama Penuh" type="text" :required="true" :value="old('full_name')" placeholder="Nama Penuh" autocomplete="name" />
                <x-myds.form-select id="division" label="Bahagian" :required="true" :value="old('division')" :options="[
                  ['value' => 'BPM', 'label' => 'Bahagian Pengurusan Maklumat (BPM)'],
                  ['value' => 'Kewangan', 'label' => 'Bahagian Kewangan'],
                  ['value' => 'Sumber Manusia', 'label' => 'Bahagian Sumber Manusia'],
                  ['value' => 'Teknologi Maklumat', 'label' => 'Bahagian Teknologi Maklumat'],
                  ['value' => 'Lain-lain', 'label' => 'Lain-lain']
                ]" placeholder="Sila Pilih" />
                <x-myds.form-input id="position_grade" label="Gred Jawatan" type="text" :value="old('position_grade')" placeholder="Gred Jawatan" autocomplete="organization-title" />
                <x-myds.form-input id="email" label="E-Mel" type="email" :required="true" :value="old('email')" placeholder="nama@motac.gov.my" autocomplete="email" />
                <x-myds.form-input id="phone" label="No. Telefon" type="tel" :required="true" :value="old('phone')" placeholder="Contoh: 012-3456789" autocomplete="tel" />
                <x-myds.form-select id="damage_type" label="Jenis Kerosakan" :required="true" :value="old('damage_type')" :options="[
                  ['value' => 'Komputer', 'label' => 'Komputer'],
                  ['value' => 'Pencetak', 'label' => 'Pencetak'],
                  ['value' => 'Rangkaian', 'label' => 'Rangkaian'],
                  ['value' => 'Perisian', 'label' => 'Perisian'],
                  ['value' => 'Lain-lain', 'label' => 'Lain-lain']
                ]" placeholder="Sila Pilih" />
                <x-myds.form-textarea id="damage_info" label="Maklumat Kerosakan" :required="true" :value="old('damage_info')" rows="4" placeholder="Maklumat Kerosakan" />
                <x-myds.checkbox id="declaration" name="declaration" value="1" :required="true" label="Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada." />
                <div class="mt-6 flex justify-end">
                  <x-myds.button type="submit" variant="primary" size="large" iconLeading="send" class="px-6 py-2">
                    Hantar Aduan
                  </x-myds.button>
                </div>
              </form>
            </x-myds.card>
          </x-myds.grid-item>
          <x-myds.grid-item span="4" />
        </x-myds.grid>
      </x-myds.container>
    </main>

    {{-- MYDS Footer --}}
    <x-myds.footer>
      <x-myds.footer-section>
        <x-myds.site-info>
          <x-myds.footer-logo src="{{ asset('images/bpm-logo-50.png') }}" alt="Bahagian Pengurusan Maklumat" />
          <span>Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.</span>
        </x-myds.site-info>
        <x-myds.site-link-group groupTitle="Follow us">
          <x-myds.site-link href="https://www.facebook.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <x-myds.icon name="facebook" size="20" />
          </x-myds.site-link>
          <x-myds.site-link href="https://twitter.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
            <x-myds.icon name="twitter" size="20" />
          </x-myds.site-link>
          <x-myds.site-link href="https://instagram.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <x-myds.icon name="instagram" size="20" />
          </x-myds.site-link>
          <x-myds.site-link href="https://youtube.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
            <x-myds.icon name="youtube" size="20" />
          </x-myds.site-link>
        </x-myds.site-link-group>
        <span class="text-txt-black-500 text-sm text-center block mt-4">© 2025 Hakcipta Terpelihara Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.</span>
      </x-myds.footer-section>
    </x-myds.footer>
  </body>
</html>
