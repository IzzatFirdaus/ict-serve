<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ICTServe (iServe)') }} - Sistem Perkhidmatan ICT MOTAC</title>

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Meta tags for SEO and social sharing -->
    <meta name="description" content="Sistem Perkhidmatan ICT MOTAC - Platform bersepadu untuk peminjaman peralatan ICT dan pengurusan helpdesk">
    <meta name="keywords" content="MOTAC, ICT, peminjaman, helpdesk, peralatan, teknologi">
    <meta name="author" content="MOTAC ICT Department">

    <!-- Open Graph tags -->
    <meta property="og:title" content="ICTServe (iServe) - MOTAC">
    <meta property="og:description" content="Sistem Perkhidmatan ICT MOTAC yang mengikuti garis panduan MyGOVEA">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ms_MY">

    <!-- PWA support -->
    <meta name="theme-color" content="#2563EB">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/css/components/dropdown.css', 'resources/css/components/toast.css', 'resources/css/components/notifications.css', 'resources/js/app.js'])

</t>    @livewireStyles

    <!-- MYDS Skip Link Component Styles (hidden by default, visible on focus) -->
    @vite(['resources/css/app/skip-link.css', 'resources/css/app/noscript.css', 'resources/css/components/dropdown.css', 'resources/css/components/toast.css', 'resources/css/components/notifications.css'])
</head>
<body class="antialiased font-sans bg-washed text-black-900 min-h-screen flex flex-col">
    {{-- MYDS Skip Link: Appears on keyboard tab, points to #main-content --}}
    <a href="#main-content" class="myds-skip-link">Skip to main content</a>

    {{-- The main layout slot, which should include the header/nav, main, and footer --}}
    <div id="app-root" class="flex flex-col min-h-screen">
        {{-- Responsive header/navigation is expected in all child layouts --}}
        @yield('masthead')
        @yield('navigation')

        {{-- Main content area --}}
        <main id="main-content" tabindex="-1" class="flex-1 outline-none focus-visible:ring-2 focus-visible:ring-primary-300">
            @yield('content')
        </main>

        {{-- Footer --}}
        @yield('footer')
    </div>

    {{-- Fallback for users with JavaScript disabled --}}
    <noscript>
        <div class="myds-noscript-container">
            <h1 class="myds-noscript-title">ICTServe (iServe)</h1>
            <p class="myds-noscript-subtitle">Sistem Perkhidmatan ICT MOTAC</p>
            <p class="myds-noscript-strong">
                <strong>JavaScript diperlukan untuk menggunakan aplikasi ini.</strong>
            </p>
            <p>Sila aktifkan JavaScript dalam pelayar web anda untuk menggunakan sistem ini.</p>
            <p class="myds-noscript-contact">
                <a href="mailto:ict@motac.gov.my">Hubungi Jabatan ICT</a>
                jika anda memerlukan bantuan.
            </p>
        </div>
    </noscript>

    {{-- MYDS Loading Indicator (Spinner) --}}
    <div id="loading-indicator" class="fixed inset-0 flex items-center justify-center bg-black/10 z-[9999]" hidden>
        <div class="rounded-full bg-white p-4 shadow-card">
            <!-- MYDS Spinner SVG  -->
            <svg class="animate-spin w-10 h-10 text-primary-600" fill="none" viewBox="0 0 40 40" aria-hidden="true">
                <circle class="opacity-20" cx="20" cy="20" r="16" stroke="currentColor" stroke-width="4"/>
                <path d="M36 20a16 16 0 0 0-16-16" stroke="#2563EB" stroke-width="4" stroke-linecap="round"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    {{-- JavaScript moved to resources/js/app.js and will be loaded via @vite (loading indicator + focus-visible polyfill) --}}

    @livewireScripts
</body>
</html>
