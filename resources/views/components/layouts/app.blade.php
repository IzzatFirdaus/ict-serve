<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeManager()" x-bind:class="{ 'dark': isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FFFFFF" id="theme-color">

    <title>{{ isset($title) ? $title.' - '.config('app.name', 'iServe') : config('app.name', 'iServe') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/theme.js'])
    @livewireStyles
</head>
<body class="myds-body bg-bg-white-0 text-txt-black-900 antialiased">
    <a href="#main-content" class="myds-skip-link myds-focus-visible">Skip to main content</a>
    <main id="main-content">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
