@props([
  'user' => null,
  'showNotifications' => true,
  'showLanguageToggle' => true,
])

@php
  $user = $user ?? Auth::user();
  $notificationCount = $user ? $user->unreadNotifications()->count() : 0;
@endphp

<header
  x-data="{
    notificationsOpen: false,
    profileOpen: false,
    searchOpen: false,
    currentLang: '{{ app()->getLocale() }}',

    toggleNotifications() {
      this.notificationsOpen = ! this.notificationsOpen
      if (this.notificationsOpen) this.profileOpen = false
    },

    toggleProfile() {
      this.profileOpen = ! this.profileOpen
      if (this.profileOpen) this.notificationsOpen = false
    },

    toggleSearch() {
      this.searchOpen = ! this.searchOpen
      if (this.searchOpen) this.$nextTick(() => $refs.mobileSearch?.focus())
    },

    switchLanguage(lang) {
      window.location.href = '{{ route('language.switch', '') }}/' + lang
    },
  }"
  @click.away="notificationsOpen = false; profileOpen = false"
  class="bg-bg-surface border-b border-otl-divider shadow-sm relative z-30"
  role="banner"
  {{ $attributes }}
>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      {{-- Left: Logo + Trigger --}}
      <div class="flex items-center">
        {{-- Mobile menu button --}}
        <button
          @click="$store.sidebar?.toggle()"
          class="lg:hidden p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
          aria-label="Buka menu"
        >
          <svg
            class="h-6 w-6"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M3 6h14M3 10h14M3 14h14"
            />
          </svg>
        </button>

        {{-- MOTAC / Product Branding --}}
        <div class="flex items-center ml-4 lg:ml-0">
          <img
            src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}"
            alt="Kementerian Pelancongan, Seni dan Budaya Malaysia"
            class="h-10 w-auto"
          />
          <div class="ml-3 hidden sm:block">
            <h1 class="text-lg font-semibold text-txt-primary font-heading">
              ICTServe
            </h1>
            <p class="text-xs text-txt-black-500">
              Sistem Pengurusan Perkhidmatan ICT
            </p>
          </div>
        </div>
      </div>

      {{-- Center: Search (Desktop placeholder area; replace with x-ictserve.search if needed) --}}
      <div class="flex-1 max-w-lg mx-8 hidden lg:block">
        <div class="relative">
          <div
            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
          >
            <svg
              class="h-5 w-5 text-txt-black-400"
              viewBox="0 0 20 20"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              aria-hidden="true"
            >
              <circle cx="8" cy="8" r="5"></circle>
              <path stroke-linecap="round" d="M12 12l4 4"></path>
            </svg>
          </div>
          <input
            type="search"
            placeholder="Cari permohonan, tiket, peralatan..."
            class="block w-full pl-10 pr-3 py-2 border border-otl-gray-300 rounded-md leading-5 bg-bg-white placeholder-txt-black-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus:border-otl-primary-300 text-sm"
            @keydown.escape="$event.target.blur()"
            aria-label="Carian utama"
          />
        </div>
      </div>

      {{-- Right: Actions --}}
      <div class="flex items-center space-x-2 sm:space-x-4">
        {{-- Search Button (Mobile) --}}
        <button
          @click="toggleSearch()"
          class="lg:hidden p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
          aria-label="Cari"
        >
          <svg
            class="h-6 w-6"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <circle cx="8" cy="8" r="5"></circle>
            <path stroke-linecap="round" d="M12 12l4 4"></path>
          </svg>
        </button>

        {{-- Language Toggle --}}
        @if ($showLanguageToggle)
          <div class="relative">
            <button
              @click="currentLang === 'ms' ? switchLanguage('en') : switchLanguage('ms')"
              class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
              :title="currentLang === 'ms' ? 'Switch to English' : 'Tukar ke Bahasa Melayu'"
              aria-label="Tukar bahasa"
            >
              <span
                class="text-sm font-medium"
                x-text="currentLang === 'ms' ? 'EN' : 'MS'"
              ></span>
            </button>
          </div>
        @endif

        {{-- Notifications --}}
        @if ($showNotifications && $user)
          <div class="relative">
            <button
              @click="toggleNotifications()"
              class="relative p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
              :class="{ 'text-txt-primary bg-primary-50': notificationsOpen }"
              aria-label="Notifikasi"
              :aria-expanded="notificationsOpen"
              aria-controls="notifications-dropdown"
            >
              <svg
                class="h-6 w-6"
                viewBox="0 0 20 20"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M10 3a6 6 0 00-6 6v2.159c0 .538-.214 1.055-.595 1.436L2.5 14h15l-.905-1.405A2.032 2.032 0 0116 11.159V9a6 6 0 00-6-6zM8 17a2 2 0 104 0"
                />
              </svg>
              @if ($notificationCount > 0)
                <span
                  class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-txt-white transform translate-x-1/2 -translate-y-1/2 bg-danger-600 rounded-full"
                >
                  {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                </span>
              @endif
            </button>

            {{-- Notifications Dropdown --}}
            <div
              x-show="notificationsOpen"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 mt-2 w-80 bg-bg-white rounded-md shadow-context-menu ring-1 ring-otl-divider z-50"
              x-cloak
              role="menu"
              id="notifications-dropdown"
              aria-label="Notifikasi"
            >
              <div class="p-4 border-b border-otl-divider">
                <h3 class="text-sm font-medium text-txt-black-900">
                  Notifikasi
                </h3>
              </div>
              <div class="max-h-96 overflow-y-auto">
                @forelse ($user->unreadNotifications->take(5) as $notification)
                  <div class="p-4 border-b border-otl-divider hover:bg-gray-50">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <div
                          class="h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center"
                        >
                          <svg
                            class="h-4 w-4 text-txt-primary"
                            viewBox="0 0 20 20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            aria-hidden="true"
                          >
                            <circle cx="10" cy="10" r="8"></circle>
                            <path stroke-linecap="round" d="M10 6v4m0 4h.01" />
                          </svg>
                        </div>
                      </div>
                      <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-txt-black-900">
                          {{ $notification->data['title'] ?? 'Notifikasi' }}
                        </p>
                        <p class="text-sm text-txt-black-500 mt-1">
                          {{ $notification->data['message'] ?? 'Tiada mesej' }}
                        </p>
                        <p class="text-xs text-txt-black-400 mt-1">
                          {{ $notification->created_at->diffForHumans() }}
                        </p>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="p-4 text-center">
                    <p class="text-sm text-txt-black-500">
                      Tiada notifikasi baharu
                    </p>
                  </div>
                @endforelse
              </div>
              <div class="p-4 border-t border-otl-divider">
                <a
                  href="{{ route('notifications.index') }}"
                  class="text-sm text-txt-primary hover:text-primary-700 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                >
                  Lihat semua notifikasi
                </a>
              </div>
            </div>
          </div>
        @endif

        {{-- Profile Dropdown --}}
        @if ($user)
          <div class="relative">
            <button
              @click="toggleProfile()"
              class="flex items-center text-sm rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
              :class="{ 'ring-2 ring-otl-primary-300': profileOpen }"
              aria-label="Menu profil"
              :aria-expanded="profileOpen"
              aria-controls="profile-dropdown"
            >
              <img
                class="h-8 w-8 rounded-full object-cover"
                src="{{ $user->avatar_url ?? asset('images/default-avatar.svg') }}"
                alt="{{ $user->name }}"
              />
            </button>

            {{-- Profile Dropdown --}}
            <div
              x-show="profileOpen"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute right-0 mt-2 w-64 bg-bg-white rounded-md shadow-context-menu ring-1 ring-otl-divider z-50"
              x-cloak
              role="menu"
              id="profile-dropdown"
              aria-label="Menu profil"
            >
              {{-- User Info --}}
              <div class="p-4 border-b border-otl-divider">
                <div class="flex items-center">
                  <img
                    class="h-10 w-10 rounded-full object-cover"
                    src="{{ $user->avatar_url ?? asset('images/default-avatar.svg') }}"
                    alt="{{ $user->name }}"
                  />
                  <div class="ml-3">
                    <p class="text-sm font-medium text-txt-black-900">
                      {{ $user->name }}
                    </p>
                    <p class="text-xs text-txt-black-500">
                      {{ $user->email }}
                    </p>
                    <p class="text-xs text-txt-black-400">
                      {{ $user->department ?? 'Tiada jabatan' }}
                    </p>
                  </div>
                </div>
              </div>

              {{-- Menu Items --}}
              <div class="py-1">
                <a
                  href="{{ route('profile.show') }}"
                  class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                  role="menuitem"
                >
                  <svg
                    class="mr-3 h-5 w-5 text-txt-black-400"
                    viewBox="0 0 20 20"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    aria-hidden="true"
                  >
                    <circle cx="10" cy="7" r="3" />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M4 16a6 6 0 1112 0H4z"
                    />
                  </svg>
                  Profil Saya
                </a>

                <a
                  href="{{ route('profile.settings') }}"
                  class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                  role="menuitem"
                >
                  <svg
                    class="mr-3 h-5 w-5 text-txt-black-400"
                    viewBox="0 0 20 20"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M8 4h4l1 3-3 8-3-8z"
                    />
                  </svg>
                  Tetapan
                </a>

                <div class="border-t border-otl-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button
                    type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                    role="menuitem"
                  >
                    <svg
                      class="mr-3 h-5 w-5 text-txt-black-400"
                      viewBox="0 0 20 20"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.5"
                      aria-hidden="true"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11 16l4-4m0 0l-4-4m4 4H7m3 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                    Log Keluar
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Mobile Search Bar --}}
  <div
    x-show="searchOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-2"
    class="lg:hidden border-t border-otl-divider bg-bg-white"
    x-cloak
  >
    <div class="px-4 py-3">
      <div class="relative">
        <div
          class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
        >
          <svg
            class="h-5 w-5 text-txt-black-400"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <circle cx="8" cy="8" r="5"></circle>
            <path stroke-linecap="round" d="M12 12l4 4"></path>
          </svg>
        </div>
        <input
          type="search"
          placeholder="Cari permohonan, tiket, peralatan..."
          class="block w-full pl-10 pr-3 py-2 border border-otl-gray-300 rounded-md leading-5 bg-bg-white placeholder-txt-black-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary focus:border-otl-primary-300 text-sm"
          @keydown.escape="searchOpen = false"
          x-ref="mobileSearch"
          aria-label="Carian mudah alih"
        />
      </div>
    </div>
  </div>
</header>
