<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'ICT Serve - Public Services')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100..900&display=swap"
      rel="stylesheet"
    />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional head content -->
    @stack('head')
  </head>
  <body class="bg-gray-50 font-sans antialiased">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <!-- Logo and Title -->
          <div class="flex items-center">
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
              <!-- Malaysian Government Emblem or ICT Logo -->
              <div
                class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center"
              >
                <svg
                  class="w-8 h-8 text-white"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"
                  />
                </svg>
              </div>
              <div>
                <h1 class="text-xl font-bold text-primary-700">ICT Serve</h1>
                <p class="text-xs text-gray-600">
                  {{ __('Public Services Portal') }}
                </p>
              </div>
            </a>
          </div>

          <!-- Navigation Links -->
          <nav class="hidden md:flex items-center space-x-6">
            <a
              href="{{ url('/') }}"
              class="text-gray-600 hover:text-primary-600 transition-colors duration-200 {{ request()->is('/') ? 'text-primary-600 font-medium' : '' }}"
            >
              {{ __('Home') }}
            </a>
            <a
              href="{{ route('public.loan-requests.create') }}"
              class="text-gray-600 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('public.loan-requests.*') ? 'text-primary-600 font-medium' : '' }}"
            >
              {{ __('Equipment Loan') }}
            </a>
            <a
              href="{{ route('public.helpdesk.create') }}"
              class="text-gray-600 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('public.helpdesk.*') ? 'text-primary-600 font-medium' : '' }}"
            >
              {{ __('Report Issue') }}
            </a>
            <a
              href="{{ route('public.track') }}"
              class="text-gray-600 hover:text-primary-600 transition-colors duration-200 {{ request()->routeIs('public.track*') ? 'text-primary-600 font-medium' : '' }}"
            >
              {{ __('Track Status') }}
            </a>
          </nav>

          <!-- Language Switcher and Mobile Menu -->
          <div class="flex items-center space-x-4">
            <!-- Language Switcher -->
            <div class="relative">
              <select
                class="text-sm border border-gray-300 rounded-md px-3 py-1 bg-white focus:outline-none focus:ring-2 focus:ring-primary-500"
              >
                <option
                  value="en"
                  {{ app()->getLocale() === 'en' ? 'selected' : '' }}
                >
                  EN
                </option>
                <option
                  value="ms"
                  {{ app()->getLocale() === 'ms' ? 'selected' : '' }}
                >
                  MS
                </option>
              </select>
            </div>

            <!-- Mobile Menu Button -->
            <button
              type="button"
              class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
              id="mobile-menu-button"
            >
              <span class="sr-only">{{ __('Open main menu') }}</span>
              <svg
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
          <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
            <a
              href="{{ url('/') }}"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 {{ request()->is('/') ? 'text-primary-600 bg-primary-50' : '' }}"
            >
              {{ __('Home') }}
            </a>
            <a
              href="{{ route('public.loan-requests.create') }}"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 {{ request()->routeIs('public.loan-requests.*') ? 'text-primary-600 bg-primary-50' : '' }}"
            >
              {{ __('Equipment Loan') }}
            </a>
            <a
              href="{{ route('public.helpdesk.create') }}"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 {{ request()->routeIs('public.helpdesk.*') ? 'text-primary-600 bg-primary-50' : '' }}"
            >
              {{ __('Report Issue') }}
            </a>
            <a
              href="{{ route('public.track') }}"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 {{ request()->routeIs('public.track*') ? 'text-primary-600 bg-primary-50' : '' }}"
            >
              {{ __('Track Status') }}
            </a>
          </div>
        </div>
      </div>
    </header>

    <!-- Flash Messages -->
    @if (session('success'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <x-alert type="success" dismissible>
          {{ session('success') }}
        </x-alert>
      </div>
    @endif

    @if (session('error'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <x-alert type="danger" dismissible>
          {{ session('error') }}
        </x-alert>
      </div>
    @endif

    @if (session('warning'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <x-alert type="warning" dismissible>
          {{ session('warning') }}
        </x-alert>
      </div>
    @endif

    @if (session('info'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <x-alert type="info" dismissible>
          {{ session('info') }}
        </x-alert>
      </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Organization Info -->
          <div>
            <h3 class="text-lg font-semibold mb-4">
              {{ __('ICT Department') }}
            </h3>
            <p class="text-gray-300 text-sm mb-4">
              {{ __('Providing reliable ICT services and support for efficient government operations and public service delivery.') }}
            </p>
            <div class="flex space-x-4">
              <a
                href="#"
                class="text-gray-400 hover:text-white transition-colors duration-200"
              >
                <span class="sr-only">{{ __('Facebook') }}</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                  />
                </svg>
              </a>
              <a
                href="#"
                class="text-gray-400 hover:text-white transition-colors duration-200"
              >
                <span class="sr-only">{{ __('Twitter') }}</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                  />
                </svg>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h3 class="text-lg font-semibold mb-4">{{ __('Quick Links') }}</h3>
            <ul class="space-y-2 text-sm">
              <li>
                <a
                  href="{{ route('public.loan-requests.create') }}"
                  class="text-gray-300 hover:text-white transition-colors duration-200"
                >
                  {{ __('Equipment Loan Request') }}
                </a>
              </li>
              <li>
                <a
                  href="{{ route('public.helpdesk.create') }}"
                  class="text-gray-300 hover:text-white transition-colors duration-200"
                >
                  {{ __('Report ICT Issue') }}
                </a>
              </li>
              <li>
                <a
                  href="{{ route('public.track') }}"
                  class="text-gray-300 hover:text-white transition-colors duration-200"
                >
                  {{ __('Track Request Status') }}
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-gray-300 hover:text-white transition-colors duration-200"
                >
                  {{ __('Privacy Policy') }}
                </a>
              </li>
              <li>
                <a
                  href="#"
                  class="text-gray-300 hover:text-white transition-colors duration-200"
                >
                  {{ __('Terms of Service') }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Contact Info -->
          <div>
            <h3 class="text-lg font-semibold mb-4">
              {{ __('Contact Information') }}
            </h3>
            <div class="space-y-2 text-sm text-gray-300">
              <p>
                <span class="font-medium">{{ __('Address:') }}</span>
                <br />
                {{ __('ICT Department, Ground Floor') }}
                <br />
                {{ __('Block A, Government Complex') }}
                <br />
                {{ __('Federal Territory of Putrajaya') }}
              </p>
              <p>
                <span class="font-medium">{{ __('Email:') }}</span>
                <br />
                <a
                  href="mailto:ict-support@example.gov.my"
                  class="hover:text-white transition-colors duration-200"
                >
                  ict-support@example.gov.my
                </a>
              </p>
              <p>
                <span class="font-medium">{{ __('Phone:') }}</span>
                <br />
                <a
                  href="tel:+603xxxxxxxx"
                  class="hover:text-white transition-colors duration-200"
                >
                  +60 3-xxxx xxxx
                </a>
              </p>
              <p>
                <span class="font-medium">{{ __('Emergency Hotline:') }}</span>
                <br />
                <a
                  href="tel:+603yyyyyyyy"
                  class="hover:text-white transition-colors duration-200"
                >
                  +60 3-yyyy yyyy (24/7)
                </a>
              </p>
              <p>
                <span class="font-medium">{{ __('Office Hours:') }}</span>
                <br />
                {{ __('Monday - Friday: 8:00 AM - 5:00 PM') }}
              </p>
            </div>
          </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-700 mt-8 pt-8">
          <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-gray-300">
              <p>
                &copy; {{ date('Y') }}
                {{ __('Government of Malaysia. All rights reserved.') }}
              </p>
            </div>
            <div class="flex items-center mt-4 md:mt-0">
              <p class="text-sm text-gray-300 mr-4">
                {{ __('Powered by ICT Serve v2.0') }}
              </p>
              <img
                src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMTMuMDkgOC4yNkwyMCA5TDEzLjA5IDE1Ljc0TDEyIDIyTDEwLjkxIDE1Ljc0TDQgOUwxMC45MSA4LjI2TDEyIDJaIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgZmlsbD0ibm9uZSIvPgo8L3N2Zz4K"
                alt="{{ __('Malaysia Digital Government Initiative') }}"
                class="h-6 w-6"
              />
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    @vite(['resources/js/layouts/public.js'])

    <!-- Additional scripts -->
    @stack('scripts')
  </body>
</html>
