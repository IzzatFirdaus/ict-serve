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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ICTServe (iServe) – MOTAC ICT Service Desk</title>

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- MYDS Styles & App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-washed text-black min-h-screen flex flex-col">

    {{-- Skip link for accessibility --}}
    <a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900">
        Skip to main content
    </a>

    {{-- Header: MYDS Masthead --}}
    <header class="w-full shadow-card bg-white" role="banner">
        <nav class="max-w-[1280px] mx-auto flex items-center justify-between px-6 py-3" aria-label="Primary navigation">
            {{-- Logo & Branding --}}
            <div class="flex items-center gap-3">
                {{-- Replace with actual MOTAC SVG if available --}}
                <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="MOTAC" class="h-10 w-auto" onerror="this.onerror=null;this.src='https://placehold.co/120x40?text=MOTAC';" />
                <span class="myds-heading-sm font-semibold text-primary-600 tracking-wide" aria-label="ICTServe (iServe)">ICTServe <span class="sr-only">(iServe)</span></span>
            </div>
            {{-- Navigation links --}}
            <ul class="hidden md:flex gap-6 text-base" aria-label="Main menu">
                <li><a href="/" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">Utama</a></li>
                <li><a href="/informasi" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">Informasi</a></li>
                <li><a href="/muat-turun" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">Muat Turun</a></li>
                <li><a href="/direktori" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">Direktori</a></li>
                <li><a href="/servicedesk" class="font-semibold text-primary-600 underline underline-offset-8 pointer-events-none cursor-default" aria-current="page">ServiceDesk ICT</a></li>
                <li><a href="https://webmail.mygovuc.gov.my" target="_blank" rel="noopener" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">Webmail MyGovUC 3.0</a></li>
                <li><a href="/my-integriti" class="focus-visible:outline-primary-600 hover:underline underline-offset-4 transition text-txt-black-700">MY Integriti</a></li>
            </ul>
            {{-- Search Icon (Accessible Button) --}}
            <button type="button" class="ml-4 p-2 rounded-full bg-washed hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-primary-600"
                aria-label="Cari dalam laman (Search)">
                {{-- MYDS: Use SVG for search icon (20x20, 1.5px stroke) --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" aria-hidden="true" class="text-primary-600">
                    <circle cx="9" cy="9" r="6" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M15.5 15.5L13 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
        </nav>
    </header>

    {{-- Banner --}}
    <section class="relative w-full bg-gradient-to-r from-primary-100 via-white to-primary-50 shadow-inner" aria-label="Page intro">
        <div class="max-w-[1280px] mx-auto px-6 py-8 flex flex-col gap-2 md:gap-4">
            {{-- Decorative graphic (background illustration) --}}
            <div aria-hidden="true" class="absolute inset-0 z-0 pointer-events-none opacity-20">
                {{-- Example: telephone receiver SVG, stylized for support/helpdesk --}}
                <svg width="300" height="100" class="absolute right-8 top-6 hidden md:block" viewBox="0 0 300 100" fill="none">
                    <ellipse cx="190" cy="60" rx="90" ry="30" fill="#2563EB" fill-opacity="0.05"/>
                    <path d="M225 80 Q220 50 260 40 Q280 35 270 80" stroke="#2563EB" stroke-width="8" stroke-linecap="round" fill="none"/>
                </svg>
            </div>
            <div class="relative z-10">
                <h1 class="myds-heading-lg font-semibold text-txt-black-900 tracking-tight">Borang Aduan Kerosakan ICT</h1>
                <nav class="mt-2 flex flex-wrap items-center text-sm text-txt-black-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center gap-1" role="list">
                        <li>
                            <a href="/" class="hover:underline text-primary-600 focus-visible:outline-primary-600">Utama</a>
                        </li>
                        <li aria-hidden="true" class="mx-2 text-gray-400">/</li>
                        <li class="text-txt-black-500" aria-current="page">ServiceDesk ICT</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <main id="main-content" class="flex-1 flex justify-center items-start bg-washed py-10 px-2">
        <div class="w-full max-w-xl bg-white rounded-lg shadow-card border border-otl-gray-200 p-8 relative" aria-labelledby="page-title">
            {{-- Document reference code --}}
            <span class="absolute top-6 right-8 myds-body-sm text-txt-black-500 uppercase tracking-wider select-none" aria-label="Form reference code">
                PK.(S).MOTAC.07.(L1)
            </span>
            {{-- Form title --}}
            <h2 id="page-title" class="myds-heading-md font-medium text-txt-black-900 mb-6">Aduan Kerosakan ICT</h2>
            {{-- ICT Damage Complaint Form (MYDS form controls) --}}
            <form action="{{ route('ict-complaint.submit') }}" method="POST" class="flex flex-col gap-5" autocomplete="on" novalidate aria-describedby="form-intro">
                @csrf
                <p id="form-intro" class="myds-body-sm text-txt-black-500 mb-4">
                    Sila isikan borang aduan di bawah. Medan bertanda <span aria-hidden="true" class="text-danger-600">*</span> adalah wajib diisi.
                </p>

                {{-- Nama Penuh --}}
                <div>
                    <label for="full_name" class="mb-1 myds-body-md font-medium text-txt-black-900 block">Nama Penuh <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <input id="full_name" name="full_name" type="text" required maxlength="100"
                        class="myds-input w-full"
                        placeholder="Nama Penuh"
                        aria-required="true"
                        autocomplete="name"
                        />
                </div>

                {{-- Bahagian --}}
                <div>
                    <label for="division" class="mb-1 myds-body-md font-medium text-txt-black-900 block">Bahagian <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <select id="division" name="division" required class="myds-select w-full" aria-required="true">
                        <option value="" disabled selected hidden>Sila Pilih</option>
                        {{-- Populate dynamically in production --}}
                        <option value="BPM">Bahagian Pengurusan Maklumat (BPM)</option>
                        <option value="Kewangan">Bahagian Kewangan</option>
                        <option value="Sumber Manusia">Bahagian Sumber Manusia</option>
                        <option value="Teknologi Maklumat">Bahagian Teknologi Maklumat</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>

                {{-- Gred Jawatan (optional) --}}
                <div>
                    <label for="position_grade" class="mb-1 myds-body-md font-medium text-txt-black-900 block">Gred Jawatan</label>
                    <input id="position_grade" name="position_grade" type="text" maxlength="20"
                        class="myds-input w-full"
                        placeholder="Gred Jawatan"
                        autocomplete="organization-title"
                        />
                </div>

                {{-- E-Mel --}}
                <div>
                    <label for="email" class="mb-1 myds-body-md font-medium text-txt-black-900 block">E-Mel <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <input id="email" name="email" type="email" required maxlength="100"
                        class="myds-input w-full"
                        placeholder="nama@motac.gov.my"
                        aria-required="true"
                        autocomplete="email"
                        />
                </div>

                {{-- No. Telefon --}}
                <div>
                    <label for="phone" class="mb-1 myds-body-md font-medium text-txt-black-900 block">No. Telefon <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <input id="phone" name="phone" type="tel" required maxlength="25"
                        class="myds-input w-full"
                        placeholder="Contoh: 012-3456789"
                        aria-required="true"
                        autocomplete="tel"
                        />
                </div>

                {{-- Jenis Kerosakan --}}
                <div>
                    <label for="damage_type" class="mb-1 myds-body-md font-medium text-txt-black-900 block">Jenis Kerosakan <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <select id="damage_type" name="damage_type" required class="myds-select w-full" aria-required="true">
                        <option value="" disabled selected hidden>Sila Pilih</option>
                        <option value="Komputer">Komputer</option>
                        <option value="Pencetak">Pencetak</option>
                        <option value="Rangkaian">Rangkaian</option>
                        <option value="Perisian">Perisian</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>

                {{-- Maklumat Kerosakan --}}
                <div>
                    <label for="damage_info" class="mb-1 myds-body-md font-medium text-txt-black-900 block">Maklumat Kerosakan <span aria-hidden="true" class="text-danger-600">*</span></label>
                    <textarea id="damage_info" name="damage_info" required maxlength="1000" rows="4"
                        class="myds-textarea w-full resize-y"
                        placeholder="Maklumat Kerosakan"
                        aria-required="true"
                        ></textarea>
                </div>

                {{-- Perakuan (Declaration) --}}
                <div>
                    <div class="flex items-start gap-3">
                        <input id="declaration" name="declaration" type="checkbox" required class="myds-checkbox mt-1" aria-required="true" />
                        <label for="declaration" class="myds-body-sm text-txt-black-900">
                            Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada. <span aria-hidden="true" class="text-danger-600">*</span>
                        </label>
                    </div>
                </div>

                {{-- Submit button --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="myds-btn myds-btn-primary px-6 py-2 rounded shadow-button font-semibold text-white bg-primary-600 hover:bg-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600 transition"
                        aria-label="Hantar aduan (Submit complaint)">
                        <span class="inline-flex items-center gap-2">
                            {{-- MYDS send icon, 20x20, 1.5px stroke --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" aria-hidden="true">
                                <path d="M2 10L18 3L11 18L9 11L2 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Hantar Aduan
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Footer: MYDS Footer, BPM branding, accessible social links --}}
    <footer class="w-full bg-white border-t border-otl-gray-200 shadow-inner mt-auto">
        <div class="max-w-[1280px] mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            {{-- BPM logo (left) --}}
            <div class="flex items-center gap-2">
                {{-- Replace with actual BPM SVG if available --}}
                <img src="{{ asset('images/bpm-logo-50.png') }}" alt="Bahagian Pengurusan Maklumat" class="h-8 w-auto" />
            </div>
            {{-- Copyright --}}
            <div class="text-txt-black-500 text-sm text-center">
                © 2025 Hakcipta Terpelihara Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.
            </div>
            {{-- Social icons (right, MYDS style, accessible) --}}
            <div class="flex items-center gap-3">
                <a href="https://www.facebook.com/motacmalaysia" aria-label="Facebook" target="_blank" rel="noopener" class="p-2 rounded-full hover:bg-primary-50 focus-visible:outline-primary-600 transition">
                    {{-- MYDS Facebook icon (20x20, 1.5px stroke) --}}
                    <svg width="20" height="20" fill="none" aria-hidden="true" class="text-primary-600"><path d="M13.5 2.5h-2A3.5 3.5 0 0 0 8 6v2H6v3h2v6h3v-6h2l1-3h-3V6a1 1 0 0 1 1-1h2V2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="https://twitter.com/motacmalaysia" aria-label="Twitter (X)" target="_blank" rel="noopener" class="p-2 rounded-full hover:bg-primary-50 focus-visible:outline-primary-600 transition">
                    {{-- MYDS Twitter/X icon (20x20, 1.5px stroke) --}}
                    <svg width="20" height="20" fill="none" aria-hidden="true" class="text-primary-600"><path d="M15.95 5.5H13.5l-3.5 4.25-1.2-1.25-3.25 4.5h2.45l3.5-4.25 1.2 1.25 3.25-4.5ZM4.5 15.5h11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="https://instagram.com/motacmalaysia" aria-label="Instagram" target="_blank" rel="noopener" class="p-2 rounded-full hover:bg-primary-50 focus-visible:outline-primary-600 transition">
                    {{-- MYDS Instagram icon (20x20, 1.5px stroke) --}}
                    <svg width="20" height="20" fill="none" aria-hidden="true" class="text-primary-600"><rect x="3" y="3" width="14" height="14" rx="4" stroke="currentColor" stroke-width="1.5"/><circle cx="10" cy="10" r="3" stroke="currentColor" stroke-width="1.5"/><circle cx="15.5" cy="4.5" r="1" fill="currentColor"/></svg>
                </a>
                <a href="https://youtube.com/motacmalaysia" aria-label="YouTube" target="_blank" rel="noopener" class="p-2 rounded-full hover:bg-primary-50 focus-visible:outline-primary-600 transition">
                    {{-- MYDS YouTube icon (20x20, 1.5px stroke) --}}
                    <svg width="20" height="20" fill="none" aria-hidden="true" class="text-primary-600"><rect x="2" y="5" width="16" height="10" rx="3" stroke="currentColor" stroke-width="1.5"/><path d="M9 8.5v3l2.5-1.5L9 8.5Z" fill="currentColor"/></svg>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
