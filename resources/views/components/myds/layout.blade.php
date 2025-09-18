{{--
  MYDS Layout Component for ICTServe (iServe)
  - Applies MYDS 12/8/4 responsive grid, spacing, and bg tokens
  - Ensures accessible structure, skip link, logical hierarchy (MyGovEA)
  - Usage: Wraps page content, header, footer, and slot for main
  - Slots:
      header: App header/navigation (e.g., <x-myds.header />)
      main: Main content (should have id="main-content")
      footer: App footer (e.g., <x-myds.footer />)
      sidebar: (optional) Left nav/aside for dashboard or apps
--}}

@props([
  'title' => null,
  'class' => '',
])

<!DOCTYPE html>
<html lang="ms" class="scroll-smooth bg-bg-washed">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ? $title . ' | ' : '' }}ICTServe (iServe)</title>
    <meta name="theme-color" content="#2563EB" />
    {{-- MYDS: Poppins & Inter fonts, favicon, and MYDS tokens --}}
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,500,600&display=swap" />
    <x-myds.tokens />
    {{-- Add custom styles if needed --}}
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-bg-washed txt-black-900 antialiased">
    {{-- MYDS Skip Link for accessibility --}}
    <a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 bg-white shadow-context-menu z-50 px-4 py-2 txt-black-900 radius-m transition"
        tabindex="0"
    >
        Lompat ke kandungan utama
    </a>
    {{-- MYDS Header (masthead/navigation) --}}
    @isset($header)
      {{ $header }}
    @else
      @hasSection('header')
        @yield('header')
      @endif
    @endisset

    {{-- Optional sidebar (for dashboard layouts) --}}
    @isset($sidebar)
      <aside class="hidden md:block bg-bg-contrast border-r border-otl-divider min-w-[220px] max-w-xs">
        {{ $sidebar }}
      </aside>
    @endisset

    {{-- Main Content --}}
    <main id="main-content" tabindex="-1" class="flex-1 w-full mx-auto max-w-[1280px] px-4 md:px-6 py-8 {{ $class }}">
        {{ $main ?? $slot }}
    </main>

    {{-- MYDS Footer --}}
    @isset($footer)
      {{ $footer }}
    @else
      @hasSection('footer')
        @yield('footer')
      @endif
    @endisset

    {{-- Scripts --}}
    @stack('scripts')
</body>
</html>
