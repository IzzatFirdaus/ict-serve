{{--
  File: resources/views/welcome.blade.php
  Purpose:
  - For ICTServe (iServe) MOTAC intranet landing page
  - Responsive, high-contrast, keyboard-accessible, all ARIA and accessibility best practices
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ICTServe (iServe) – MOTAC ICT Service Desk</title>
  <!-- Fonts and Styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Inter:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans bg-washed text-black min-h-screen flex flex-col">
    {{-- Skip link for accessibility --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-lg focus:rounded focus:p-4 focus:z-50 text-black">
      Skip to main content
    </a>

    {{-- Navbar --}}
    <nav class="flex items-center justify-between px-6 py-4 bg-white shadow">
      <a href="/" class="flex items-center gap-2">
        <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="MOTAC" class="h-10 w-auto" />
        <span class="font-bold text-lg">ICTServe</span>
      </a>
      <ul class="flex gap-4">
        <li><a href="/" class="hover:underline">Utama</a></li>
        <li><a href="/informasi" class="hover:underline">Informasi</a></li>
        <li><a href="/muat-turun" class="hover:underline">Muat Turun</a></li>
        <li><a href="/direktori" class="hover:underline">Direktori</a></li>
        <li><a href="/servicedesk" class="hover:underline font-semibold">ServiceDesk ICT</a></li>
        <li><a href="https://webmail.mygovuc.gov.my" target="_blank" class="hover:underline">Webmail MyGovUC 3.0</a></li>
        <li><a href="/my-integriti" class="hover:underline">MY Integriti</a></li>
      </ul>
      <form class="ml-4">
        <input type="search" placeholder="Cari..." aria-label="Cari dalam laman (Search)" class="border rounded px-2 py-1" />
      </form>
    </nav>

    {{-- Banner & Breadcrumb --}}
    <section class="w-full bg-gradient-to-r from-blue-100 via-white to-blue-50 shadow-inner" aria-label="Page intro">
      <div class="container mx-auto py-8">
        <h1 class="font-semibold text-2xl md:text-3xl text-black tracking-tight mb-2">Borang Aduan Kerosakan ICT</h1>
        <nav class="text-sm text-gray-600" aria-label="breadcrumb">
          <ol class="list-reset flex gap-2">
            <li><a href="/" class="hover:underline">Utama</a></li>
            <li>/</li>
            <li>ServiceDesk ICT</li>
          </ol>
        </nav>
      </div>
    </section>

    {{-- Main Content --}}
    <main id="main-content" class="flex-1 bg-gray-50 py-10 px-2">
      <div class="container mx-auto max-w-xl bg-white rounded shadow p-8 relative">
        <span class="absolute top-6 right-8 text-xs text-gray-500 uppercase tracking-wider select-none" aria-label="Form reference code">
          PK.(S).MOTAC.07.(L1)
        </span>
        <h2 class="font-medium text-xl text-black mb-6" id="page-title">Aduan Kerosakan ICT</h2>
        <form action="{{ route('public.helpdesk.store') }}" method="POST" class="flex flex-col gap-5" autocomplete="on" novalidate aria-describedby="form-intro" role="form" aria-labelledby="page-title">
          @csrf
          <p id="form-intro" class="text-sm text-gray-600 mb-4">
            Sila isikan borang aduan di bawah. Medan bertanda
            <span aria-hidden="true" class="text-red-600">*</span>
            adalah wajib diisi.
          </p>
          <label for="full_name" class="block font-medium">Nama Penuh <span class="text-red-600">*</span></label>
          <input id="full_name" name="full_name" type="text" required value="{{ old('full_name') }}" placeholder="Nama Penuh" autocomplete="name" class="border rounded px-3 py-2 mb-2" />
          <label for="division" class="block font-medium">Bahagian <span class="text-red-600">*</span></label>
          <select id="division" name="division" required class="border rounded px-3 py-2 mb-2">
            <option value="">Sila Pilih</option>
            <option value="BPM">Bahagian Pengurusan Maklumat (BPM)</option>
            <option value="Kewangan">Bahagian Kewangan</option>
            <option value="Sumber Manusia">Bahagian Sumber Manusia</option>
            <option value="Teknologi Maklumat">Bahagian Teknologi Maklumat</option>
            <option value="Lain-lain">Lain-lain</option>
          </select>
          <label for="position_grade" class="block font-medium">Gred Jawatan</label>
          <input id="position_grade" name="position_grade" type="text" value="{{ old('position_grade') }}" placeholder="Gred Jawatan" autocomplete="organization-title" class="border rounded px-3 py-2 mb-2" />
          <label for="email" class="block font-medium">E-Mel <span class="text-red-600">*</span></label>
          <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="nama@motac.gov.my" autocomplete="email" class="border rounded px-3 py-2 mb-2" />
          <label for="phone" class="block font-medium">No. Telefon <span class="text-red-600">*</span></label>
          <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}" placeholder="Contoh: 012-3456789" autocomplete="tel" class="border rounded px-3 py-2 mb-2" />
          <label for="damage_type" class="block font-medium">Jenis Kerosakan <span class="text-red-600">*</span></label>
          <select id="damage_type" name="damage_type" required class="border rounded px-3 py-2 mb-2">
            <option value="">Sila Pilih</option>
            <option value="Komputer">Komputer</option>
            <option value="Pencetak">Pencetak</option>
            <option value="Rangkaian">Rangkaian</option>
            <option value="Perisian">Perisian</option>
            <option value="Lain-lain">Lain-lain</option>
          </select>
          <label for="damage_info" class="block font-medium">Maklumat Kerosakan <span class="text-red-600">*</span></label>
          <textarea id="damage_info" name="damage_info" required rows="4" placeholder="Maklumat Kerosakan" class="border rounded px-3 py-2 mb-2">{{ old('damage_info') }}</textarea>
          <div class="flex items-center mb-2">
            <input id="declaration" name="declaration" type="checkbox" value="1" required class="mr-2" />
            <label for="declaration" class="text-sm">Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada.</label>
          </div>
          <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Hantar Aduan</button>
          </div>
        </form>
      </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t py-6 mt-8">
      <div class="container mx-auto flex flex-col items-center">
        <img src="{{ asset('images/bpm-logo-50.png') }}" alt="Bahagian Pengurusan Maklumat" class="h-10 mb-2" />
        <span class="block text-center text-gray-700 text-sm mb-2">
          Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.
        </span>
        <div class="flex gap-4 mb-2">
          <a href="https://www.facebook.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"/></svg>
          </a>
          <a href="https://twitter.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557a9.83 9.83 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724c-.951.564-2.005.974-3.127 1.195a4.916 4.916 0 0 0-8.38 4.482C7.691 8.095 4.066 6.13 1.64 3.161c-.542.929-.856 2.01-.857 3.17 0 2.188 1.115 4.117 2.823 5.254a4.904 4.904 0 0 1-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 0 1-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 0 1 0 21.543a13.94 13.94 0 0 0 7.548 2.209c9.142 0 14.307-7.721 13.995-14.646A9.936 9.936 0 0 0 24 4.557z"/></svg>
          </a>
          <a href="https://instagram.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.974-.974 2.241-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.414 3.678 1.395c-.98.98-1.263 2.092-1.322 3.373C2.013 8.332 2 8.741 2 12c0 3.259.013 3.668.072 4.948.059 1.281.342 2.393 1.322 3.373.98.98 2.092 1.263 3.373 1.322C8.332 23.987 8.741 24 12 24s3.668-.013 4.948-.072c1.281-.059 2.393-.342 3.373-1.322.98-.98 1.263-2.092 1.322-3.373.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.668-.072-4.948-.059-1.281-.342-2.393-1.322-3.373-.98-.98-2.092-1.263-3.373-1.322C15.668.013 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
          </a>
          <a href="https://youtube.com/motacmalaysia" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
            <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a2.994 2.994 0 0 0-2.112-2.112C19.645 3.5 12 3.5 12 3.5s-7.645 0-9.386.574A2.994 2.994 0 0 0 .502 6.186C0 7.927 0 12 0 12s0 4.073.502 5.814a2.994 2.994 0 0 0 2.112 2.112C4.355 20.5 12 20.5 12 20.5s7.645 0 9.386-.574a2.994 2.994 0 0 0 2.112-2.112C24 16.073 24 12 24 12s0-4.073-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
        </div>
        <span class="text-gray-500 text-sm text-center block mt-4">
          © 2025 Hakcipta Terpelihara Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.
        </span>
      </div>
    </footer>
  </body>
</html>
