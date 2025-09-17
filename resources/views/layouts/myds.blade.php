<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-bind:class="{ 'dark': isDark }" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'ICTServe (iServe) — Sistem Pengurusan Perkhidmatan ICT, MOTAC' }}">
    <meta name="theme-color" content="#FFFFFF" id="theme-color">

    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'ICTServe (iServe)') }}</title>

    <!-- Fonts: MYDS typography (Poppins for headings, Inter for body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

    <!-- Assets (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Prevent FOUC: set theme before frameworks load -->
    <script>
        (function () {
            try {
                const saved = localStorage.getItem('theme') || 'system';
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const dark = saved === 'dark' || (saved === 'system' && prefersDark);
                if (dark) {
                    document.documentElement.classList.add('dark');
                    document.getElementById('theme-color')?.setAttribute('content', '#18181B');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.getElementById('theme-color')?.setAttribute('content', '#FFFFFF');
                }
            } catch (e) { /* fail silently */ }
        })();
    </script>

    <style>
        /* MYDS skip link (hidden until focused) */
        .myds-skip-link {
            position: absolute;
            left: 1rem;
            top: -48px;
            background: var(--myds-primary-600, #2563EB);
            color: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            z-index: 9999;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
            transition: top 150ms ease-in-out;
        }
        .myds-skip-link:focus{ top: 1rem; }
    </style>

    {{ $head ?? '' }}
</head>
<body class="min-h-screen bg-bg-washed text-txt-black-900 antialiased">

    <!-- Skip link for keyboard users (MYDS) -->
    <a href="#main-content" class="myds-skip-link myds-focus-visible">Langkau ke kandungan utama / Skip to main content</a>

    <!-- Phase banner (optional) -->
    @if(isset($phaseBanner))
        <div class="bg-primary-50 border-b border-otl-divider">
            <div class="myds-container py-2 flex items-center gap-3">
                <span class="inline-flex items-center rounded-md bg-primary-100 text-primary-600 px-3 py-1 text-body-sm font-medium">
                    {{ $phaseBanner['phase'] ?? 'BETA' }}
                </span>
                <p class="text-body-sm text-txt-black-700">
                    {{ $phaseBanner['description'] ?? 'Perkhidmatan baharu – maklum balas anda penting untuk penambahbaikan.' }}
                </p>
                @if(!empty($phaseBanner['feedbackUrl']))
                    <a href="{{ $phaseBanner['feedbackUrl'] }}" class="ml-auto text-body-sm text-primary-600 hover:text-primary-700 underline">
                        {{ $phaseBanner['feedbackText'] ?? 'Beri maklum balas / Give feedback' }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <div class="flex flex-col min-h-screen">

        <!-- Masthead -->
        <header class="bg-bg-white-0 border-b border-otl-divider" role="banner">
            <div class="myds-container flex items-center justify-between py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3" aria-label="Halaman Utama ICTServe">
                        <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-10 w-auto">
                        <div>
                            <div class="text-heading-3xs font-semibold text-txt-black-900">ICTServe (iServe)</div>
                            <div class="text-body-xs text-txt-black-500">Sistem Pengurusan Perkhidmatan ICT — MOTAC</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Language select -->
                    <label for="locale-select" class="sr-only">Pilih Bahasa</label>
                    <select id="locale-select" onchange="location.href='{{ url('language') }}/'+this.value"
                            class="text-body-sm border otl-gray-300 rounded px-2 py-1 bg-bg-white-0"
                            aria-label="Pilih Bahasa / Select Language">
                        <option value="ms" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>BM</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    </select>

                    <!-- Theme switcher component (MYDS wrapper) -->
                    <x-myds.theme-switcher aria-label="Tukar tema / Toggle theme" />

                    <!-- Auth / user actions -->
                    @auth
                        <a href="{{ route('notifications.index') }}" class="relative p-2 rounded-md hover:bg-bg-washed focus:outline-none focus:ring-2 focus:ring-fr-primary" aria-label="Notifications">
                            <svg class="w-5 h-5 text-txt-black-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-5-5V9a6 6 0 10-12 0v3l-5 5h5a3 3 0 106 0z"></path>
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-danger-600 text-white text-xs rounded-full flex items-center justify-center" aria-hidden="true">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @keydown.escape="open = false"
                                    class="flex items-center gap-2 rounded-md p-2 hover:bg-bg-washed focus:outline-none focus:ring-2 focus:ring-fr-primary"
                                    aria-haspopup="true" :aria-expanded="open.toString()">
                                <span class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden md:block text-body-sm text-txt-black-900">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-txt-black-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 @click.outside="open = false"
                                 class="absolute right-0 mt-2 w-56 bg-bg-white-0 border border-otl-divider rounded-md shadow-context-menu z-50"
                                 role="menu" aria-label="Menu pengguna">
                                <div class="py-1">
                                    <div class="px-4 py-2 text-sm text-txt-black-500 border-b border-otl-divider">
                                        {{ auth()->user()->position ?? '' }}
                                    </div>
                                    <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed" role="menuitem">Profil</a>
                                    <a href="{{ route('helpdesk.index') }}" class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed" role="menuitem">Bantuan</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-body-sm text-danger-600 hover:bg-bg-washed" role="menuitem">Log keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-body-sm text-primary-600 hover:underline">Log masuk</a>
                            <a href="{{ route('register') }}" class="myds-btn-primary myds-btn-sm">Daftar</a>
                        </div>
                    @endauth

                    <!-- Mobile menu toggle -->
                    <button x-data @click="$dispatch('toggle-mobile-menu')" class="md:hidden p-2 rounded-md hover:bg-bg-washed" aria-label="Buka menu mudah alih">
                        <svg class="w-6 h-6 text-txt-black-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            @auth
                <!-- Primary navigation -->
                <nav id="primary-navigation" class="bg-bg-white-0 border-t border-otl-divider" aria-label="Navigasi utama">
                    <div class="myds-container">
                        <ul class="flex gap-1 py-2" role="menubar" aria-label="Primary">
                            @php
                                $navItems = [
                                    ['route' => 'dashboard', 'label' => 'Utama', 'icon' => 'home', 'pattern' => 'dashboard'],
                                    ['route' => 'loan.index', 'label' => 'Pinjaman ICT', 'icon' => 'document-text', 'pattern' => 'loan.*'],
                                    ['route' => 'helpdesk.index', 'label' => 'Aduan ICT', 'icon' => 'support', 'pattern' => 'helpdesk.*'],
                                    ['route' => 'equipment.index', 'label' => 'Peralatan', 'icon' => 'computer-desktop', 'pattern' => 'equipment.*'],
                                ];
                                if(auth()->user()->isIctAdmin() || auth()->user()->isSuperAdmin()) {
                                    $navItems[] = ['route' => 'admin.dashboard', 'label' => 'Pentadbiran', 'icon' => 'cog-6-tooth', 'pattern' => 'admin.*'];
                                }
                            @endphp

                            @foreach($navItems as $item)
                                @php $active = request()->routeIs($item['pattern'] ?? ($item['route'] . '*')); @endphp
                                <li role="none">
                                    <a role="menuitem" href="{{ route($item['route']) }}"
                                       class="flex items-center gap-2 px-3 py-2 rounded-md text-body-sm font-medium transition-colors
                                       {{ $active ? 'bg-primary-50 text-primary-700 border-b-2 border-primary-600' : 'text-txt-black-700 hover:bg-bg-washed hover:text-txt-black-900' }}">
                                        @switch($item['icon'])
                                            @case('home')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path d="M3 9.5L10 3l7 6.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5 10v6a1 1 0 001 1h2m6-7v6a1 1 0 01-1 1h-2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                @break
                                            @case('document-text')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path d="M7 2h5l5 5v9a1 1 0 01-1 1H5a1 1 0 01-1-1V3a1 1 0 011-1z" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9 8h6M9 12h6" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                @break
                                            @case('support')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <circle cx="10" cy="10" r="8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M10 7v4l3 1" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                @break
                                            @case('computer-desktop')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <rect x="3" y="4" width="14" height="9" rx="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M8 17h4" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                @break
                                            @case('cog-6-tooth')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <circle cx="10" cy="10" r="3"></circle>
                                                    <path d="M10 2v2M10 16v2M2 10h2M16 10h2M4.2 4.2l1.4 1.4M14.4 14.4l1.4 1.4M4.2 15.8l1.4-1.4M14.4 5.6l1.4-1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                @break
                                        @endswitch
                                        <span>{{ $item['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </nav>
            @endauth
        </header>

        <!-- Main content (landmark) -->
        <main id="main-content" role="main" tabindex="-1" class="flex-1 bg-bg-white-50">
            @if(isset($breadcrumbs))
                <div class="bg-bg-white-0 border-b border-otl-divider">
                    <div class="myds-container py-3">
                        <nav aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2 text-body-sm">
                                @foreach($breadcrumbs as $crumb)
                                    <li class="flex items-center">
                                        @if(!$loop->first)
                                            <svg class="w-3 h-3 text-txt-black-400 mx-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                        @if(isset($crumb['url']) && !$loop->last)
                                            <a href="{{ $crumb['url'] }}" class="text-primary-600 hover:text-primary-700 myds-hover-underline">{{ $crumb['title'] }}</a>
                                        @else
                                            <span class="text-txt-black-700" aria-current="page">{{ $crumb['title'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </div>
                </div>
            @endif

            <div class="myds-container py-6">
                {{ $slot }}
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-bg-white-0 border-t border-otl-divider mt-auto" role="contentinfo">
            <div class="myds-container py-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-6">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-8 w-auto">
                            <div>
                                <div class="text-heading-3xs font-medium text-txt-black-900">Ministry of Tourism, Arts and Culture</div>
                                <div class="text-body-xs text-txt-black-500">Bahagian Pengurusan Maklumat (BPM)</div>
                            </div>
                        </div>
                        <p class="text-body-sm text-txt-black-700 mb-4">
                            ICTServe (iServe) — Sistem pengurusan peralatan dan meja bantuan ICT dalaman. Dibina mengikuti MYDS &amp; MyGovEA untuk pengalaman yang konsisten dan boleh diakses.
                        </p>
                        <div class="text-sm text-txt-black-500">
                            <p>Aras 28, Menara Bangkok Bank</p>
                            <p>Berjaya Central Park, Kuala Lumpur</p>
                            <p>Telefon: +60 3-xxxx xxxx</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-2">Pautan Pantas</h3>
                        <ul class="space-y-2 text-body-sm text-txt-black-700">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-primary-600 myds-hover-underline">Utama</a></li>
                            <li><a href="{{ route('loan.create') }}" class="hover:text-primary-600 myds-hover-underline">Mohon Pinjaman</a></li>
                            <li><a href="{{ route('helpdesk.create') }}" class="hover:text-primary-600 myds-hover-underline">Lapor Kerosakan</a></li>
                            <li><a href="{{ route('equipment.index') }}" class="hover:text-primary-600 myds-hover-underline">Katalog Peralatan</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-2">Sokongan</h3>
                        <ul class="space-y-2 text-body-sm text-txt-black-700">
                            <li><a href="#" class="hover:text-primary-600 myds-hover-underline">Pusat Bantuan</a></li>
                            <li><a href="#" class="hover:text-primary-600 myds-hover-underline">FAQ</a></li>
                            <li><a href="#" class="hover:text-primary-600 myds-hover-underline">Hubungi Kami</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-2">Sumber</h3>
                        <ul class="space-y-2 text-body-sm text-txt-black-700">
                            <li><a href="https://design.digital.gov.my" target="_blank" rel="noopener" class="hover:text-primary-600 myds-hover-underline">MYDS</a></li>
                            <li><a href="{{ asset('docs/prinsip-reka-bentuk-mygovea.md') }}" class="hover:text-primary-600 myds-hover-underline">MyGovEA</a></li>
                            <li><a href="#" class="hover:text-primary-600 myds-hover-underline">Dasar Privasi</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-otl-divider mt-6 pt-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <p class="text-body-xs text-txt-black-500">© {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.</p>
                        <p class="text-body-xs text-txt-black-500">
                            Mematuhi <a href="https://design.digital.gov.my" class="text-primary-600 hover:underline" target="_blank" rel="noopener">Malaysia Government Design System (MYDS)</a> &amp; prinsip <a href="{{ asset('docs/prinsip-reka-bentuk-mygovea.md') }}" class="text-primary-600 hover:underline">MyGovEA</a>.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Toast area (MYDS) -->
    <div id="toast-root" class="fixed bottom-6 right-6 z-50 pointer-events-none" aria-live="polite" x-data="toaster()">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
                 class="pointer-events-auto max-w-sm w-full bg-bg-white-0 border border-otl-divider rounded-md shadow-context-menu overflow-hidden mb-3"
                 :class="{
                    'border-l-4 border-l-primary-600': toast.type === 'info',
                    'border-l-4 border-l-success-600': toast.type === 'success',
                    'border-l-4 border-l-warning-600': toast.type === 'warning',
                    'border-l-4 border-l-danger-600': toast.type === 'error'
                 }" role="status" aria-atomic="true">
                <div class="p-4 flex items-start gap-3">
                    <div class="flex-shrink-0" x-html="toast.icon"></div>
                    <div class="flex-1">
                        <p class="text-body-sm font-medium text-txt-black-900" x-text="toast.title"></p>
                        <p class="mt-1 text-body-sm text-txt-black-700" x-text="toast.message"></p>
                    </div>
                    <button @click="remove(toast.id)" class="text-txt-black-400 hover:text-txt-black-600" aria-label="Close notification">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div x-show="toast.progress" class="h-1 bg-bg-white-100">
                    <div class="h-full" :style="{ width: toast.progressWidth + '%' }" :class="{
                        'bg-primary-600': toast.type === 'info',
                        'bg-success-600': toast.type === 'success',
                        'bg-warning-600': toast.type === 'warning',
                        'bg-danger-600': toast.type === 'error'
                    }"></div>
                </div>
            </div>
        </template>
    </div>

    @livewireScripts
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Minimal theme manager for Alpine + JS interop
        function themeManager() {
            return {
                isDark: document.documentElement.classList.contains('dark'),
                init() {
                    this.isDark = document.documentElement.classList.contains('dark');
                },
                toggle() {
                    this.isDark = !this.isDark;
                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        document.getElementById('theme-color')?.setAttribute('content', '#18181B');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        document.getElementById('theme-color')?.setAttribute('content', '#FFFFFF');
                    }
                }
            };
        }

        // Simple toast manager - used by layout
        function toaster() {
            return {
                toasts: [],
                add(type = 'info', title = '', message = '', duration = 3500) {
                    const id = Date.now() + Math.random().toString(36).slice(2,8);
                    const iconMap = {
                        success: '<svg class="w-5 h-5 text-success-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                        error: '<svg class="w-5 h-5 text-danger-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
                        warning: '<svg class="w-5 h-5 text-warning-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
                        info: '<svg class="w-5 h-5 text-primary-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
                    };
                    const toast = {
                        id,
                        type,
                        title,
                        message,
                        visible: true,
                        progress: true,
                        progressWidth: 100,
                        icon: iconMap[type] || iconMap.info
                    };
                    this.toasts.push(toast);

                    // animate progress
                    const interval = 50;
                    const steps = Math.max(1, Math.floor(duration / interval));
                    let step = 0;
                    const timer = setInterval(() => {
                        step++;
                        toast.progressWidth = Math.max(0, 100 - Math.round((step / steps) * 100));
                        if (step >= steps) {
                            clearInterval(timer);
                            this.remove(id);
                        }
                    }, interval);
                },
                remove(id) {
                    const t = this.toasts.find(t => t.id === id);
                    if (!t) return;
                    t.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(i => i.id !== id);
                    }, 220);
                }
            };
        }

        // Expose a global helper to trigger toasts from anywhere
        window.showToast = function(type, title, message, duration) {
            const root = document.querySelector('[x-data="toaster()"]') || document.getElementById('toast-root');
            if (!root) return;
            const data = root.__x ? root.__x.$data : (root._x_dataStack ? root._x_dataStack[0] : null);
            if (data && typeof data.add === 'function') {
                data.add(type, title, message, duration ?? 3500);
            } else {
                console.warn('Toast root not initialized yet.');
            }
        };

        // On page load, flash server-side messages (session) to the toast system
        document.addEventListener('alpine:init', () => {
            Alpine.onReady(() => {
                @if(session()->has('success'))
                    showToast('success', 'Berjaya', {!! json_encode(session('success')) !!}, 4500);
                @endif
                @if(session()->has('error'))
                    showToast('error', 'Ralat', {!! json_encode(session('error')) !!}, 6000);
                @endif
                @if(session()->has('warning'))
                    showToast('warning', 'Amaran', {!! json_encode(session('warning')) !!}, 5000);
                @endif
                @if(session()->has('info'))
                    showToast('info', 'Makluman', {!! json_encode(session('info')) !!}, 4000);
                @endif
            });
        });
    </script>

    {{ $scripts ?? '' }}
</body>
</html>
