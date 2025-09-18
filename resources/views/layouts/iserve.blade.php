<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- MYDS Compliance: Clear, descriptive title -->
    <title>{{ isset($title) ? $title . ' - ' : '' }}ICT Serve (iServe) - MOTAC</title>

    <!-- MYDS Government Site Identity -->
    <meta name="description" content="ICT Serve (iServe) - Sistem Bersepadu Perkhidmatan ICT MOTAC">
    <meta name="author" content="Kementerian Pelancongan, Seni dan Budaya Malaysia (MOTAC)">

    <!-- MYDS Favicon and Icons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- MYDS Font Support -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- MYDS Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- MYDS Accessibility: Skip Links -->
    <style>
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #000;
            color: #fff;
            padding: 8px;
            text-decoration: none;
            transition: top 0.3s;
        }
        .skip-link:focus {
            top: 6px;
        }
    </style>

    {{ $head ?? '' }}
</head>
<body class="h-full bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <!-- MYDS Accessibility: Skip Links -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <a href="#main-navigation" class="skip-link">Skip to navigation</a>

    <!-- MYDS Header -->
    <header class="bg-white shadow-sm border-b border-gray-200" role="banner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and System Name -->
                <div class="flex items-center">
                    <img src="{{ asset('images/jata-negara.png') }}" alt="Jata Negara" class="h-8 w-8 mr-3">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">ICT Serve (iServe)</h1>
                        <p class="text-xs text-gray-600">Sistem Perkhidmatan ICT MOTAC</p>
                    </div>
                </div>

                <!-- Language Switcher and User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="relative">
                        <select class="text-sm border border-gray-300 rounded px-2 py-1 bg-white"
                                onchange="changeLanguage(this.value)"
                                aria-label="Pilih Bahasa / Select Language">
                            <option value="ms" {{ app()->getLocale() == 'ms' ? 'selected' : '' }}>BM</option>
                            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>EN</option>
                        </select>
                    </div>

                    @auth
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                    aria-expanded="false"
                                    aria-haspopup="true">
                                <span class="mr-2">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-gray-500">({{ auth()->user()->staff_id }})</span>
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50"
                                 role="menu">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Profil Saya / My Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Tetapan / Settings
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Log Keluar / Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">
                            Log Masuk / Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- MYDS Main Layout -->
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar Navigation -->
        @auth
        <nav id="main-navigation"
             class="bg-white w-64 shadow-sm border-r border-gray-200 overflow-y-auto"
             :class="{ 'hidden': !sidebarOpen, 'block': sidebarOpen }"
             role="navigation"
             aria-label="Main navigation">
            <div class="px-4 py-6">
                <!-- Dashboard Link -->
                <div class="mb-6">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : '' }}"
                       aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6a2 2 0 01-2 2H10a2 2 0 01-2-2V5z"></path>
                        </svg>
                        <span>Papan Pemuka / Dashboard</span>
                    </a>
                </div>

                <!-- ICT Loan Module -->
                <div class="mb-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Pinjaman ICT / ICT Loan
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('loan.create') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('loan.create') ? 'bg-green-50 text-green-700 border-r-2 border-green-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Mohon Pinjaman / Request Loan</span>
                        </a>
                        <a href="{{ route('loan.index') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('loan.index') ? 'bg-green-50 text-green-700 border-r-2 border-green-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Senarai Pinjaman / Loan List</span>
                        </a>
                        <a href="{{ route('equipment.index') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-green-50 hover:text-green-700 {{ request()->routeIs('equipment.*') ? 'bg-green-50 text-green-700 border-r-2 border-green-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                            <span>Katalog Peralatan / Equipment Catalog</span>
                        </a>
                    </div>
                </div>

                <!-- Helpdesk Module -->
                <div class="mb-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Meja Bantuan / Helpdesk
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('helpdesk.create') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 {{ request()->routeIs('helpdesk.create') ? 'bg-red-50 text-red-700 border-r-2 border-red-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Lapor Kerosakan / Report Issue</span>
                        </a>
                        <a href="{{ route('helpdesk.index') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 {{ request()->routeIs('helpdesk.index') ? 'bg-red-50 text-red-700 border-r-2 border-red-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Tiket Saya / My Tickets</span>
                        </a>
                    </div>
                </div>

                <!-- Admin Section (if user is admin) -->
                @if(auth()->user()->isIctAdmin() || auth()->user()->isSuperAdmin())
                <div class="mb-6">
                    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Pentadbiran / Administration
                    </h3>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 {{ request()->routeIs('admin.*') ? 'bg-purple-50 text-purple-700 border-r-2 border-purple-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Panel Admin / Admin Panel</span>
                        </a>
                        <a href="{{ route('admin.reports.index') }}"
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>Laporan / Reports</span>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </nav>
        @endauth

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-y-auto focus:outline-none" role="main">
            <div class="p-6">
                <!-- MYDS Breadcrumb -->
                @if(isset($breadcrumbs))
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        @foreach($breadcrumbs as $index => $crumb)
                            <li class="flex">
                                @if($index > 0)
                                    <svg class="flex-shrink-0 w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                                @if(isset($crumb['url']) && !$loop->last)
                                    <a href="{{ $crumb['url'] }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                        {{ $crumb['title'] }}
                                    </a>
                                @else
                                    <span class="text-sm font-medium text-gray-900" aria-current="page">
                                        {{ $crumb['title'] }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
                @endif

                <!-- Page Content -->
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    <!-- MYDS Footer -->
    <footer class="bg-gray-800 text-white py-6" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/jata-negara-white.png') }}" alt="Jata Negara" class="h-8 w-8 mr-3">
                    <div>
                        <p class="text-sm font-medium">ICT Serve (iServe) - MOTAC</p>
                        <p class="text-xs text-gray-400">Kementerian Pelancongan, Seni dan Budaya Malaysia</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">
                        &copy; {{ date('Y') }} Kerajaan Malaysia. Hak Cipta Terpelihara.
                    </p>
                    <p class="text-xs text-gray-400">
                        Dibina mengikut MYDS dan MyGOVEA
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- MYDS Toast Notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2" role="alert" aria-live="polite">
        <!-- Toast messages will be injected here -->
    </div>

    @livewireScripts

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- MYDS Language Switcher -->
    <script>
        function changeLanguage(locale) {
            window.location.href = "{{ url('language') }}/" + locale;
        }
    </script>

    {{ $scripts ?? '' }}
</body>
</html>
