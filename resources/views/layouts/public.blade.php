<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'ICTServe (iServe) — Public services for ICT loans and helpdesk (MOTAC) — built to MYDS & MyGovEA standards' }}">
    <meta name="theme-color" content="#FFFFFF" id="theme-color">

    <title>@yield('title', 'ICTServe - Public Services')</title>

    <!-- MYDS Typography: Inter (body) + Poppins (headings) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

    <!-- Vite / compiled assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    <!-- Prevent FOUC (apply dark preference quickly) -->
    <script>
        (function(){
            try {
                const theme = localStorage.getItem('theme') || 'system';
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = theme === 'dark' || (theme === 'system' && prefersDark);
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    document.getElementById('theme-color')?.setAttribute('content', '#18181B');
                }
            } catch (e) { /* fail silently */ }
        })();
    </script>
</head>
<body class="min-h-screen bg-bg-washed text-txt-black-900 font-inter antialiased">

    <!-- Skip link (MYDS) -->
    <a href="#main-content" class="myds-skip-link myds-focus-visible">Langkau ke kandungan utama / Skip to main content</a>

    <!-- Phase banner (optional) -->
    @if(isset($phaseBanner))
        <div class="bg-primary-50 border-b border-otl-divider">
            <div class="myds-container py-2 flex items-center gap-3">
                <span class="inline-flex items-center rounded-md bg-primary-100 text-primary-600 px-3 py-1 text-body-sm font-medium">
                    {{ $phaseBanner['phase'] ?? 'BETA' }}
                </span>
                <p class="text-body-sm text-txt-black-700">
                    {{ $phaseBanner['description'] ?? 'This is a new service — your feedback will help us improve it.' }}
                </p>

                @if(!empty($phaseBanner['feedbackUrl']))
                    <a href="{{ $phaseBanner['feedbackUrl'] }}" class="ml-auto text-body-sm text-primary-600 hover:text-primary-700 underline">
                        {{ $phaseBanner['feedbackText'] ?? 'Give feedback' }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Header / Masthead -->
    <header class="bg-bg-white-0 border-b border-otl-divider" role="banner">
        <div class="myds-container flex items-center justify-between py-4">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="ICTServe - Halaman Utama">
                    <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-10 w-auto">
                    <div class="hidden sm:block">
                        <h1 class="text-heading-3xs font-semibold text-txt-black-900">ICTServe (iServe)</h1>
                        <p class="text-body-xs text-txt-black-500">Public services — Equipment loan & Helpdesk (MOTAC)</p>
                    </div>
                </a>
            </div>

            <!-- Desktop nav -->
            <nav class="hidden md:flex items-center gap-6" aria-label="Primary navigation">
                <a href="{{ url('/') }}" class="text-body-sm {{ request()->is('/') ? 'text-primary-600 font-medium' : 'text-txt-black-700 hover:text-primary-600' }}">
                    {{ __('Home') }}
                </a>
                <a href="{{ route('public.loan-requests.create') }}" class="text-body-sm {{ request()->routeIs('public.loan-requests.*') ? 'text-primary-600 font-medium' : 'text-txt-black-700 hover:text-primary-600' }}">
                    {{ __('Equipment Loan') }}
                </a>
                <a href="{{ route('public.helpdesk.create') }}" class="text-body-sm {{ request()->routeIs('public.helpdesk.*') ? 'text-primary-600 font-medium' : 'text-txt-black-700 hover:text-primary-600' }}">
                    {{ __('Report Issue') }}
                </a>
                <a href="{{ route('public.track') }}" class="text-body-sm {{ request()->routeIs('public.track*') ? 'text-primary-600 font-medium' : 'text-txt-black-700 hover:text-primary-600' }}">
                    {{ __('Track Status') }}
                </a>
            </nav>

            <div class="flex items-center gap-3">
                <!-- Language switcher (form for accessibility) -->
                <form method="POST" action="{{ route('language.switch') }}" class="inline-flex items-center" aria-label="Language switcher">
                    @csrf
                    <label for="locale" class="sr-only">Pilih bahasa</label>
                    <select id="locale" name="locale" onchange="this.form.submit()" class="text-body-sm border otl-gray-300 rounded px-2 py-1 bg-bg-white-0 focus:outline-none focus:ring-2 focus:ring-fr-primary">
                        <option value="ms" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>BM</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    </select>
                </form>

                <!-- Call to action buttons -->
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('public.helpdesk.create') }}" class="inline-flex items-center px-3 py-2 rounded-md text-body-sm font-medium bg-primary-50 text-primary-700 hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-fr-primary">
                        {{ __('Report Issue') }}
                    </a>
                    <a href="{{ route('public.loan-requests.create') }}" class="inline-flex items-center px-3 py-2 rounded-md text-body-sm font-medium bg-primary-600 text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-fr-primary">
                        {{ __('Apply for Loan') }}
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false" class="md:hidden p-2 rounded-md text-txt-black-500 hover:bg-bg-washed focus:outline-none focus:ring-2 focus:ring-fr-primary" aria-label="Open main menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu (hidden by default) -->
        <div id="mobile-menu" class="md:hidden hidden" aria-hidden="true">
            <div class="px-4 pt-2 pb-3 space-y-1 border-t border-otl-divider bg-bg-white-0">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'text-primary-600 bg-primary-50' : 'text-txt-black-700 hover:bg-bg-washed' }}">Home</a>
                <a href="{{ route('public.loan-requests.create') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.loan-requests.*') ? 'text-primary-600 bg-primary-50' : 'text-txt-black-700 hover:bg-bg-washed' }}">Equipment Loan</a>
                <a href="{{ route('public.helpdesk.create') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.helpdesk.*') ? 'text-primary-600 bg-primary-50' : 'text-txt-black-700 hover:bg-bg-washed' }}">Report Issue</a>
                <a href="{{ route('public.track') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('public.track*') ? 'text-primary-600 bg-primary-50' : 'text-txt-black-700 hover:bg-bg-washed' }}">Track Status</a>

                <div class="pt-4 pb-2 border-t border-otl-divider">
                    <a href="{{ route('public.helpdesk.create') }}" class="block w-full text-center px-3 py-2 rounded-md text-body-sm font-medium bg-primary-50 text-primary-700 hover:bg-primary-100">Report Issue</a>
                    <a href="{{ route('public.loan-requests.create') }}" class="mt-2 block w-full text-center px-3 py-2 rounded-md text-body-sm font-medium bg-primary-600 text-white hover:bg-primary-700">Apply for Loan</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash / session messages (A11y: role=alert) -->
    <div class="myds-container mt-4">
        @if(session('success'))
            <div role="alert" class="rounded-md p-4 bg-success-50 border otl-success-200 text-success-700">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div role="alert" class="rounded-md p-4 bg-danger-50 border otl-danger-200 text-danger-700">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif
        @if(session('warning'))
            <div role="alert" class="rounded-md p-4 bg-warning-50 border otl-warning-200 text-warning-700">
                <p class="font-medium">{{ session('warning') }}</p>
            </div>
        @endif
        @if(session('info'))
            <div role="status" class="rounded-md p-4 bg-primary-50 border otl-primary-200 text-primary-700">
                <p class="font-medium">{{ session('info') }}</p>
            </div>
        @endif
    </div>

    <!-- Main content -->
    <main id="main-content" tabindex="-1" class="myds-container py-8" role="main">
        @yield('content')
    </main>

    <!-- Footer (MYDS pattern, accessible) -->
    <footer class="bg-bg-white-0 border-t border-otl-divider mt-auto" role="contentinfo">
        <div class="myds-container py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-8 w-auto">
                        <div>
                            <p class="text-heading-4xs font-semibold text-txt-black-900">Bahagian Pengurusan Maklumat (BPM)</p>
                            <p class="text-body-xs text-txt-black-500">Kementerian Pelancongan, Seni dan Budaya Malaysia</p>
                        </div>
                    </div>
                    <p class="text-body-sm text-txt-black-700 mb-4">
                        Kami menyediakan perkhidmatan pinjaman peralatan ICT dan sokongan meja bantuan untuk staf kerajaan. Hubungi kami untuk bantuan lanjut.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="text-txt-black-500 hover:text-primary-600" aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12.07C22 6.54 17.52 2 12 2S2 6.54 2 12.07C2 17.09 5.66 21.24 10.44 22v-6.99H7.9v-2.94h2.55V9.8c0-2.52 1.49-3.9 3.77-3.9 1.09 0 2.23.2 2.23.2v2.45h-1.25c-1.23 0-1.61.77-1.61 1.56v1.87h2.74l-.44 2.94h-2.3V22C18.34 21.24 22 17.09 22 12.07z"/></svg>
                        </a>
                        <a href="#" class="text-txt-black-500 hover:text-primary-600" aria-label="Twitter">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.17 4.17 0 001.85-2.3 8.32 8.32 0 01-2.64 1.01 4.14 4.14 0 00-7.06 3.77A11.75 11.75 0 013 4.89a4.13 4.13 0 001.28 5.52c-.66-.02-1.28-.2-1.82-.5v.05a4.14 4.14 0 003.32 4.06c-.48.13-.99.2-1.51.08a4.15 4.15 0 003.86 2.88A8.31 8.31 0 012 19.54a11.73 11.73 0 006.29 1.84c7.55 0 11.68-6.26 11.68-11.68l-.01-.53A8.18 8.18 0 0022.46 6z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-heading-4xs font-medium text-txt-black-900 mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-body-sm text-txt-black-700">
                        <li><a href="{{ route('public.loan-requests.create') }}" class="hover:text-primary-600 myds-hover-underline">Equipment Loan Request</a></li>
                        <li><a href="{{ route('public.helpdesk.create') }}" class="hover:text-primary-600 myds-hover-underline">Report ICT Issue</a></li>
                        <li><a href="{{ route('public.track') }}" class="hover:text-primary-600 myds-hover-underline">Track Request Status</a></li>
                        <li><a href="#" class="hover:text-primary-600 myds-hover-underline">Privacy Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-heading-4xs font-medium text-txt-black-900 mb-3">Contact</h3>
                    <div class="space-y-2 text-body-sm text-txt-black-700">
                        <p><span class="font-medium">Email:</span> <a href="mailto:ict-support@example.gov.my" class="hover:text-primary-600">ict-support@example.gov.my</a></p>
                        <p><span class="font-medium">Phone:</span> <a href="tel:+603xxxxxxx" class="hover:text-primary-600">+60 3-xxxx xxxx</a></p>
                        <p><span class="font-medium">Office Hours:</span> Mon–Fri, 8:00 AM – 5:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-otl-divider mt-8 pt-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between text-body-xs text-txt-black-500 gap-2">
                    <div>&copy; {{ date('Y') }} Kementerian Pelancongan, Seni dan Budaya Malaysia. All rights reserved.</div>
                    <div class="flex items-center gap-3">
                        <div>Powered by ICTServe</div>
                        <a href="https://design.digital.gov.my" target="_blank" rel="noopener" class="text-primary-600 hover:underline">Malaysia Government Design System (MYDS)</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Minimal accessible scripts -->
    <script>
        // Toggle mobile menu with accessible attributes
        (function(){
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            if (!btn || !menu) return;

            btn.addEventListener('click', function(){
                const expanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', String(!expanded));
                menu.classList.toggle('hidden');
                menu.setAttribute('aria-hidden', String(expanded));
            });

            // Close menu on Escape
            document.addEventListener('keydown', function(e){
                if (e.key === 'Escape' && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    menu.setAttribute('aria-hidden', 'true');
                    btn.focus();
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
