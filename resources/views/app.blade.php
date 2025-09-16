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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- MYDS Skip Link Component Styles (hidden by default, visible on focus) -->
    <style>
        .myds-skip-link {
            position: absolute;
            left: 24px;
            top: -40px;
            background: #2563EB;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            z-index: 10001;
            font-family: "Inter", Arial, sans-serif;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 12px 50px 0px rgba(0,0,0,0.10);
            outline: none;
            transition: top 0.2s cubic-bezier(0.4, 1.4, 0.2, 1);
        }
        .myds-skip-link:focus {
            top: 12px;
        }
        @media (max-width: 767px) {
            .myds-skip-link {
                left: 12px;
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
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
        <div style="text-align: center; padding: 48px 16px; font-family: Inter, Arial, sans-serif; background: #FEE2E2;">
            <h1 style="color: #2563EB; font-family: Poppins, Arial, sans-serif; font-size: 2rem; margin-bottom: 8px;">ICTServe (iServe)</h1>
            <p style="font-size: 1.125rem; color: #18181B; margin-bottom: 20px;">Sistem Perkhidmatan ICT MOTAC</p>
            <p style="color: #DC2626; margin-bottom: 20px;">
                <strong>JavaScript diperlukan untuk menggunakan aplikasi ini.</strong>
            </p>
            <p>Sila aktifkan JavaScript dalam pelayar web anda untuk menggunakan sistem ini.</p>
            <p style="margin-top: 20px;">
                <a href="mailto:ict@motac.gov.my" style="color: #2563EB; text-decoration: underline;">Hubungi Jabatan ICT</a>
                jika anda memerlukan bantuan.
            </p>
        </div>
    </noscript>

    {{-- MYDS Loading Indicator (Spinner) --}}
    <div id="loading-indicator" class="fixed inset-0 flex items-center justify-center bg-black/10 z-[9999]" style="display:none;">
        <div class="rounded-full bg-white p-4 shadow-card">
            <!-- MYDS Spinner SVG  -->
            <svg class="animate-spin w-10 h-10 text-primary-600" fill="none" viewBox="0 0 40 40" aria-hidden="true">
                <circle class="opacity-20" cx="20" cy="20" r="16" stroke="currentColor" stroke-width="4"/>
                <path d="M36 20a16 16 0 0 0-16-16" stroke="#2563EB" stroke-width="4" stroke-linecap="round"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <script>
        // Show loading indicator initially (for SPA/Livewire/JS hydration)
        document.addEventListener('DOMContentLoaded', function() {
            const loading = document.getElementById('loading-indicator');
            if(loading) loading.style.display = 'flex';
        });
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loading = document.getElementById('loading-indicator');
                if(loading) loading.style.display = 'none';
            }, 800); // Slight delay for perceived performance
        });
    </script>

    @livewireScripts

    {{-- Accessibility: focus visible polyfill for better keyboard navigation --}}
    <script>
        // Polyfill for :focus-visible if needed
        (function() {
            var style = document.createElement('style');
            style.innerHTML = `.js-focus-visible :focus:not([data-focus-visible-added]) { outline: none !important; }`;
            document.head.appendChild(style);
        })();
    </script>
</body>
</html>
