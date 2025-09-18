<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="themeManager()"
      x-bind:class="{ 'dark': isDark }"
      class="scroll-smooth bg-bg-white text-txt-black-900 antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF" id="theme-color">

    <title>
        {{ isset($title) ? $title.' - '.config('app.name', 'ICTServe (iServe)') : config('app.name', 'ICTServe (iServe)') }}
    </title>

    {{-- Fonts: Inter for body, Poppins for headings --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- MYDS + Tailwind + App Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/theme.js'])

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/ictserve-icon.svg') }}">
</head>

<body class="myds-body bg-bg-white text-txt-black-900 antialiased min-h-screen"
      x-bind:class="{ 'dark': isDark }"
      style="font-family: var(--font-sans);">

    {{-- MYDS Skip Link for Accessibility --}}
    <a href="#main-content"
       class="myds-skip-link focus-visible:not-sr-only"
       tabindex="0">
        Skip to main content
    </a>

    {{-- Masthead/Header Slot (optional) --}}
    @hasSection('masthead')
        @yield('masthead')
    @endif

    {{-- Sidebar Slot (optional) --}}
    @hasSection('sidebar')
        @yield('sidebar')
    @endif

    {{-- Main Application Layout Grid --}}
    <div class="flex flex-col min-h-screen bg-bg-white-0">
        {{-- Top Bar (optional, recommended for ICTServe) --}}
        @hasSection('top-bar')
            @yield('top-bar')
        @endif

        {{-- Main Content Container --}}
        <main id="main-content"
              tabindex="-1"
              class="flex-1 myds-container py-6 sm:py-8 md:py-10"
              aria-label="Kandungan utama">
            {{ $slot }}
        </main>
    </div>

    {{-- Footer Slot (optional) --}}
    @hasSection('footer')
        @yield('footer')
    @endif

    {{-- Livewire Scripts --}}
    @livewireScripts

    {{-- Stacked JS and Alpine Components --}}
    @stack('scripts')
    @stack('modals')
    @stack('toast-container')

    {{-- MYDS Accessibility: Announce theme changes for screen readers --}}
    <div id="theme-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>
</body>
</html>
