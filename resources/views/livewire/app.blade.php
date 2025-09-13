<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ICT Serve') }} - Sistem Perkhidmatan ICT MOTAC</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Meta tags for SEO and social sharing -->
    <meta name="description" content="Sistem Perkhidmatan ICT MOTAC - Platform bersepadu untuk peminjaman peralatan ICT dan pengurusan helpdesk">
    <meta name="keywords" content="MOTAC, ICT, peminjaman, helpdesk, peralatan, teknologi">
    <meta name="author" content="MOTAC ICT Department">

    <!-- Open Graph tags -->
    <meta property="og:title" content="ICT Serve (iServe) - MOTAC">
    <meta property="og:description" content="Sistem Perkhidmatan ICT MOTAC yang mengikuti garis panduan MyGOVEA">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ms_MY">

    <!-- PWA support -->
    <meta name="theme-color" content="#1e40af">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.json">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Skip Links for Accessibility -->
    <style>
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #1e40af;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
            font-size: 14px;
        }
        .skip-link:focus {
            top: 6px;
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased">
    <!-- Skip Links for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <a href="#navigation" class="skip-link">Skip to navigation</a>

    <div class="min-h-screen bg-slate-50">
        <!-- MYDS-styled Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                            <span class="text-white font-bold text-sm">M</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">
                                ICT Serve (iServe)
                            </h1>
                            <p class="text-sm text-gray-500">
                                Sistem Perkhidmatan ICT MOTAC
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">
                            Selamat datang, <strong>{{ $user->name }}</strong>
                        </span>
                        <button
                            wire:click="logout"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                            type="button"
                        >
                            Log Keluar
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav id="navigation" class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-8 overflow-x-auto py-4">
                    <button
                        wire:click="setCurrentView('dashboard')"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors {{ $currentView === 'dashboard' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}"
                        type="button"
                    >
                        <span class="text-lg">📊</span>
                        <span class="font-medium whitespace-nowrap">Dashboard</span>
                    </button>
                    <button
                        wire:click="setCurrentView('loan')"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors {{ $currentView === 'loan' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}"
                        type="button"
                    >
                        <span class="text-lg">💻</span>
                        <span class="font-medium whitespace-nowrap">Peminjaman</span>
                    </button>
                    <button
                        wire:click="setCurrentView('helpdesk')"
                        class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors {{ $currentView === 'helpdesk' ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}"
                        type="button"
                    >
                        <span class="text-lg">🎫</span>
                        <span class="font-medium whitespace-nowrap">Helpdesk</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if($currentView === 'dashboard')
                @livewire('dashboard')
            @elseif($currentView === 'loan')
                @livewire('loan.index')
            @elseif($currentView === 'helpdesk')
                @livewire('helpdesk.index')
            @endif
        </main>
    </div>

    @livewireScripts
</body>
</html>
