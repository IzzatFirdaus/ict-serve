<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    <!-- Fonts (Inter + Poppins) -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Vite assets (app styles + scripts) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @hasSection('page-style')
      @yield('page-style')
    @endif
  </head>
  <body class="font-sans text-txt-black-900 antialiased bg-bg-white">
    <main id="main-content" role="main">
      @yield('content')
    </main>

    @livewireScripts
  </body>
</html>
