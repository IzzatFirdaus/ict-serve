<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="myds-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'iServe - ICT Equipment Management System for Government Agencies' }}">
    <meta name="keywords" content="ICT, Equipment, Management, Government, Malaysia, MYDS">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'iServe' }} - ICT Equipment Management">
    <meta property="og:description" content="{{ $metaDescription ?? 'ICT Equipment Management System for Government Agencies' }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $title ?? 'iServe' }} - ICT Equipment Management">
    <meta property="twitter:description" content="{{ $metaDescription ?? 'ICT Equipment Management System for Government Agencies' }}">

    <title>{{ $title ?? 'iServe' }} - ICT Equipment Management</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Alpine.js (already included with Livewire) -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- MYDS Theme System: FOUC Prevention handled by theme-switch.js module -->
</head>

<body class="myds-body bg-bg-white-0 text-txt-black-900 antialiased transition-colors duration-200">
    <!-- MYDS Skip Link for Accessibility -->
    <a href="#main-content" class="myds-skip-link myds-focus-visible">
        Skip to main content
    </a>

    <!-- MYDS Phase Banner (if needed) -->
    @if(isset($phaseBanner))
        <div class="bg-primary-50 border-b border-otl-gray-200">
            <div class="myds-container py-2">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="myds-tag myds-tag-primary text-body-sm font-medium">
                        {{ $phaseBanner['phase'] ?? 'BETA' }}
                    </span>
                    <p class="text-body-sm text-txt-black-700">
                        {{ $phaseBanner['description'] ?? 'This is a new service – your feedback will help us to improve it.' }}
                    </p>
                    @if(isset($phaseBanner['feedbackUrl']))
                        <a href="{{ $phaseBanner['feedbackUrl'] }}"
                           class="text-body-sm text-primary-600 hover:text-primary-700 myds-hover-underline">
                            {{ $phaseBanner['feedbackText'] ?? 'Give feedback' }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Main Layout Wrapper -->
    <div class="min-h-screen flex flex-col">

        <!-- MYDS Header -->
        <header class="bg-bg-white-0 border-b border-otl-gray-200 sticky top-0 z-40">
            <div class="myds-container">
                <!-- Top Bar with Logo and Controls -->
                <div class="flex items-center justify-between py-4">

                    <!-- Logo and Title -->
                    <div class="flex items-center space-x-4">
                        <!-- Government Logo -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
                                 alt="Jata Negara Malaysia"
                                 class="h-10 w-auto">
                        </div>

                        <!-- Site Title -->
                        <div class="border-l border-otl-gray-300 pl-4">
                            <h1 class="myds-heading text-heading-2xs font-medium text-txt-black-900">
                                <a href="{{ route('dashboard') }}" class="hover:text-primary-600 transition-colors">
                                    iServe
                                </a>
                            </h1>
                            <p class="text-body-xs text-txt-black-500">
                                ICT Equipment Management
                            </p>
                        </div>
                    </div>

                    <!-- Header Controls -->
                    <div class="flex items-center space-x-3">

                        <!-- Theme Toggle -->
                        <button type="button"
                                data-theme-toggle
                                class="myds-btn-secondary myds-btn-sm"
                                aria-label="Toggle theme mode">
                            <!-- Theme icons will be managed by theme-switch.js module -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>

                        <!-- User Menu -->
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button type="button"
                                        x-on:click="open = !open"
                                        x-on:click.away="open = false"
                                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-bg-washed transition-colors"
                                        aria-expanded="false"
                                        aria-haspopup="true">
                                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-body-sm font-medium">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-body-sm font-medium text-txt-black-900">{{ auth()->user()->name }}</p>
                                        <p class="text-body-xs text-txt-black-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-txt-black-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- User Dropdown -->
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu z-50">
                                    <div class="py-2">
                                        <a href="{{ route('profile.edit') }}"
                                           class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed">
                                            Profile Settings
                                        </a>
                                        <hr class="border-otl-gray-200 my-1">
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-body-sm text-danger-600 hover:bg-bg-washed">
                                                Sign Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('login') }}" class="myds-btn-tertiary myds-btn-sm">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="myds-btn-primary myds-btn-sm">
                                    Register
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Navigation Bar -->
                @auth
                    <nav class="border-t border-otl-gray-200 -mx-6 px-6" aria-label="Main navigation">
                        <div class="flex space-x-1 py-1">
                            @php
                                $navigationItems = [
                                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                                    ['route' => 'loan-requests.index', 'label' => 'Loan Requests', 'icon' => 'document-text'],
                                    ['route' => 'helpdesk-tickets.index', 'label' => 'Helpdesk', 'icon' => 'support'],
                                    ['route' => 'equipment.index', 'label' => 'Equipment', 'icon' => 'computer-desktop'],
                                ];

                                if(auth()->user()->role === 'admin') {
                                    $navigationItems[] = ['route' => 'admin.dashboard', 'label' => 'Admin', 'icon' => 'cog-6-tooth'];
                                }
                            @endphp

                            @foreach($navigationItems as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center space-x-2 px-4 py-3 text-body-sm font-medium rounded-lg transition-colors
                                          {{ request()->routeIs($item['route'] . '*')
                                              ? 'bg-primary-50 text-primary-700 border-b-2 border-primary-600'
                                              : 'text-txt-black-700 hover:text-txt-black-900 hover:bg-bg-washed' }}">
                                    <!-- Dynamic Icon -->
                                    @switch($item['icon'])
                                        @case('home')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            @break
                                        @case('document-text')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            @break
                                        @case('support')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @break
                                        @case('computer-desktop')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            @break
                                        @case('cog-6-tooth')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            @break
                                    @endswitch
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </nav>
                @endauth
            </div>
        </header>

        <!-- MYDS Main Content Area -->
        <main class="flex-1 bg-bg-white-50" id="main-content">

            <!-- Page Header (if provided) -->
            @if(isset($pageTitle) || isset($breadcrumbs))
                <div class="bg-bg-white-0 border-b border-otl-gray-200">
                    <div class="myds-container py-6">

                        <!-- Breadcrumbs -->
                        @if(isset($breadcrumbs))
                            <nav class="mb-4" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-2 text-body-sm">
                                    @foreach($breadcrumbs as $breadcrumb)
                                        <li class="flex items-center">
                                            @if(!$loop->first)
                                                <svg class="w-3 h-3 text-txt-black-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                            @if($loop->last)
                                                <span class="text-txt-black-500">{{ $breadcrumb['label'] }}</span>
                                            @else
                                                <a href="{{ $breadcrumb['url'] }}"
                                                   class="text-primary-600 hover:text-primary-700 myds-hover-underline">
                                                    {{ $breadcrumb['label'] }}
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </nav>
                        @endif

                        <!-- Page Title -->
                        @if(isset($pageTitle))
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="myds-heading text-heading-md font-semibold text-txt-black-900">
                                        {{ $pageTitle }}
                                    </h1>
                                    @if(isset($pageDescription))
                                        <p class="mt-2 text-body-base text-txt-black-700">
                                            {{ $pageDescription }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Page Actions -->
                                @if(isset($pageActions))
                                    <div class="flex items-center space-x-3">
                                        {!! $pageActions !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <div class="myds-container py-6">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>

        <!-- MYDS Footer -->
        <footer class="bg-bg-white-0 border-t border-otl-gray-200 mt-auto">
            <div class="myds-container py-8">
                <div class="myds-grid">
                    <!-- Footer Content -->
                    <div class="col-span-4 tablet:col-span-6 desktop:col-span-8">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
                                 alt="Jata Negara Malaysia"
                                 class="h-8 w-auto">
                            <div>
                                <h3 class="myds-heading text-heading-3xs font-medium text-txt-black-900">
                                    iServe - ICT Equipment Management
                                </h3>
                                <p class="text-body-xs text-txt-black-500">
                                    Government of Malaysia
                                </p>
                            </div>
                        </div>
                        <p class="text-body-sm text-txt-black-700 mb-4">
                            Comprehensive ICT equipment and helpdesk management system designed for government agencies,
                            built following Malaysia Government Design System (MYDS) standards.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-span-4 tablet:col-span-2 desktop:col-span-2">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-3">
                            Quick Links
                        </h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('dashboard') }}" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Dashboard</a></li>
                            <li><a href="{{ route('loan-requests.index') }}" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Loan Requests</a></li>
                            <li><a href="{{ route('helpdesk-tickets.index') }}" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Helpdesk</a></li>
                            <li><a href="{{ route('equipment.index') }}" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Equipment</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="col-span-4 tablet:col-span-2 desktop:col-span-2">
                        <h3 class="myds-heading text-heading-4xs font-medium text-txt-black-900 mb-3">
                            Support
                        </h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Help Center</a></li>
                            <li><a href="#" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Contact Us</a></li>
                            <li><a href="#" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Privacy Policy</a></li>
                            <li><a href="#" class="text-body-sm text-txt-black-700 hover:text-primary-600 myds-hover-underline">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="border-t border-otl-gray-200 pt-6 mt-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <p class="text-body-xs text-txt-black-500">
                            © {{ date('Y') }} Government of Malaysia. Built with
                            <a href="https://myds.malaysia.gov.my/" class="text-primary-600 hover:text-primary-700 myds-hover-underline" target="_blank" rel="noopener">
                                Malaysia Government Design System (MYDS)
                            </a>
                        </p>
                        <div class="mt-4 md:mt-0 flex items-center space-x-4">
                            <button type="button"
                                    data-theme-toggle
                                    class="text-body-xs text-txt-black-500 hover:text-txt-black-700">
                                <span data-theme-text>Toggle Mode</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- MYDS Toast Container (Managed by toast-manager.js module) -->
    <!-- This container will be automatically created and managed by the toast-manager module -->

    @livewireScripts

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
