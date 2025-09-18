<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-bind:class="{ 'dark': isDark }" class="h-full">
<head>
    {{--
        ICTServe (iServe) layout — MYDS & MyGovEA compliant
        - Fonts: Poppins (headings), Inter (body)
        - Uses semantic token classes (e.g. bg-bg-white-0, text-txt-black-900)
        - Accessible: skip links, landmarks, ARIA attributes
        - Theme and FOUC prevention handled via inline script (reads localStorage)
    --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'ICTServe (iServe) — Sistem Pengurusan Perkhidmatan ICT, MOTAC' }}">
    <meta name="theme-color" content="#FFFFFF" id="theme-color">

    <title>{{ ($title ? $title . ' - ' : '') . 'ICTServe (iServe)' }}</title>

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600&display=swap" rel="stylesheet">

    <!-- Vite assets (Tailwind configured with MYDS tokens) -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/theme.js'])
    @livewireStyles

    <!-- Prevent FOUC: set theme before framework boots -->
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
            } catch (e) {
                // Fail safely — no blocking
            }
        })();
    </script>

    <style>
        /* Visible only on keyboard focus: MYDS skip link behaviour */
        .myds-skip-link {
            position: absolute;
            left: 1rem;
            top: -40px;
            background: var(--myds-primary-600, #2563EB);
            color: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: top 160ms ease-in-out;
        }
        .myds-skip-link:focus {
            top: 1rem;
        }
    </style>

    {{ $head ?? '' }}
</head>
<body class="min-h-screen bg-bg-washed text-txt-black-900 antialiased">

    <!-- Skip link: must be first interactive element for keyboard users (MYDS Skip Link) -->
    <a href="#main-content" class="myds-skip-link myds-focus-visible">Langkau ke kandungan utama / Skip to main content</a>

    {{-- Phase banner slot (optional) --}}
    @if(isset($phaseBanner))
        <div class="bg-primary-50 border-b border-otl-divider">
            <div class="myds-container py-2 flex items-center gap-3">
                <span class="inline-flex items-center rounded-md bg-primary-100 text-primary-600 px-3 py-1 text-body-sm font-medium">
                    {{ $phaseBanner['phase'] ?? 'BETA' }}
                </span>
                <p class="text-body-sm text-txt-black-700">
                    {{ $phaseBanner['description'] ?? 'Perkhidmatan baharu — maklum balas anda amat dihargai.' }}
                </p>
                @if(!empty($phaseBanner['feedbackUrl']))
                    <a href="{{ $phaseBanner['feedbackUrl'] }}" class="ml-auto text-body-sm text-primary-600 hover:text-primary-700 underline">
                        {{ $phaseBanner['feedbackText'] ?? 'Beri maklum balas / Give feedback' }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <div class="min-h-screen flex flex-col">

        <!-- Masthead / Header -->
        <header class="bg-bg-white-0 border-b border-otl-divider" role="banner">
            <div class="myds-container flex items-center justify-between py-4">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="Halaman utama ICTServe">
                        <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-10 w-auto" />
                        <div>
                            <div class="text-heading-3xs font-semibold text-txt-black-900">ICTServe (iServe)</div>
                            <div class="text-body-xs text-txt-black-500">Sistem Pengurusan Perkhidmatan ICT — MOTAC</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3">

                    {{-- Language selector (accessible) --}}
                    <label for="locale-select" class="sr-only">Pilih bahasa / Select language</label>
                    <select id="locale-select" onchange="location.href='{{ url('language') }}/'+this.value"
                            class="text-body-sm border otl-gray-300 rounded px-2 py-1 bg-bg-white-0"
                            aria-label="Pilih Bahasa / Select Language">
                        <option value="ms" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>BM</option>
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>EN</option>
                    </select>

                    {{-- Theme switcher blade component (MYDS wrapper) --}}
                    <x-myds.theme-switcher aria-label="Tukar tema / Toggle theme" />

                    {{-- Authentication / user menu --}}
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @keydown.escape="open = false"
                                    aria-haspopup="true" :aria-expanded="open.toString()"
                                    class="flex items-center gap-2 rounded-md p-2 hover:bg-bg-washed focus:outline-none focus:ring-2 focus:ring-fr-primary">
                                <span class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden md:block text-body-sm text-txt-black-900">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-txt-black-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
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
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed" role="menuitem">Tetapan Profil / Profile</a>
                                    <a href="{{ route('helpdesk.index') }}" class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed" role="menuitem">Bantuan / Helpdesk</a>
                                    <hr class="border-otl-divider my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-body-sm text-danger-600 hover:bg-bg-washed" role="menuitem">Log keluar / Sign out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-body-sm text-primary-600 hover:underline">Log masuk / Sign in</a>
                            <a href="{{ route('register') }}" class="myds-btn-primary myds-btn-sm">Daftar / Register</a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Primary navigation (optional for authenticated users) --}}
            @auth
                <nav id="main-navigation" aria-label="Navigasi utama" class="bg-bg-white-0 border-t border-otl-divider">
                    <div class="myds-container">
                        <ul class="flex gap-1 py-2" role="menubar" aria-label="Primary">
                            @php
                                $navItems = [
                                    ['route' => 'dashboard', 'label' => __('Utama'), 'icon' => 'home', 'pattern' => 'dashboard'],
                                    ['route' => 'loan.index',   'label' => __('Pinjaman ICT'), 'icon' => 'document-text', 'pattern' => 'loan.*'],
                                    ['route' => 'helpdesk.index','label' => __('Aduan ICT'), 'icon' => 'support', 'pattern' => 'helpdesk.*'],
                                    ['route' => 'equipment.index','label' => __('Peralatan'), 'icon' => 'computer-desktop', 'pattern' => 'equipment.*'],
                                ];
                                if(auth()->user()->isIctAdmin() || auth()->user()->isSuperAdmin()){
                                    $navItems[] = ['route' => 'admin.dashboard', 'label' => __('Pentadbiran'), 'icon' => 'cog-6-tooth', 'pattern' => 'admin.*'];
                                }
                            @endphp

                            @foreach($navItems as $item)
                                @php
                                    $active = request()->routeIs($item['pattern'] ?? ($item['route'] . '*'));
                                @endphp
                                <li role="none">
                                    <a role="menuitem" href="{{ route($item['route']) }}"
                                       class="flex items-center gap-2 px-3 py-2 rounded-md text-body-sm font-medium transition-colors
                                       {{ $active ? 'bg-primary-50 text-primary-700 border-b-2 border-primary-600' : 'text-txt-black-700 hover:bg-bg-washed hover:text-txt-black-900' }}">
                                        {{-- Inline MYDS-style icons (20x20 grid, 1.5px stroke) --}}
                                        @switch($item['icon'])
                                            @case('home')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path d="M3 9.5L10 3l7 6.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M5 10v6a1 1 0 001 1h2m6-7v6a1 1 0 01-1 1h-2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                @break
                                            @case('document-text')
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path d="M7 2h5l5 5v9a1 1 0 01-1 1H5a1 1 0 01-1-1V3a1 1 0 011-1z" stroke-linecap="round" stroke-linejoin="round"/>
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

        <!-- Main: landmarks and focus management for accessibility -->
        <main id="main-content" role="main" tabindex="-1" class="flex-1 bg-bg-white-50">
            <div class="myds-container py-6">
                {{-- Breadcrumbs + Page header slots --}}
                @if(isset($breadcrumbs) || isset($pageTitle))
                    <div class="mb-6">
                        @if(isset($breadcrumbs))
                            <nav aria-label="Breadcrumb" class="mb-3">
                                <ol class="flex items-center text-body-sm space-x-2">
                                    @foreach($breadcrumbs as $crumb)
                                        <li>
                                            @if(!$loop->last)
                                                <a href="{{ $crumb['url'] ?? '#' }}" class="text-primary-600 hover:text-primary-700">{{ $crumb['title'] }}</a>
                                                <span class="text-txt-black-400 mx-2">/</span>
                                            @else
                                                <span class="text-txt-black-700">{{ $crumb['title'] }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        @endif

                        @if(isset($pageTitle))
                            <div class="flex items-start justify-between">
                                <div>
                                    <h1 class="myds-heading text-heading-md font-semibold text-txt-black-900">{{ $pageTitle }}</h1>
                                    @if(isset($pageDescription))
                                        <p class="mt-2 text-body-base text-txt-black-700">{{ $pageDescription }}</p>
                                    @endif
                                </div>
                                @if(isset($pageActions))
                                    <div class="flex items-center gap-2">
                                        {!! $pageActions !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Main slot (page body) --}}
                <div>
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer (MYDS Footer pattern) -->
        <footer class="bg-bg-white-0 border-t border-otl-divider mt-auto" role="contentinfo">
            <div class="myds-container py-8">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-6">
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-8 w-auto" />
                            <div>
                                <div class="text-heading-3xs font-medium text-txt-black-900">ICTServe (iServe)</div>
                                <div class="text-body-xs text-txt-black-500">Kementerian Pelancongan, Seni dan Budaya Malaysia</div>
                            </div>
                        </div>
                        <p class="text-body-sm text-txt-black-700">
                            Sistem pengurusan peralatan dan meja bantuan ICT dalaman, dibangunkan mengikut MYDS &amp; MyGovEA.
                        </p>
                    </div>

                    <div class="md:col-span-3">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-2">Pautan Pantas</h3>
                        <ul class="space-y-2">
                            <li><a class="text-body-sm text-txt-black-700 hover:text-primary-600" href="{{ route('dashboard') }}">Utama</a></li>
                            <li><a class="text-body-sm text-txt-black-700 hover:text-primary-600" href="{{ route('loan.index') }}">Pinjaman ICT</a></li>
                            <li><a class="text-body-sm text-txt-black-700 hover:text-primary-600" href="{{ route('helpdesk.index') }}">Aduan ICT</a></li>
                            <li><a class="text-body-sm text-txt-black-700 hover:text-primary-600" href="{{ route('equipment.index') }}">Peralatan</a></li>
                        </ul>
                    </div>

                    <div class="md:col-span-3">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-2">Sokongan</h3>
                        <ul class="space-y-2">
                            <li class="text-body-sm text-txt-black-700">E-mel: <a href="mailto:ict-support@example.gov.my" class="text-primary-600 hover:underline">ict-support@example.gov.my</a></li>
                            <li class="text-body-sm text-txt-black-700">Telefon: +60 3-xxxx xxxx</li>
                            <li class="text-body-sm text-txt-black-700">Talian Kecemasan: +60 3-yyyy yyyy (24/7)</li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-otl-divider mt-6 pt-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <p class="text-body-xs text-txt-black-500">© {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.</p>
                        <p class="text-body-xs text-txt-black-500">
                            Mematuhi <a href="https://design.digital.gov.my/" class="text-primary-600 hover:underline" target="_blank" rel="noopener">Malaysia Government Design System (MYDS)</a> &amp; prinsip <a href="{{ asset('docs/prinsip-reka-bentuk-mygovea.md') }}" class="text-primary-600 hover:underline">MyGovEA</a>.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Toast container for unobtrusive messages (MYDS Toast) --}}
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 pointer-events-none" aria-live="polite"></div>

    @livewireScripts

    <!-- Alpine (deferred) for interactivity if not bundled -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Simple theme manager for Alpine (used by x-data above). Keep minimal and robust. --}}
    <script>
        function themeManager(){
            return {
                isDark: document.documentElement.classList.contains('dark'),
                init() {
                    // keep reactive state in sync with root class
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
                },
                set(theme) {
                    if (theme === 'system') {
                        localStorage.setItem('theme', 'system');
                        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        if (prefersDark) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');
                    } else if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                    this.isDark = document.documentElement.classList.contains('dark');
                }
            };
        }

        // Toast API: small helper to show MYDS-styled toasts from anywhere
        window.showToast = function(type = 'info', title = '', message = '', duration = 3500) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const id = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.setAttribute('role','status');
            toast.className = 'pointer-events-auto max-w-sm w-full bg-bg-white-0 border border-otl-divider rounded-md shadow-context-menu overflow-hidden mb-3';
            toast.style.display = 'flex';
            toast.style.alignItems = 'flex-start';
            toast.style.gap = '0.75rem';
            toast.innerHTML = `
                <div style="padding:0.75rem;display:flex;align-items:center;">
                    ${ type === 'success' ? '<svg class="w-5 h-5 text-success-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' : '' }
                    ${ type === 'error' ? '<svg class="w-5 h-5 text-danger-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>' : '' }
                    ${ type === 'warning' ? '<svg class="w-5 h-5 text-warning-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>' : '' }
                    ${ type === 'info' ? '<svg class="w-5 h-5 text-primary-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>' : '' }
                </div>
                <div style="padding:0.75rem;flex:1;">
                    <p style="margin:0;font-weight:600;color:var(--txt-black-900,#111)">${title}</p>
                    <p style="margin:0;margin-top:0.25rem;color:var(--txt-black-700,#333)">${message}</p>
                </div>
                <div style="padding:0.5rem;">
                    <button aria-label="Close toast" style="background:none;border:none;color:var(--txt-black-500,#666);cursor:pointer;font-size:1rem;">✕</button>
                </div>
            `;
            container.appendChild(toast);

            // close on button click
            toast.querySelector('button')?.addEventListener('click', () => {
                toast.remove();
            });

            if (duration > 0) {
                setTimeout(() => {
                    toast.remove();
                }, duration);
            }
        };
    </script>

    {{ $scripts ?? '' }}
</body>
</html>
