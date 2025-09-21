<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  x-data="themeManager()"
  x-bind:class="{ 'dark': isDark }"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta
      name="description"
      content="{{ $metaDescription ?? 'iServe - ICT Equipment Management System for Government Agencies' }}"
    />
    <meta
      name="keywords"
      content="ICT, Equipment, Management, Government, Malaysia, MYDS"
    />
    <meta name="theme-color" content="#FFFFFF" id="theme-color" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta
      property="og:title"
      content="{{ $title ?? 'iServe' }} - ICT Equipment Management"
    />
    <meta
      property="og:description"
      content="{{ $metaDescription ?? 'ICT Equipment Management System for Government Agencies' }}"
    />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta
      property="twitter:title"
      content="{{ $title ?? 'iServe' }} - ICT Equipment Management"
    />
    <meta
      property="twitter:description"
      content="{{ $metaDescription ?? 'ICT Equipment Management System for Government Agencies' }}"
    />

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

    <!-- MYDS Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />

    <!-- Styles -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/theme.js'])

    <!-- Theme Prevention Script (Prevent FOUC) -->
            <!-- Theme prevention script loaded before DOM for FOUC prevention -->
        @vite('resources/js/shared/theme-prevention.js')
  </head>

  <body
    class="font-sans bg-white text-gray-900 antialiased transition-colors duration-200"
  >
    <!-- MYDS Skip Link for Accessibility -->
    <x-myds.skip-link href="#main-content">Skip to main content</x-myds.skip-link>

    <!-- MYDS Phase Banner (if needed) -->
    @if (isset($phaseBanner))
      <div class="bg-primary-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
          <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
              {{ $phaseBanner['phase'] ?? 'BETA' }}
            </span>
            <p class="text-sm text-gray-700">
              {{ $phaseBanner['description'] ?? 'This is a new service – your feedback will help us to improve it.' }}
            </p>
            @if (isset($phaseBanner['feedbackUrl']))
              <a
                href="{{ $phaseBanner['feedbackUrl'] }}"
                class="text-sm text-primary-600 hover:text-primary-700 underline"
              >
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
      <header
        class="bg-white border-b border-gray-200 sticky top-0 z-40"
      >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Top Bar with Logo and Controls -->
          <div class="flex items-center justify-between py-4">
            <!-- Logo and Title -->
            <div class="flex items-center space-x-4">
              <!-- Government Logo -->
              <div class="flex-shrink-0">
                <img
                  src="{{ asset('images/jata-negara.svg') }}"
                  alt="Jata Negara Malaysia"
                  class="h-10 w-auto"
                />
              </div>

              <!-- Site Title -->
              <div class="border-l border-gray-300 pl-4">
                <h1
                  class="text-lg font-medium text-gray-900"
                >
                  <a
                    href="{{ route('dashboard') }}"
                    class="hover:text-primary-600 transition-colors"
                  >
                    iServe
                  </a>
                </h1>
                <p class="text-sm text-gray-500">
                  ICT Equipment Management
                </p>
              </div>
            </div>

            <!-- Header Controls -->
            <div class="flex items-center space-x-3">
              <!-- Theme Switcher -->
              <x-myds.theme-switcher />

              <!-- User Menu -->
              @auth
                <div class="relative" x-data="{ open: false }">
                  <x-myds.button
                    id="user-menu-button"
                    type="button"
                    x-on:click="open = !open"
                    x-on:click.away="open = false"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-bg-washed transition-colors"
                    :aria-expanded="open"
                    aria-haspopup="true"
                    aria-controls="user-menu"
                    :size="'md'"
                  >
                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                      <span class="text-white text-body-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>

                    <div class="hidden md:block text-left">
                      <p class="text-body-sm font-medium text-txt-black-900">{{ auth()->user()->name }}</p>
                      <p class="text-body-xs text-txt-black-500">{{ auth()->user()->email }}</p>
                    </div>

                    <x-myds.icon name="chevron-down" class="w-4 h-4 text-txt-black-400" />
                  </x-myds.button>

                  <!-- User Dropdown -->
                  <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    id="user-menu"
                    role="menu"
                    aria-labelledby="user-menu-button"
                    class="absolute right-0 mt-2 w-48 bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu z-50"
                  >
                    <div class="py-2">
                      <x-myds.button
                        as="a"
                        href="{{ route('profile.index') }}"
                        role="menuitem"
                        tabindex="0"
                        variant="tertiary"
                        size="sm"
                        class="w-full text-left px-4 py-2"
                      >
                        Profile Settings
                      </x-myds.button>
                      <hr class="border-otl-gray-200 my-1" />
                      <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="block"
                      >
                        @csrf
                        <x-myds.button type="submit" variant="danger" class="w-full text-left px-4 py-2" aria-label="Sign out">
                          Sign Out
                        </x-myds.button>
                      </form>
                    </div>
                  </div>
                </div>
              @else
                <div class="flex items-center space-x-2">
                  <x-myds.button href="{{ route('login') }}" variant="secondary" size="sm">Sign In</x-myds.button>
                  <x-myds.button href="{{ route('register') }}" variant="primary" size="sm">Register</x-myds.button>
                </div>
              @endauth
            </div>
          </div>

          <!-- Navigation Bar -->
          @auth
            @include('layouts.navigation')
          @endauth
        </div>
      </header>

      <!-- MYDS Main Content Area -->
      <main class="flex-1 bg-gray-50" id="main-content">
        <!-- Page Header (if provided) -->
        @if (isset($pageTitle) || isset($breadcrumbs) || isset($header))
          <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
              <!-- Breadcrumbs -->
              @if (isset($breadcrumbs))
                <nav class="mb-4" aria-label="Breadcrumb">
                  <ol class="flex items-center space-x-2 text-sm">
                    @foreach ($breadcrumbs as $breadcrumb)
                      <li class="flex items-center">
                        @if (! $loop->first)
                          <x-myds.icon name="chevron-right" class="w-3 h-3 text-gray-400 mx-2" />
                        @endif

                        @if ($loop->last)
                          <span class="text-txt-black-500">
                            {{ $breadcrumb['label'] }}
                          </span>
                        @else
                          <a
                            href="{{ $breadcrumb['url'] }}"
                            class="text-primary-600 hover:text-primary-700 myds-hover-underline"
                          >
                            {{ $breadcrumb['label'] }}
                          </a>
                        @endif
                      </li>
                    @endforeach
                  </ol>
                </nav>
              @endif

              <!-- Page Title -->
              @if (isset($pageTitle))
                <div class="flex items-center justify-between">
                  <div>
                    <h1
                      class="myds-heading text-heading-md font-semibold text-txt-black-900"
                    >
                      {{ $pageTitle }}
                    </h1>
                    @if (isset($pageDescription))
                      <p class="mt-2 text-body-base text-txt-black-700">
                        {{ $pageDescription }}
                      </p>
                    @endif
                  </div>

                  <!-- Page Actions -->
                  @if (isset($pageActions))
                    <div class="flex items-center space-x-3">
                      {!! $pageActions !!}
                    </div>
                  @endif
                </div>
              @elseif (isset($header))
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                  {{ $header }}
                </div>
              @endif
            </div>
          </div>
        @endif

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          @hasSection('content')
            @yield('content')
          @else
            {{ $slot ?? '' }}
          @endif
        </div>
      </main>

      <!-- MYDS Footer -->
      <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div class="grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12 gap-6">
            <!-- Footer Content -->
            <div class="col-span-4 md:col-span-6 lg:col-span-8">
              <div class="flex items-center space-x-4 mb-4">
                <img
                  src="{{ asset('images/jata-negara.svg') }}"
                  alt="Jata Negara Malaysia"
                  class="h-8 w-auto"
                />
                <div>
                  <h3
                    class="text-base font-medium text-gray-900"
                  >
                    iServe - ICT Equipment Management
                  </h3>
                  <p class="text-sm text-gray-500">
                    Government of Malaysia
                  </p>
                </div>
              </div>
              <p class="text-sm text-gray-700 mb-4">
                Comprehensive ICT equipment and helpdesk management system
                designed for government agencies, built following Malaysia
                Government Design System (MYDS) standards.
              </p>
            </div>

            <!-- Quick Links -->
            <div class="col-span-4 md:col-span-2 lg:col-span-2">
              <h3
                class="text-sm font-medium text-gray-900 mb-3"
              >
                Quick Links
              </h3>
              <ul class="space-y-2">
                <li>
                  <a
                    href="{{ route('dashboard') }}"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Dashboard
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('loan.index') }}"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Loan Requests
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('helpdesk.index') }}"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Helpdesk
                  </a>
                </li>
                <li>
                  <a
                    href="{{ route('equipment.index') }}"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Equipment
                  </a>
                </li>
              </ul>
            </div>

            <!-- Support -->
            <div class="col-span-4 md:col-span-2 lg:col-span-2">
              <h3
                class="text-sm font-medium text-gray-900 mb-3"
              >
                Support
              </h3>
              <ul class="space-y-2">
                <li>
                  <a
                    href="#"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Help Center
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Contact Us
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Privacy Policy
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="text-sm text-gray-700 hover:text-primary-600 underline"
                  >
                    Terms of Service
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Footer Bottom -->
          <div class="border-t border-gray-200 pt-6 mt-8">
            <div
              class="flex flex-col md:flex-row md:items-center md:justify-between"
            >
              <p class="text-xs text-gray-500">
                © {{ date('Y') }} Government of Malaysia. Built with
                <a
                  href="https://myds.malaysia.gov.my/"
                  class="text-primary-600 hover:text-primary-700 underline"
                  target="_blank"
                  rel="noopener"
                >
                  Malaysia Government Design System (MYDS)
                </a>
              </p>
              <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <x-myds.button
                  type="button"
                  variant="tertiary"
                  size="sm"
                  x-on:click="darkMode = ! darkMode; localStorage.setItem('darkMode', darkMode)"
                  class="text-body-xs text-txt-black-500 hover:text-txt-black-700"
                >
                  <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                </x-myds.button>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>

    <!-- Toast Container (for notifications) -->
    <div
      id="toast-container"
      class="fixed bottom-6 right-6 space-y-3 z-50 pointer-events-none"
      x-data="toastManager()"
    >
      <template x-for="toast in toasts" :key="toast.id">
        <div
          x-show="toast.visible"
          x-transition:enter="toast-enter"
          x-transition:leave="toast-exit"
          class="pointer-events-auto max-w-sm w-full bg-bg-white-0 border border-otl-gray-200 rounded-lg shadow-context-menu overflow-hidden"
          :class="{
                     'border-l-4 border-l-primary-600': toast.type === 'info',
                     'border-l-4 border-l-success-600': toast.type === 'success',
                     'border-l-4 border-l-warning-600': toast.type === 'warning',
                     'border-l-4 border-l-danger-600': toast.type === 'error'
                 }"
        >
          <div class="p-4">
            <div class="flex items-start">
              <!-- Icon -->
              <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                  <x-myds.icon name="check-circle" class="w-5 h-5 text-success-600" aria-hidden="true" />
                </template>
                <template x-if="toast.type === 'error'">
                  <x-myds.icon name="x-circle" class="w-5 h-5 text-danger-600" aria-hidden="true" />
                </template>
                <template x-if="toast.type === 'warning'">
                  <x-myds.icon name="alert-triangle" class="w-5 h-5 text-warning-600" aria-hidden="true" />
                </template>
                <template x-if="toast.type === 'info'">
                  <x-myds.icon name="info" class="w-5 h-5 text-primary-600" aria-hidden="true" />
                </template>
              </div>
                <a
                  href="https://myds.malaysia.gov.my/"
                  class="text-primary-600 hover:text-primary-700 underline"
                  target="_blank"
                  rel="noopener noreferrer"
                >
                  Malaysia Government Design System (MYDS)
                </a>
                  class="mt-1 text-body-sm text-txt-black-700"
                  x-text="toast.message"
                ></p>
              </div>

              <!-- Close Button -->
              <button
                type="button"
                x-on:click="removeToast(toast.id)"
                class="ml-4 flex-shrink-0 text-txt-black-400 hover:text-txt-black-600"
                aria-label="Close notification"
              >
                <x-myds.icon name="x" class="w-4 h-4" aria-hidden="true" />
              </button>
            </div>
          </div>

          <!-- Progress Bar -->
          <div x-show="toast.progress" class="h-1 bg-bg-white-100">
            <div
              class="h-full progress-bar-countdown"
              :class="{
                             'bg-primary-600': toast.type === 'info',
                             'bg-success-600': toast.type === 'success',
                             'bg-warning-600': toast.type === 'warning',
                             'bg-danger-600': toast.type === 'error'
                         }"
            ></div>
          </div>
        </div>
      </template>
    </div>

    <!-- Shared layout stores and toast system -->
    @vite('resources/js/shared/layout-stores.js')
    @vite('resources/js/shared/toast-manager.js')
    @vite('resources/js/shared/modal-focus-trap.js')

    <!-- Accessibility skip links -->
    @vite('resources/css/shared/skip-links.css')

    @livewireScripts

    <!-- Additional Scripts -->
    @stack('scripts')
  </body>
</html>
