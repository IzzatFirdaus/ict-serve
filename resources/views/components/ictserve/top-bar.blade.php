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
            this.notificationsOpen = !this.notificationsOpen;
            this.profileOpen = false;
        },
        
        toggleProfile() {
            this.profileOpen = !this.profileOpen;
            this.notificationsOpen = false;
        },
        
        toggleSearch() {
            this.searchOpen = !this.searchOpen;
        },
        
        switchLanguage(lang) {
            window.location.href = '{{ route('language.switch', '') }}/' + lang;
        }
    }"
    @click.away="notificationsOpen = false; profileOpen = false"
    class="bg-bg-surface border-b border-otl-divider shadow-sm relative z-30"
    role="banner"
    {{ $attributes }}
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Left: Logo + Page Title --}}
            <div class="flex items-center">
                {{-- Mobile menu button --}}
                <button
                    @click="$store.sidebar.toggle()"
                    class="lg:hidden p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                    aria-label="Buka menu"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- MOTAC Logo --}}
                <div class="flex items-center ml-4 lg:ml-0">
                    <img 
                        src="{{ asset('images/motac-logo.svg') }}" 
                        alt="Kementerian Pelancongan, Seni dan Budaya Malaysia"
                        class="h-10 w-auto"
                    >
                    <div class="ml-3 hidden sm:block">
                        <h1 class="text-lg font-semibold text-txt-primary font-heading">ICTServe</h1>
                        <p class="text-xs text-txt-black-500">Sistem Pengurusan Perkhidmatan ICT</p>
                    </div>
                </div>
            </div>

            {{-- Center: Search (Desktop) --}}
            <div class="flex-1 max-w-lg mx-8 hidden lg:block">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-txt-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="search"
                        placeholder="Cari permohonan, tiket, peralatan..."
                        class="block w-full pl-10 pr-3 py-2 border border-otl-gray-300 rounded-md leading-5 bg-bg-white placeholder-txt-black-400 focus:outline-none focus:placeholder-txt-black-300 focus:ring-2 focus:ring-fr-primary focus:border-primary-300 text-sm"
                        @keydown.escape="$event.target.blur()"
                    >
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center space-x-4">
                {{-- Search Button (Mobile) --}}
                <button
                    @click="toggleSearch()"
                    class="lg:hidden p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                    aria-label="Cari"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                {{-- Language Toggle --}}
                @if($showLanguageToggle)
                    <div class="relative">
                        <button
                            @click="currentLang === 'ms' ? switchLanguage('en') : switchLanguage('ms')"
                            class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                            :title="currentLang === 'ms' ? 'Switch to English' : 'Tukar ke Bahasa Melayu'"
                        >
                            <span class="text-sm font-medium" x-text="currentLang === 'ms' ? 'EN' : 'MS'"></span>
                        </button>
                    </div>
                @endif

                {{-- Notifications --}}
                @if($showNotifications && $user)
                    <div class="relative">
                        <button
                            @click="toggleNotifications()"
                            class="relative p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                            :class="{ 'text-txt-primary bg-primary-50': notificationsOpen }"
                            aria-label="Notifikasi"
                            :aria-expanded="notificationsOpen"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if($notificationCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-danger-600 rounded-full">
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
                            class="absolute right-0 mt-2 w-80 bg-bg-white rounded-md shadow-lg ring-1 ring-otl-divider ring-opacity-5 z-50"
                            x-cloak
                            role="menu"
                            aria-label="Notifikasi"
                        >
                            <div class="p-4 border-b border-otl-divider">
                                <h3 class="text-sm font-medium text-txt-black-900">Notifikasi</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                @forelse($user->unreadNotifications->take(5) as $notification)
                                    <div class="p-4 border-b border-otl-divider hover:bg-gray-50">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-txt-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                        <p class="text-sm text-txt-black-500">Tiada notifikasi baharu</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="p-4 border-t border-otl-divider">
                                <a href="{{ route('notifications.index') }}" class="text-sm text-txt-primary hover:text-primary-700 font-medium">
                                    Lihat semua notifikasi
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Profile Dropdown --}}
                @if($user)
                    <div class="relative">
                        <button
                            @click="toggleProfile()"
                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-fr-primary"
                            :class="{ 'ring-2 ring-primary-300': profileOpen }"
                            aria-label="Menu profil"
                            :aria-expanded="profileOpen"
                        >
                            <img 
                                class="h-8 w-8 rounded-full object-cover" 
                                src="{{ $user->avatar_url ?? asset('images/default-avatar.svg') }}" 
                                alt="{{ $user->name }}"
                            >
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
                            class="absolute right-0 mt-2 w-64 bg-bg-white rounded-md shadow-lg ring-1 ring-otl-divider ring-opacity-5 z-50"
                            x-cloak
                            role="menu"
                            aria-label="Menu profil"
                        >
                            {{-- User Info --}}
                            <div class="p-4 border-b border-otl-divider">
                                <div class="flex items-center">
                                    <img 
                                        class="h-10 w-10 rounded-full object-cover" 
                                        src="{{ $user->avatar_url ?? asset('images/default-avatar.svg') }}" 
                                        alt="{{ $user->name }}"
                                    >
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-txt-black-900">{{ $user->name }}</p>
                                        <p class="text-xs text-txt-black-500">{{ $user->email }}</p>
                                        <p class="text-xs text-txt-black-400">{{ $user->department ?? 'Tiada jabatan' }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1">
                                <a 
                                    href="{{ route('profile.show') }}" 
                                    class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900"
                                    role="menuitem"
                                >
                                    <svg class="mr-3 h-5 w-5 text-txt-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profil Saya
                                </a>

                                <a 
                                    href="{{ route('profile.settings') }}" 
                                    class="flex items-center px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900"
                                    role="menuitem"
                                >
                                    <svg class="mr-3 h-5 w-5 text-txt-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Tetapan
                                </a>

                                <div class="border-t border-otl-divider"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button 
                                        type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-txt-black-700 hover:bg-gray-50 hover:text-txt-black-900"
                                        role="menuitem"
                                    >
                                        <svg class="mr-3 h-5 w-5 text-txt-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-txt-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="search"
                    placeholder="Cari permohonan, tiket, peralatan..."
                    class="block w-full pl-10 pr-3 py-2 border border-otl-gray-300 rounded-md leading-5 bg-bg-white placeholder-txt-black-400 focus:outline-none focus:placeholder-txt-black-300 focus:ring-2 focus:ring-fr-primary focus:border-primary-300 text-sm"
                    @keydown.escape="searchOpen = false"
                    x-ref="mobileSearch"
                >
            </div>
        </div>
    </div>
</header>