<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ICTServe (iServe) – Sistem Pengurusan Perkhidmatan ICT MOTAC, mematuhi MYDS & MyGovEA">

    <title>{{ $title ?? config('app.name', 'ICTServe (iServe)') }}</title>

    <!-- MYDS Fonts: Inter for body, Poppins for headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased font-sans bg-bg-washed text-txt-black-900 min-h-screen flex flex-col">

    <!-- MYDS Skip Link for Accessibility -->
    <a href="#main-content"
       class="myds-skip-link myds-focus-visible">
        Langkau ke kandungan utama
    </a>

    <!-- MYDS Guest Masthead -->
    <header class="w-full bg-bg-white-0 border-b border-otl-divider shadow-sm">
        <div class="myds-container flex items-center py-6">
            <a href="{{ url('/') }}" aria-label="Halaman utama ICTServe (iServe)">
                <img src="{{ asset('images/jata-negara.png') }}"
                     alt="Jata Negara Malaysia"
                     class="h-10 w-auto mr-4" />
            </a>
            <div>
                <h1 class="myds-heading text-heading-2xs font-semibold text-primary-600 tracking-tight">
                    ICTServe (iServe)
                </h1>
                <p class="text-body-xs text-txt-black-500">
                    Sistem Pengurusan Perkhidmatan ICT MOTAC
                </p>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content"
          class="flex-1 flex flex-col items-center justify-center myds-container py-12">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center mb-6">
                <a href="{{ url('/') }}" aria-label="Halaman utama ICTServe (iServe)">
                    <x-application-logo class="w-20 h-20 fill-current text-primary-600" />
                </a>
            </div>

            <div class="bg-bg-white-0 shadow-card rounded-lg px-8 py-6 border border-otl-divider">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- MYDS Footer -->
    <footer class="bg-bg-white-0 border-t border-otl-divider mt-auto w-full">
        <div class="myds-container py-6 flex flex-col items-center text-center gap-2">
            <div class="flex items-center justify-center gap-3 mb-2">
                <img src="{{ asset('images/jata-negara.png') }}" alt="Jata Negara Malaysia" class="h-8 w-auto" />
                <span class="myds-heading text-heading-4xs font-medium text-txt-black-900">
                    ICTServe (iServe)
                </span>
            </div>
            <p class="text-body-xs text-txt-black-500">
                © {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.<br>
                Mengikuti Malaysia Government Design System (MYDS) &amp; Prinsip MyGovEA.
            </p>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
