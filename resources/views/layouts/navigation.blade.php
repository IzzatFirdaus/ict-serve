<nav
  x-data="{ open: false }"
  class="bg-bg-white border-b border-otl-divider"
  role="navigation"
  aria-label="Main navigation"
>
  <!-- Skip-link anchor for accessibility -->
  <a id="main-nav" tabindex="-1"></a>
  <!-- Primary Navigation Menu -->
  <div class="myds-container">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}">
            <x-application-logo
              class="block h-9 w-auto fill-current text-gray-800"
            />
          </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link
            :href="route('dashboard')"
            :active="request()->routeIs('dashboard')"
          >
            {{ __('Dashboard') }}
          </x-nav-link>

          <!-- ServiceDesk ICT Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <x-myds.button
              type="button"
              variant="tertiary"
              size="sm"
              id="servicedesk-dropdown-trigger"
              x-on:click="open = !open"
              aria-haspopup="true"
              x-bind:aria-expanded="open"
              aria-controls="servicedesk-dropdown"
              class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent myds-body-sm font-medium leading-5 text-txt-black-500 hover:text-txt-black-700 hover:border-otl-gray-200 focus:outline-none focus:text-txt-black-700 focus:border-otl-gray-200 transition duration-150 ease-in-out"
            >
              ServiceDesk ICT
              <x-myds.icon
                name="chevron-down"
                class="ms-1 -me-0.5 h-4 w-4 text-txt-black-400"
                aria-hidden="true"
              />
            </x-myds.button>

            <div
              x-show="open"
              x-cloak
              @click.away="open = false"
              x-transition
              id="servicedesk-dropdown"
              role="menu"
              aria-labelledby="servicedesk-dropdown-trigger"
              class="absolute z-50 mt-2 w-64 rounded-md shadow-lg bg-bg-white ring-1 ring-black ring-opacity-5"
            >
              <div class="py-1">
                <x-myds.button
                  as="a"
                  href="{{ route('equipment-loan.create') }}"
                  variant="tertiary"
                  size="sm"
                  class="block w-full text-left px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50"
                  role="menuitem"
                >
                  <span aria-hidden="true" class="me-2">📋</span>
                  Equipment Loan Request
                </x-myds.button>
                <x-myds.button
                  as="a"
                  href="{{ route('damage-complaint.create') }}"
                  variant="tertiary"
                  size="sm"
                  class="block w-full text-left px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50"
                  role="menuitem"
                >
                  <span aria-hidden="true" class="me-2">🔧</span>
                  Report Damage/Issues
                </x-myds.button>
                <x-myds.button
                  as="a"
                  href="{{ route('public.my-requests') }}"
                  variant="tertiary"
                  size="sm"
                  class="block w-full text-left px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50"
                  role="menuitem"
                >
                  <span aria-hidden="true" class="me-2">📊</span>
                  My Requests
                </x-myds.button>
                <div class="border-t border-otl-divider"></div>
                <x-myds.button
                  as="a"
                  href="{{ route('admin.dashboard') }}"
                  variant="tertiary"
                  size="sm"
                  class="block w-full text-left px-4 py-2 myds-body-sm text-txt-black-700 hover:bg-bg-gray-50"
                  role="menuitem"
                >
                  <span aria-hidden="true" class="me-2">⚙️</span>
                  Admin Panel
                </x-myds.button>
                <x-nav-link
                  :href="route('public.motac-info')"
                  :active="request()->routeIs('public.motac-info')"
                >
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
              <x-myds.button
                type="button"
                variant="tertiary"
                size="sm"
                class="inline-flex items-center px-3 py-2 border border-transparent myds-body-sm leading-4 font-medium rounded-md text-txt-black-500 bg-bg-white hover:text-txt-black-700 focus:outline-none transition ease-in-out duration-150"
              >
                <div>{{ Auth::user()->name }}</div>
                <div class="ms-1">
                  <x-myds.icon
                    name="chevron-down"
                    class="h-4 w-4 text-txt-black-400"
                    aria-hidden="true"
                  />
                </div>
              </x-myds.button>
            </x-slot>

            <x-slot name="content">
              <x-dropdown-link :href="route('profile.edit')">
                {{ __('Profile') }}
              </x-dropdown-link>

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link
                  :href="route('logout')"
                  onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                >
                  {{ __('Log Out') }}
                </x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        @else
          <div class="flex items-center gap-2">
            <x-myds.button
              as="a"
              href="{{ route('login') }}"
              variant="secondary"
              size="sm"
            >
              {{ __('Log in') }}
            </x-myds.button>
            @if (Route::has('register'))
              <x-myds.button
                as="a"
                href="{{ route('register') }}"
                variant="primary"
                size="sm"
              >
                {{ __('Register') }}
              </x-myds.button>
            @endif
          </div>
        @endauth
      </div>

      <!-- Hamburger -->
      <div class="-me-2 flex items-center sm:hidden">
        <x-myds.button
          type="button"
          variant="tertiary"
          size="sm"
          x-on:click="open = !open"
          aria-label="Open navigation menu"
          class="inline-flex items-center justify-center p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-bg-gray-50 focus:outline-none focus:bg-bg-gray-50 focus:text-txt-black-700 transition duration-150 ease-in-out"
        >
          <template x-if="!open">
            <x-myds.icon name="menu" class="h-6 w-6" aria-hidden="true" />
          </template>
          <template x-if="open">
            <x-myds.icon name="close" class="h-6 w-6" aria-hidden="true" />
          </template>
        </x-myds.button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link
        :href="route('dashboard')"
        :active="request()->routeIs('dashboard')"
      >
        {{ __('Dashboard') }}
      </x-responsive-nav-link>

      <!-- ServiceDesk ICT Section -->
      <div class="px-4 py-2">
        <div
          class="myds-body-sm font-semibold text-txt-black-600 border-b border-otl-gray-200 pb-1"
        >
          ServiceDesk ICT
        </div>
      </div>
      <x-responsive-nav-link :href="route('equipment-loan.create')">
        <span aria-hidden="true" class="me-2">📋</span>
        Equipment Loan Request
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('damage-complaint.create')">
        <span aria-hidden="true" class="me-2">🔧</span>
        Report Damage/Issues
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('public.my-requests')">
        <span aria-hidden="true" class="me-2">📊</span>
        My Requests
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('admin.dashboard')">
        <span aria-hidden="true" class="me-2">⚙️</span>
        Admin Panel
      </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-otl-gray-200">
      @auth
        <div class="px-4">
          <div class="font-medium myds-body-md text-txt-black-700">
            {{ Auth::user()->name }}
          </div>
          <div class="font-medium myds-body-sm text-txt-black-500">
            {{ Auth::user()->email }}
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <x-responsive-nav-link :href="route('profile.edit')">
            {{ __('Profile') }}
          </x-responsive-nav-link>

          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-responsive-nav-link
              :href="route('logout')"
              onclick="event.preventDefault();
                                            this.closest('form').submit();"
            >
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
