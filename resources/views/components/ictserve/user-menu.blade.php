@props([
  'user' => null,
  'placement' => 'bottom-end',
  'showAvatar' => true,
  'showNotifications' => true,
  'notificationCount' => 0,
])

@php
  $currentUser = $user ?? auth()->user();
  $hasNotifications = $showNotifications && $notificationCount > 0;
@endphp

<div
  class="relative"
  x-data="userMenu()"
  @keydown.escape="open = false; showNotifications = false"
  @click.away="open = false; showNotifications = false"
  {{ $attributes }}
>
  {{-- User Profile Button --}}
  <button
    @click="open = !open"
    class="flex items-center gap-2 md:gap-3 px-3 py-2 rounded-lg transition-colors duration-200 text-sm bg-bg-white hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
    :class="{ 'bg-gray-100': open }"
    aria-haspopup="true"
    aria-expanded="open"
    aria-controls="user-menu-dropdown"
    id="user-menu-button"
    type="button"
  >
    {{-- User Avatar --}}
    @if ($showAvatar)
      <div class="flex-shrink-0">
        @if ($currentUser && ($currentUser->avatar ?? null))
          <img
            class="h-8 w-8 rounded-full object-cover border border-otl-divider"
            src="{{ asset('storage/' . $currentUser->avatar) }}"
            alt="Avatar {{ $currentUser->name }}"
            loading="lazy"
          />
        @else
          <div
            class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center"
          >
            <span class="text-sm font-medium text-txt-white">
              {{ $currentUser ? strtoupper(mb_substr($currentUser->name ?? 'U', 0, 1)) : 'U' }}
            </span>
          </div>
        @endif
      </div>
    @endif

    {{-- User Info (hide on xs for minimalism) --}}
    <div class="hidden md:block text-left leading-tight">
      <div class="font-medium text-txt-black-900 truncate max-w-[140px]">
        {{ $currentUser->name ?? 'Pengguna' }}
      </div>
      <div class="text-xs text-txt-black-500 truncate max-w-[140px]">
        {{ $currentUser->email ?? 'user@example.com' }}
      </div>
    </div>

    {{-- Dropdown Arrow --}}
    <svg
      class="h-4 w-4 text-txt-black-400 transition-transform duration-200"
      :class="{ 'rotate-180': open }"
      viewBox="0 0 20 20"
      fill="none"
      stroke="currentColor"
      stroke-width="1.5"
      aria-hidden="true"
    >
      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7l-6 6-6-6" />
    </svg>
  </button>

  {{-- Notifications Quick Button (optional, only for accessibility; main notifications panel is in header) --}}
  @if ($showNotifications)
    <button
      @click.stop="showNotifications = !showNotifications"
      class="ml-2 relative p-2 rounded-lg text-txt-black-600 hover:text-txt-primary hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors duration-200"
      aria-label="Notifikasi"
      aria-controls="user-notifications-panel"
      :aria-expanded="showNotifications"
      type="button"
    >
      {{-- MYDS notification/bell icon --}}
      <svg
        class="h-5 w-5"
        viewBox="0 0 20 20"
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        aria-hidden="true"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M10 3a6 6 0 00-6 6v2l-1 2h14l-1-2V9a6 6 0 00-6-6zM8 17a2 2 0 104 0"
        />
      </svg>
      @if ($hasNotifications)
        <span
          class="absolute -top-1 -right-1 h-5 w-5 bg-danger-600 text-txt-white text-xs rounded-full flex items-center justify-center font-semibold border-2 border-bg-white"
        >
          {{ $notificationCount > 99 ? '99+' : $notificationCount }}
        </span>
      @endif
    </button>
  @endif

  {{-- Dropdown Menu --}}
  <div
    x-show="open"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="absolute right-0 mt-2 w-[290px] sm:w-72 bg-bg-white rounded-lg shadow-context-menu ring-1 ring-otl-divider z-50"
    role="menu"
    aria-orientation="vertical"
    aria-labelledby="user-menu-button"
    id="user-menu-dropdown"
    tabindex="-1"
    x-cloak
  >
    {{-- User Profile Header --}}
    <div class="px-4 py-3 border-b border-otl-divider flex items-center gap-3">
      {{-- Avatar --}}
      <div class="flex-shrink-0">
        @if ($currentUser && ($currentUser->avatar ?? null))
          <img
            class="h-10 w-10 rounded-full object-cover border border-otl-divider"
            src="{{ asset('storage/' . $currentUser->avatar) }}"
            alt="Avatar {{ $currentUser->name }}"
            loading="lazy"
          />
        @else
          <div
            class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center"
          >
            <span class="text-lg font-medium text-txt-white">
              {{ $currentUser ? strtoupper(mb_substr($currentUser->name ?? 'U', 0, 1)) : 'U' }}
            </span>
          </div>
        @endif
      </div>
      <div class="truncate min-w-0">
        <div class="font-medium text-txt-black-900 truncate">
          {{ $currentUser->name ?? 'Pengguna' }}
        </div>
        <div class="text-xs text-txt-black-500 truncate">
          {{ $currentUser->email ?? 'user@example.com' }}
        </div>
        @if ($currentUser && $currentUser->staff_id)
          <div class="text-xs text-txt-black-400 truncate">
            ID Staff: {{ $currentUser->staff_id }}
          </div>
        @endif
      </div>
    </div>

    {{-- Menu Items --}}
    <nav class="py-1" aria-label="Menu Profil">
      <a
        href="{{ route('profile.show') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
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
        href="{{ route('settings.index') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
          />
          <circle cx="10" cy="10" r="3" />
        </svg>
        Tetapan
      </a>

      <a
        href="{{ route('loans.my-applications') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <rect x="4" y="4" width="12" height="12" rx="2" />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 8h4m-4 4h4"
          />
        </svg>
        Permohonan Saya
      </a>

      <a
        href="{{ route('helpdesk.my-tickets') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <rect x="3" y="7" width="14" height="6" rx="2" />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10 12v2m0-8v2"
          />
        </svg>
        Tiket Saya
      </a>

      <div class="border-t border-otl-divider my-1"></div>

      <a
        href="{{ route('help.index') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <circle cx="10" cy="10" r="8" />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M10 6a2 2 0 110 4v2"
          />
        </svg>
        Pusat Bantuan
      </a>

      <a
        href="{{ route('docs.index') }}"
        class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-primary focus:bg-gray-100 focus:text-txt-primary transition-colors"
        role="menuitem"
      >
        <svg
          class="mr-3 h-4 w-4 text-txt-black-400"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <rect x="4" y="3" width="12" height="14" rx="2" />
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 6h4m-4 4h4"
          />
        </svg>
        Dokumentasi
      </a>

      <div class="border-t border-otl-divider my-1"></div>

      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button
          type="submit"
          class="flex items-center w-full px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 transition-colors focus:bg-danger-100 focus:text-danger-700"
          role="menuitem"
        >
          <svg
            class="mr-3 h-4 w-4 text-danger-500"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M13 16l4-4m0 0l-4-4m4 4H7m3 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
            />
          </svg>
          Log Keluar
        </button>
      </form>
    </nav>
  </div>

  {{-- Notifications Panel --}}
  @if ($showNotifications)
    <div
      x-show="showNotifications"
      x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="transform opacity-0 scale-95"
      x-transition:enter-end="transform opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75"
      x-transition:leave-start="transform opacity-100 scale-100"
      x-transition:leave-end="transform opacity-0 scale-95"
      class="absolute right-0 mt-2 w-80 bg-bg-white rounded-lg shadow-context-menu ring-1 ring-otl-divider z-50"
      id="user-notifications-panel"
      role="region"
      aria-label="Notifikasi"
      tabindex="-1"
      x-cloak
    >
      {{-- Notifications Header --}}
      <div
        class="px-4 py-3 border-b border-otl-divider flex items-center justify-between"
      >
        <h3 class="text-sm font-medium text-txt-black-900">Notifikasi</h3>
        @if ($hasNotifications)
          <button
            @click="markAllAsRead()"
            class="text-xs text-txt-primary hover:text-primary-800 focus:underline"
            type="button"
          >
            Tanda Semua Dibaca
          </button>
        @endif
      </div>

      {{-- Notifications List --}}
      <div class="max-h-64 overflow-y-auto">
        @if ($hasNotifications)
          {{-- Example notification (replace with dynamic list as needed) --}}
          <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50">
            <div class="flex items-start space-x-3">
              <div class="flex-shrink-0">
                <div class="h-2 w-2 bg-primary-600 rounded-full mt-2"></div>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm text-txt-black-900">
                  Permohonan pinjaman anda telah diluluskan
                </p>
                <p class="text-xs text-txt-black-500 mt-1">2 jam yang lalu</p>
              </div>
            </div>
          </div>
        @else
          <div class="px-4 py-8 text-center">
            <svg
              class="mx-auto h-12 w-12 text-txt-black-400"
              viewBox="0 0 20 20"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              aria-hidden="true"
            >
              <circle cx="10" cy="10" r="8" />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8 10h4M10 8v4"
              />
            </svg>
            <p class="mt-2 text-sm text-txt-black-600">
              Tiada notifikasi baharu
            </p>
          </div>
        @endif
      </div>

      {{-- View All Link --}}
      @if ($hasNotifications)
        <div class="px-4 py-3 border-t border-otl-divider">
          <a
            href="{{ route('notifications.index') }}"
            class="text-sm text-txt-primary hover:text-primary-800 font-medium focus:underline"
          >
            Lihat Semua Notifikasi
          </a>
        </div>
      @endif
    </div>
  @endif
</div>

{{-- JavaScript moved to resources/js/components/user-menu.js and exposed via resources/js/app.js (@vite) --}}
