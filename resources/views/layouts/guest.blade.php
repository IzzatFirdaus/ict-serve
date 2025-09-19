<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts: MYDS typography (Inter for body, Poppins for headings) -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap"
      rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="font-sans text-txt-black-900 antialiased">
    <!-- Skip to main content link for screen readers -->
    <a href="#main-content" class="myds-skip-link">Skip to main content</a>

    <div
      class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-bg-black-100"
    >
      <header role="banner">
        <a href="/" aria-label="Go to homepage">
          <x-application-logo
            class="w-20 h-20 fill-current text-txt-black-500"
          />
        </a>
      </header>

      <div
        id="main-content"
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-bg-white shadow-md overflow-hidden sm:rounded-lg"
      >
        {{ $slot }}
      </div>
    </div>
  </body>
</html>
