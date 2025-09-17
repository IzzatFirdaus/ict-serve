{{--
    ICTServe (iServe) - MYDS & MyGovEA Compliant Navigation
    - MYDS Navbar: Logo, menu, dropdown, action area
    - Accessibility: Skip link, keyboard navigation, ARIA roles
    - Semantic tokens for colour/spacing
    - Icons: Inline SVG, 20x20, 1.5px stroke (MYDS-Icons-Overview)
--}}

<nav x-data="{ open: false }" class="bg-bg-white-0 border-b border-otl-divider" aria-label="Utama">
    <!-- MYDS Skip Link (for accessibility, always first) -->
    <a href="#main-content" class="myds-skip-link myds-focus-visible">
        Langkau ke kandungan utama
    </a>

    <div class="myds-container">
        <div class="flex justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2" aria-label="Halaman utama ICTServe">
                    <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="Jata Negara Malaysia" class="h-8 w-auto" />
                    <span class="myds-heading text-heading-3xs font-semibold text-txt-black-900 hidden sm:inline">
                        ICTServe (iServe)
                    </span>
                </a>

                <!-- Primary Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center gap-2 ml-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <svg class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9.5L10 3l7 6.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 10v6a1 1 0 001 1h2m6-7v6a1 1 0 01-1 1h-2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ __('Utama') }}
                    </x-nav-link>

                    <!-- ServiceDesk ICT Dropdown: MYDS NavbarMenuDropdown pattern -->
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            @keydown.escape="open = false"
                            aria-haspopup="true"
                            :aria-expanded="open.toString()"
                            class="inline-flex items-center gap-1 px-3 py-2 rounded-md myds-body-sm font-medium text-txt-black-700 hover:bg-bg-washed focus:outline-none focus:ring-2 focus:ring-fr-primary transition"
                        >
                            <svg class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="10" cy="10" r="8" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 7v4l3 1" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            ServiceDesk ICT
                            <svg class="ms-1 -me-0.5 h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7l3 3 3-3" /></svg>
                        </button>
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-2 w-64 rounded-md shadow-context-menu bg-bg-white-0 border border-otl-divider"
                            role="menu"
                            aria-label="Menu ServiceDesk ICT"
                        >
                            <div class="py-1">
                                <a href="{{ route('equipment-loan.create') }}" class="flex items-center gap-2 px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-washed focus:bg-bg-washed focus:outline-none transition">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-4 h-4"><rect x="3" y="5" width="14" height="9" rx="2"/><path d="M8 17h4"/></svg>
                                    Peminjaman Peralatan ICT
                                </a>
                                <a href="{{ route('damage-complaint.create') }}" class="flex items-center gap-2 px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-washed focus:bg-bg-washed focus:outline-none transition">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-4 h-4"><circle cx="10" cy="10" r="8"/><path d="M10 7v4l3 1"/></svg>
                                    Aduan Kerosakan ICT
                                </a>
                                <a href="{{ route('public.my-requests') }}" class="flex items-center gap-2 px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-washed focus:bg-bg-washed focus:outline-none transition">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-4 h-4"><rect x="4" y="4" width="12" height="12" rx="2"/><path d="M8 8h4v4H8z"/></svg>
                                    Permohonan Saya
                                </a>
                                <div class="my-1 border-t border-otl-divider"></div>
                                <a href="{{ route('filament.admin.pages.dashboard') }}" class="flex items-center gap-2 px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-washed focus:bg-bg-washed focus:outline-none transition">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-4 h-4"><circle cx="10" cy="10" r="8"/><path d="M10 2v2M10 16v2M2 10h2M16 10h2"/></svg>
                                    Panel Admin
                                </a>
                                <a href="{{ route('public.motac-info') }}" class="flex items-center gap-2 px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-washed focus:bg-bg-washed focus:outline-none transition">
                                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" class="w-4 h-4"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm.75 11.25h-1.5v-1.5h1.5v1.5zm0-3v-3h-1.5v3h1.5z"/></svg>
                                    Info MOTAC
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Menu & Auth (Desktop) -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            @keydown.escape="open = false"
                            aria-haspopup="true"
                            :aria-expanded="open.toString()"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-bg-washed transition focus:outline-none focus:ring-2 focus:ring-fr-primary"
                        >
                            <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-body-sm text-txt-black-900">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-txt-black-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7l3 3 3-3" />
                            </svg>
                        </button>
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-56 bg-bg-white-0 border border-otl-divider rounded-md shadow-context-menu z-50"
                            role="menu"
                            aria-label="Menu pengguna"
                        >
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-body-sm text-txt-black-700 hover:bg-bg-washed" role="menuitem">
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-body-sm text-danger-600 hover:bg-bg-washed" role="menuitem">
                                        Log Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="myds-btn-tertiary myds-btn-sm">
                            Log Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="myds-btn-primary myds-btn-sm">
                                Daftar
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-txt-black-500 hover:bg-bg-washed focus:outline-none transition" aria-label="Buka menu navigasi">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="md:hidden bg-bg-white-0 border-t border-otl-divider">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9.5L10 3l7 6.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 10v6a1 1 0 001 1h2m6-7v6a1 1 0 01-1 1h-2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Utama') }}
            </x-responsive-nav-link>

            <div class="px-4 pt-4 pb-2">
                <div class="myds-body-sm font-semibold text-txt-black-600 border-b border-otl-gray-200 pb-1">
                    ServiceDesk ICT
                </div>
            </div>
            <x-responsive-nav-link :href="route('equipment-loan.create')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor"><rect x="3" y="5" width="14" height="9" rx="2"/><path d="M8 17h4"/></svg>
                Peminjaman Peralatan ICT
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('damage-complaint.create')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor"><circle cx="10" cy="10" r="8"/><path d="M10 7v4l3 1"/></svg>
                Aduan Kerosakan ICT
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('public.my-requests')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor"><rect x="4" y="4" width="12" height="12" rx="2"/><path d="M8 8h4v4H8z"/></svg>
                Permohonan Saya
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('filament.admin.pages.dashboard')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor"><circle cx="10" cy="10" r="8"/><path d="M10 2v2M10 16v2M2 10h2M16 10h2"/></svg>
                Panel Admin
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('public.motac-info')">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm.75 11.25h-1.5v-1.5h1.5v1.5zm0-3v-3h-1.5v3h1.5z"/></svg>
                Info MOTAC
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-otl-divider">
            @auth
                <div class="px-4">
                    <div class="font-medium myds-body-md text-txt-black-700">{{ Auth::user()->name }}</div>
                    <div class="font-medium myds-body-sm text-txt-black-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Profil
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 mt-2 space-y-2">
                    <x-responsive-nav-link :href="route('login')">
                        Log Masuk
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            Daftar
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
