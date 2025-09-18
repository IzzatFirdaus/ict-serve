<nav x-data="{ open: false }" class="bg-bg-white border-b border-otl-divider">
    <!-- Primary Navigation Menu -->
    <div class="myds-container">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- ServiceDesk ICT Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent myds-body-sm font-medium leading-5 text-txt-black-500 hover:text-txt-black-700 hover:border-otl-gray-200 focus:outline-none focus:text-txt-black-700 focus:border-otl-gray-200 transition duration-150 ease-in-out">
                            ServiceDesk ICT
                            <svg class="ms-1 -me-0.5 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-50 mt-2 w-64 rounded-md shadow-lg bg-bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('equipment-loan.create') }}" class="block px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50">
                                    📋 Equipment Loan Request
                                </a>
                                <a href="{{ route('damage-complaint.create') }}" class="block px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50">
                                    🔧 Report Damage/Issues
                                </a>
                                <a href="{{ route('public.my-requests') }}" class="block px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50">
                                    📊 My Requests
                                </a>
                                <div class="border-t border-otl-divider"></div>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50">
                                    ⚙️ Admin Panel
                                </a>
                                    <x-nav-link :href="route('public.motac-info')" :active="request()->routeIs('public.motac-info')">
                                        {{ __('MOTAC Info') }}
                                    </x-nav-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent myds-body-sm leading-4 font-medium rounded-md text-txt-black-500 bg-bg-white hover:text-txt-black-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="myds-body-sm text-txt-black-600 hover:text-txt-black-900">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 myds-body-sm text-txt-black-600 hover:text-txt-black-900">{{ __('Register') }}</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-bg-gray-50 focus:outline-none focus:bg-bg-gray-50 focus:text-txt-black-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- ServiceDesk ICT Section -->
                <div class="px-4 py-2">
                    <div class="myds-body-sm font-semibold text-txt-black-600 border-b border-otl-gray-200 pb-1">ServiceDesk ICT</div>
            </div>
            <x-responsive-nav-link :href="route('equipment-loan.create')">
                📋 Equipment Loan Request
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('damage-complaint.create')">
                🔧 Report Damage/Issues
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('public.my-requests')">
                📊 My Requests
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.dashboard')">
                ⚙️ Admin Panel
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-otl-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium myds-body-md text-txt-black-700">{{ Auth::user()->name }}</div>
                    <div class="font-medium myds-body-sm text-txt-black-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
