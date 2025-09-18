@props([
    'title' => 'ICTServe - Sistem Pengurusan Perkhidmatan ICT',
    'breadcrumbs' => [],
    'sidebarCollapsed' => false,
    'showNotifications' => true,
    'showLanguageToggle' => true,
    'pageActions' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Meta Tags -->
    <meta name="description" content="Sistem Pengurusan Perkhidmatan ICT untuk Kementerian Pelancongan, Seni dan Budaya Malaysia">
    <meta name="keywords" content="ICT, Malaysia, MOTAC, pinjaman peralatan, helpdesk, servicedesk">
    <meta name="author" content="Bahagian Pengurusan Maklumat, MOTAC">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/ictserve-icon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/ictserve-icon.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ asset('images/ictserve-apple-touch-icon.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="Sistem Pengurusan Perkhidmatan ICT untuk MOTAC">
    <meta property="og:image" content="{{ asset('images/ictserve-og-image.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="Sistem Pengurusan Perkhidmatan ICT untuk MOTAC">
    <meta property="twitter:image" content="{{ asset('images/ictserve-og-image.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Additional Head Content -->
    {{ $head ?? '' }}
</head>
<body class="h-full bg-bg-light font-body">
    {{-- Skip to main content (MYDS Skiplink) --}}
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-bg-white focus:text-txt-primary focus:ring-2 focus:ring-fr-primary focus:rounded-md px-4 py-2 shadow-context-menu"
    >
        Langkau ke kandungan utama
    </a>

    {{-- Loading Indicator --}}
    <div
        x-data
        x-show="$store.loading && $store.loading.isLoading"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;"
        role="status"
        aria-live="polite"
        aria-label="Sedang memuat"
    >
        <div class="bg-bg-white rounded-lg p-6 flex items-center space-x-4 shadow-lg">
            <svg class="animate-spin h-6 w-6 text-txt-primary" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <circle cx="10" cy="10" r="8" class="opacity-25" stroke="currentColor" stroke-width="1.5"></circle>
                <path class="opacity-75" stroke-linecap="round" d="M10 2a8 8 0 018 8" />
            </svg>
            <span class="text-txt-black-700 font-medium">Memuat...</span>
        </div>
    </div>

    <div class="min-h-full" x-data="{
        sidebarCollapsed: {{ $sidebarCollapsed ? 'true' : 'false' }},
        isMobile: window.innerWidth < 1024,
        init() {
            // Watch for window resize
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 1024;
            });
            // Auto-collapse sidebar on mobile
            if (this.isMobile) {
                this.sidebarCollapsed = true;
            }
        }
    }" x-init="init()">
        {{-- Sidebar --}}
        <x-ictserve.sidebar
            :collapsed="$sidebarCollapsed"
            class="lg:fixed lg:inset-y-0 lg:left-0 lg:z-40"
        />

        {{-- Main Content Area --}}
        <div
            class="transition-all duration-300"
            :class="{
                'lg:ml-64': !sidebarCollapsed && !isMobile,
                'lg:ml-16': sidebarCollapsed && !isMobile,
                'ml-0': isMobile
            }"
        >
            {{-- Top Action Bar --}}
            <x-ictserve.top-bar
                :show-notifications="$showNotifications"
                :show-language-toggle="$showLanguageToggle"
            />

            {{-- Page Header --}}
            @if(!empty($breadcrumbs) || $pageActions)
                <div class="bg-bg-white border-b border-otl-divider">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="py-4">
                            <div class="flex items-center justify-between">
                                {{-- Breadcrumbs --}}
                                @if(!empty($breadcrumbs))
                                    <nav class="flex" aria-label="Breadcrumb">
                                        <ol class="flex items-center space-x-4">
                                            <li>
                                                <div>
                                                    <a href="{{ route('dashboard') }}" class="text-txt-black-400 hover:text-txt-black-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded" aria-label="Laman Utama">
                                                        <svg class="flex-shrink-0 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path d="M10 2l-7 7h2v7h4v-4h2v4h4v-7h2l-7-7z"/>
                                                        </svg>
                                                        <span class="sr-only">Laman Utama</span>
                                                    </a>
                                                </div>
                                            </li>
                                            @foreach($breadcrumbs as $breadcrumb)
                                                <li>
                                                    <div class="flex items-center">
                                                        <svg class="flex-shrink-0 h-5 w-5 text-txt-black-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path d="M7 14l5-4-5-4v8z"/>
                                                        </svg>
                                                        @if(isset($breadcrumb['url']) && !$loop->last)
                                                            <a href="{{ $breadcrumb['url'] }}" class="ml-4 text-sm font-medium text-txt-black-500 hover:text-txt-black-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded">
                                                                {{ $breadcrumb['title'] }}
                                                            </a>
                                                        @else
                                                            <span class="ml-4 text-sm font-medium text-txt-black-900" aria-current="page">
                                                                {{ $breadcrumb['title'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </nav>
                                @endif

                                {{-- Page Actions --}}
                                @if($pageActions)
                                    <div class="flex items-center space-x-3">
                                        {{ $pageActions }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Main Content --}}
            <main class="flex-1" id="main-content">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{-- Flash Messages --}}
                        @if(session('success'))
                            <x-myds.callout variant="success" class="mb-6" dismissible>
                                {{ session('success') }}
                            </x-myds.callout>
                        @endif

                        @if(session('error'))
                            <x-myds.callout variant="danger" class="mb-6" dismissible>
                                {{ session('error') }}
                            </x-myds.callout>
                        @endif

                        @if(session('warning'))
                            <x-myds.callout variant="warning" class="mb-6" dismissible>
                                {{ session('warning') }}
                            </x-myds.callout>
                        @endif

                        @if(session('info'))
                            <x-myds.callout variant="info" class="mb-6" dismissible>
                                {{ session('info') }}
                            </x-myds.callout>
                        @endif

                        {{-- Page Content --}}
                        {{ $slot }}
                    </div>
                </div>
            </main>

            {{-- Footer --}}
            <footer class="bg-bg-white border-t border-otl-divider">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {{-- Agency Info --}}
                        <div>
                            <div class="flex items-center mb-4">
                                <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="MOTAC" class="h-8 w-auto mr-3">
                                <img src="{{ asset('images/bpm-logo-50.png') }}" alt="BPM" class="h-8 w-auto">
                            </div>
                            <h3 class="text-sm font-medium text-txt-black-900 mb-2">Bahagian Pengurusan Maklumat</h3>
                            <p class="text-sm text-txt-black-600">
                                Kementerian Pelancongan, Seni dan Budaya Malaysia
                            </p>
                        </div>

                        {{-- Quick Links --}}
                        <div>
                            <h3 class="text-sm font-medium text-txt-black-900 mb-4">Pautan Pantas</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('loans.create') }}" class="text-sm text-txt-black-600 hover:text-txt-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded">Pinjaman Baharu</a></li>
                                <li><a href="{{ route('helpdesk.create') }}" class="text-sm text-txt-black-600 hover:text-txt-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded">Aduan Baharu</a></li>
                                <li><a href="{{ route('my-requests') }}" class="text-sm text-txt-black-600 hover:text-txt-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded">Permohonan Saya</a></li>
                                <li><a href="{{ route('help') }}" class="text-sm text-txt-black-600 hover:text-txt-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded">Bantuan</a></li>
                            </ul>
                        </div>

                        {{-- System Info --}}
                        <div>
                            <h3 class="text-sm font-medium text-txt-black-900 mb-4">Maklumat Sistem</h3>
                            <p class="text-sm text-txt-black-600 mb-2">
                                ICTServe (iServe) v{{ config('app.version', '1.0') }}
                            </p>
                            <p class="text-xs text-txt-black-500">
                                Sistem Pengurusan Perkhidmatan ICT
                            </p>
                            <p class="text-xs text-txt-black-400 mt-2">
                                © {{ date('Y') }} Kerajaan Malaysia. Hak cipta terpelihara.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- Alpine.js Global State --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('loading', {
                isLoading: false,
                show() { this.isLoading = true; },
                hide() { this.isLoading = false; }
            });

            Alpine.store('mobile', {
                isMobile: window.innerWidth < 1024,
                init() {
                    window.addEventListener('resize', () => {
                        this.isMobile = window.innerWidth < 1024;
                    });
                }
            });

            Alpine.store('sidebar', {
                collapsed: false,
                pinned: false,

                toggle() {
                    this.collapsed = !this.collapsed;
                    this.saveState();
                },

                pin() {
                    this.pinned = true;
                    this.saveState();
                },

                unpin() {
                    this.pinned = false;
                    this.saveState();
                },

                saveState() {
                    localStorage.setItem('ictserve-sidebar-state', JSON.stringify({
                        collapsed: this.collapsed,
                        pinned: this.pinned
                    }));
                },

                loadState() {
                    const saved = localStorage.getItem('ictserve-sidebar-state');
                    if (saved) {
                        const state = JSON.parse(saved);
                        this.collapsed = state.collapsed;
                        this.pinned = state.pinned;
                    }
                }
            });
        });

        // Initialize stores
        document.addEventListener('DOMContentLoaded', function() {
            if (Alpine?.store) {
                Alpine.store('mobile').init();
                Alpine.store('sidebar').loadState();
            }
        });
    </script>

    {{-- Additional Scripts --}}
    {{ $scripts ?? '' }}
</body>
</html>
