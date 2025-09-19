<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
      {{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}

    </title>

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>
  <body class="h-full bg-gray-50 font-sans antialiased">
    <!-- MYDS Header Component -->
    <header class="bg-white border-b border-gray-200">
      <div class="max-w-7xl mx-auto">
        <!-- Top Bar with Government Branding -->
        <div class="bg-gray-900 text-white py-2">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-sm">
              <div class="flex items-center gap-4">
                <span class="flex items-center gap-2">
                  <img
                    src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
                    alt="Jata Negara"
                    class="w-4 h-4"
                  />
                  Official Malaysian Government Website
                </span>
              </div>
              <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center gap-2">
                  <a
                    href="{{ route('language.switch', 'en') }}"
                    class="hover:text-blue-300 transition-colors {{ app()->getLocale() === 'en' ? 'text-blue-300' : '' }}"
                  >
                    English
                  </a>
                  <span class="text-gray-400">|</span>
                  <a
                    href="{{ route('language.switch', 'ms') }}"
                    class="hover:text-blue-300 transition-colors {{ app()->getLocale() === 'ms' ? 'text-blue-300' : '' }}"
                  >
                    Bahasa Malaysia
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Navigation -->
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <!-- Logo and Ministry Branding -->
            <div class="flex items-center">
              <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3"
              >
                <img
                  src="{{ asset('images/motac-logo.png') }}"
                  alt="MOTAC Logo"
                  class="w-10 h-10"
                />
                <div>
                  <h1 class="text-xl font-semibold text-gray-900">
                    iServe System
                  </h1>
                  <p class="text-sm text-gray-600">
                    Ministry of Tourism, Arts and Culture
                  </p>
                </div>
              </a>
            </div>

            <!-- Main Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
              <a
                href="{{ route('dashboard') }}"
                class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}"
              >
                Dashboard
              </a>
              <a
                href="{{ route('loan.index') }}"
                class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('loan.*') ? 'text-blue-600' : '' }}"
              >
                ICT Loan
              </a>
              <a
                href="{{ route('helpdesk.index') }}"
                class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('helpdesk.*') ? 'text-blue-600' : '' }}"
              >
                Helpdesk
              </a>
              <a
                href="{{ route('equipment.index') }}"
                class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('equipment.*') ? 'text-blue-600' : '' }}"
              >
                Equipment
              </a>
              @auth
                @if (auth()->user()->isIctAdmin() ||auth()->user()->isSuperAdmin())
                  <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-gray-700 hover:text-blue-600 font-medium transition-colors {{ request()->routeIs('admin.*') ? 'text-blue-600' : '' }}"
                  >
                    Admin
                  </a>
                @endif
              @endauth
            </nav>

            <!-- User Menu -->
            <div class="flex items-center gap-4">
              @auth
                <!-- Notifications -->
                <a
                  href="{{ route('notifications.index') }}"
                  class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 17h5l-5-5V9a6 6 0 10-12 0v3l-5 5h5a3 3 0 106 0z"
                    ></path>
                  </svg>
                  @if (auth()->user()->unreadNotifications->count() > 0)
                    <span
                      class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
                    >
                      {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                  @endif
                </a>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                  <button
                    @click="open = !open"
                    class="flex items-center gap-2 p-2 text-gray-700 hover:text-gray-900 transition-colors"
                  >
                    <div
                      class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center"
                    >
                      {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="hidden md:block font-medium">
                      {{ auth()->user()->name }}
                    </span>
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                      ></path>
                    </svg>
                  </button>

                  <div
                    x-show="open"
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-50"
                  >
                    <div class="py-1">
                      <div
                        class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100"
                      >
                        {{ auth()->user()->position }}
                      </div>
                      <a
                        href="{{ route('profile.index') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                      >
                        Profile
                      </a>
                      <a
                        href="{{ route('notifications.index') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                      >
                        Notifications
                      </a>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                          type="submit"
                          class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                        >
                          Sign Out
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              @else
                <a
                  href="{{ route('login') }}"
                  class="text-gray-700 hover:text-blue-600 font-medium transition-colors"
                >
                  Sign In
                </a>
                <x-myds.button variant="primary" href="{{ route('register') }}">
                  Get Started
                </x-myds.button>
              @endauth

              <!-- Mobile Menu Button -->
              <button
                x-data
                x-on:click="$dispatch('toggle-mobile-menu')"
                class="md:hidden p-2 text-gray-400 hover:text-gray-600 transition-colors"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  ></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
      @if (isset($breadcrumbs))
        <div class="bg-white border-b border-gray-200">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
              <ol class="flex items-center space-x-4">
                @foreach ($breadcrumbs as $index => $breadcrumb)
                  <li class="flex">
                    @if (! $loop->last)
                      <a
                        href="{{ $breadcrumb['url'] }}"
                        class="text-gray-500 hover:text-gray-700 transition-colors"
                      >
                        {{ $breadcrumb['title'] }}
                      </a>
                      @if (! $loop->last)
                        <svg
                          class="flex-shrink-0 ml-4 w-4 h-4 text-gray-300"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      @endif
                    @else
                      <span class="text-gray-900 font-medium">
                        {{ $breadcrumb['title'] }}
                      </span>
                    @endif
                  </li>
                @endforeach
              </ol>
            </nav>
          </div>
        </div>
      @endif

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
      </div>
    </main>

    <!-- MYDS Footer Component -->
    <footer class="bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-12">
          <!-- Grid System: 12-8-4 -->
          <div class="grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12 gap-6">
            <!-- Logo and Ministry Info -->
            <div class="col-span-4 lg:col-span-4">
              <div class="flex items-center gap-3 mb-4">
                <img
                  src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
                  alt="Jata Negara"
                  class="w-8 h-8"
                />
                <div>
                  <h3 class="font-semibold">
                    Ministry of Tourism, Arts and Culture
                  </h3>
                </div>
              </div>
              <p class="text-gray-300 text-sm mb-4">
                Driving digital transformation in Malaysian tourism, arts, and
                culture through innovative ICT solutions.
              </p>
              <div class="text-sm text-gray-400">
                <p>Level 28, Menara Bangkok Bank</p>
                <p>Berjaya Central Park, KL 50088</p>
                <p>Phone: +60 3-2161 2008</p>
              </div>
            </div>

            <!-- Quick Links -->
            <div class="col-span-2 lg:col-span-2">
              <h4 class="font-semibold mb-4">Quick Links</h4>
              <ul class="space-y-2 text-sm text-gray-300">
                <li>
                  <a
                    href="{{ route('dashboard') }}"
                    class="hover:text-white transition-colors"
                  >
                    Dashboard
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('loan.create') }}"
                    class="hover:text-white transition-colors"
                  >
                    Request ICT Loan
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('helpdesk.create') }}"
                    class="hover:text-white transition-colors"
                  >
                    Report Issue
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    Track Status
                  </a>
                </li>
              </ul>
            </div>

            <!-- Support -->
            <div class="col-span-2 lg:col-span-3">
              <h4 class="font-semibold mb-4">Support</h4>
              <ul class="space-y-2 text-sm text-gray-300">
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    User Guide
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">FAQ</a>
                </li>
                <li>
                  <a
                    href="{{ route('helpdesk.create') }}"
                    class="hover:text-white transition-colors"
                  >
                    Contact Support
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    System Status
                  </a>
                </li>
              </ul>
            </div>

            <!-- Ministry Links -->
            <div class="col-span-4 lg:col-span-3">
              <h4 class="font-semibold mb-4">Ministry Resources</h4>
              <ul class="space-y-2 text-sm text-gray-300">
                <li>
                  <a
                    href="https://motac.gov.my"
                    target="_blank"
                    class="hover:text-white transition-colors"
                  >
                    Official Website
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    Digital Policy
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    Privacy Policy
                  </a>
                </li>
                <li>
                  <a href="#" class="hover:text-white transition-colors">
                    Accessibility Statement
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Copyright Bar -->
        <div class="border-t border-gray-800 py-6">
          <div
            class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400"
          >
            <div class="flex items-center gap-4 mb-4 md:mb-0">
              <p>
                &copy; {{ date('Y') }} Ministry of Tourism, Arts and Culture
                Malaysia. All rights reserved.
              </p>
            </div>
            <div class="flex items-center gap-4">
              <span>Powered by MYDS</span>
              <a
                href="https://design.digital.gov.my"
                target="_blank"
                class="hover:text-white transition-colors"
              >
                Malaysia Government Design System
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    @livewireScripts

    <!-- Alpine.js for interactive components -->
    <script
      defer
      src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <!-- Toast Notifications -->
    @if (session()->has('message') || session()->has('error') || session()->has('success') || session()->has('warning'))
      <div
        x-data="{
          show: true,
          message:
            '{{ session('message') ?? (session('error') ?? (session('success') ?? session('warning'))) }}',
          type: '{{ session()->has('error') ? 'error' : (session()->has('success') ? 'success' : (session()->has('warning') ? 'warning' : 'info')) }}',
        }"
        x-show="show"
        x-init="setTimeout(() => (show = false), 5000)"
        x-transition.opacity.duration.500ms
        class="fixed bottom-4 right-4 z-50"
      >
        <div
          :class="{
                'bg-green-50 border-green-200 text-green-800': type === 'success',
                'bg-red-50 border-red-200 text-red-800': type === 'error',
                'bg-yellow-50 border-yellow-200 text-yellow-800': type === 'warning',
                'bg-blue-50 border-blue-200 text-blue-800': type === 'info'
            }"
          class="max-w-sm p-4 rounded-lg border shadow-lg"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div
                :class="{
                            'text-green-600': type === 'success',
                            'text-red-600': type === 'error',
                            'text-yellow-600': type === 'warning',
                            'text-blue-600': type === 'info'
                        }"
                class="mr-3"
              >
                <!-- Success icon -->
                <svg
                  x-show="type === 'success'"
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <!-- Error icon -->
                <svg
                  x-show="type === 'error'"
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <!-- Warning icon -->
                <svg
                  x-show="type === 'warning'"
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <!-- Info icon -->
                <svg
                  x-show="type === 'info'"
                  class="w-5 h-5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </div>
              <p class="text-sm font-medium" x-text="message"></p>
            </div>
            <button
              @click="show = false"
              class="ml-4 text-gray-400 hover:text-gray-600 transition-colors"
            >
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                ></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    @endif
  </body>
</html>
