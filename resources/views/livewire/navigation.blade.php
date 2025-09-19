{{--
  ICTServe (iServe) Main Navigation Component
  ===========================================
  This component creates the primary navigation structure for the application,
  consisting of a collapsible sidebar and a top action bar. It is designed
  to be included in the main application layout file (e.g., `layouts/app.blade.php`).
  
  MYDS & MyGovEA Principles Applied:
  - Seragam (Consistent): Uses consistent MYDS icons, colors, and spacing.
  - Paparan/Menu Jelas (Clear Display/Menu): Logical grouping of navigation items with clear icons and labels.
  - Kawalan Pengguna (User Control): Users can collapse/expand the sidebar, and the state is saved. The profile dropdown gives access to user-specific actions.
  - Struktur Hierarki (Hierarchical Structure): Navigation is organized by user roles and permissions.
  - Fleksibel (Flexible): The layout adapts to different screen sizes and sidebar states.
--}}

<div>
  {{--
    Alpine.js is used here for all client-side interactivity, which is the standard for the TALL stack.
    - `isSidebarOpen`: Controls the expanded/collapsed state of the sidebar.
    - `init()`: Initializes the state from `localStorage` to remember the user's preference.
    - `$watch`: Automatically saves the state to `localStorage` whenever it changes.
  --}}
  <div
    x-data="{
      isSidebarOpen:
        window.innerWidth > 1024
          ? localStorage.getItem('isSidebarOpen') === 'true'
          : false,
      init() {
        this.$watch('isSidebarOpen', (value) =>
          localStorage.setItem('isSidebarOpen', value),
        )
      },
    }"
    x-init="init()"
    @keydown.escape.window="isSidebarOpen = false"
  >
    <div
      x-show="isSidebarOpen"
      @click="isSidebarOpen = false"
      class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"
      x-cloak
    ></div>

    <aside
      :class="{ 'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen }"
      class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col border-r border-otl-gray-200 bg-white transition-transform duration-300 ease-in-out dark:border-otl-gray-800 dark:bg-gray-900 lg:translate-x-0 lg:transition-all"
      :style="{'width': window.innerWidth > 1024 ? (isSidebarOpen ? '16rem' : '5rem') : '16rem'}"
    >
      <div
        class="flex h-16 shrink-0 items-center justify-between px-6 border-b border-otl-divider dark:border-otl-divider"
      >
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
          {{-- Jata Negara Icon - Consistent with welcome page --}}
          <svg
            class="h-8 w-8 text-primary-600 dark:text-primary-400"
            viewBox="0 0 24 24"
            fill="currentColor"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"
            />
          </svg>
          <span
            class="font-poppins text-lg font-semibold text-txt-black-900 dark:text-white"
            x-show="isSidebarOpen"
            x-transition
          >
            ICTServe
          </span>
        </a>
      </div>

      <nav class="flex-1 space-y-2 overflow-y-auto px-4 py-4">
        <ul class="space-y-1">
          {{-- Dashboard --}}
          <li>
            <a
              href="{{ route('dashboard') }}"
              class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-300' : 'text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed' }}"
            >
              <x-heroicon-o-home class="h-5 w-5" />
              <span x-show="isSidebarOpen" x-transition.opacity>
                Papan Pemuka
              </span>
            </a>
          </li>

          {{-- Equipment Loan Application --}}
          <li>
            <a
              href="#"
              class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed"
            >
              <x-heroicon-o-computer-desktop class="h-5 w-5" />
              <span x-show="isSidebarOpen" x-transition.opacity>
                Pinjaman Aset ICT
              </span>
            </a>
          </li>

          {{-- Helpdesk --}}
          <li>
            <a
              href="#"
              class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed"
            >
              <x-heroicon-o-question-mark-circle class="h-5 w-5" />
              <span x-show="isSidebarOpen" x-transition.opacity>
                Meja Bantuan
              </span>
            </a>
          </li>

          {{-- Role-Based Link: Approvals --}}
          @can('view approvals')
            <li>
              <a
                href="#"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed"
              >
                <x-heroicon-o-check-circle class="h-5 w-5" />
                <span x-show="isSidebarOpen" x-transition.opacity>
                  Kelulusan
                </span>
              </a>
            </li>
          @endcan

          {{-- Role-Based Link: Admin Panel (Filament) --}}
          @can('access filament')
            <li>
              <a
                href="{{ route('filament.admin.pages.dashboard') }}"
                class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm font-medium transition-colors text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed"
              >
                <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
                <span x-show="isSidebarOpen" x-transition.opacity>
                  Panel Pentadbir
                </span>
              </a>
            </li>
          @endcan
        </ul>
      </nav>

      <div
        class="hidden lg:flex items-center justify-center p-4 mt-auto border-t border-otl-divider dark:border-otl-divider"
      >
        <button
          @click="isSidebarOpen = !isSidebarOpen"
          class="p-2 rounded-full hover:bg-washed dark:hover:bg-washed transition-colors"
        >
          <span
            class="sr-only"
            x-text="isSidebarOpen ? 'Collapse sidebar' : 'Expand sidebar'"
          ></span>
          <x-heroicon-o-chevron-double-left
            class="h-6 w-6 text-txt-black-500"
            ::class="{ 'rotate-180': ! isSidebarOpen }"
          />
        </button>
      </div>
    </aside>

    <div
      class="flex min-h-screen flex-1 flex-col transition-all duration-300 ease-in-out"
      :style="{'margin-left': window.innerWidth > 1024 ? (isSidebarOpen ? '16rem' : '5rem') : '0'}"
    >
      <header
        class="sticky top-0 z-20 flex h-16 w-full items-center justify-between border-b border-otl-divider bg-white/80 px-4 backdrop-blur-sm dark:border-otl-divider dark:bg-gray-900/80 sm:px-6 lg:px-8"
      >
        <button @click="isSidebarOpen = !isSidebarOpen" class="lg:hidden">
          <span class="sr-only">Buka menu</span>
          <x-heroicon-o-bars-3 class="h-6 w-6" />
        </button>

        <div class="flex-1">
          {{-- <h1 class="text-lg font-semibold">{{ $title ?? 'Papan Pemuka' }}</h1> --}}
        </div>

        <div class="flex items-center gap-4">
          {{-- Notifications --}}
          <button
            class="relative rounded-full p-2 text-txt-black-500 hover:bg-washed dark:hover:bg-washed"
          >
            <span class="sr-only">Lihat Notifikasi</span>
            <x-heroicon-o-bell class="h-6 w-6" />
            @if (isset($notificationCount) && $notificationCount > 0)
              <span class="absolute top-1 right-1 flex h-3 w-3">
                <span
                  class="animate-ping absolute inline-flex h-full w-full rounded-full bg-danger-400 opacity-75"
                ></span>
                <span
                  class="relative inline-flex rounded-full h-3 w-3 bg-danger-500"
                ></span>
              </span>
            @endif
          </button>

          {{-- Profile Dropdown --}}
          <div x-data="{ open: false }" class="relative">
            <button
              @click="open = !open"
              class="flex items-center gap-2 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary"
            >
              <img
                class="h-8 w-8 rounded-full object-cover"
                src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}"
              />
              <span
                class="hidden sm:inline text-sm font-medium text-txt-black-700 dark:text-txt-black-300"
              >
                {{ Auth::user()->name }}
              </span>
              <x-heroicon-s-chevron-down
                class="h-4 w-4 text-txt-black-500 hidden sm:inline"
              />
            </button>

            <div
              x-show="open"
              @click.away="open = false"
              x-transition
              x-cloak
              class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-context-menu ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-white/10"
              role="menu"
              aria-orientation="vertical"
              tabindex="-1"
            >
              <a
                href="{{ route('profile.show') }}"
                class="block px-4 py-2 text-sm text-txt-black-700 hover:bg-washed dark:text-txt-black-300 dark:hover:bg-washed"
                role="menuitem"
                tabindex="-1"
              >
                Profil Saya
              </a>

              <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <a
                  href="{{ route('logout') }}"
                  @click.prevent="$root.submit();"
                  class="block w-full px-4 py-2 text-left text-sm text-txt-danger hover:bg-danger-50 dark:hover:bg-danger-950"
                  role="menuitem"
                  tabindex="-1"
                >
                  Log Keluar
                </a>
              </form>
            </div>
          </div>
        </div>
      </header>

      <main class="flex-1 p-4 sm:p-6 lg:p-8">
        {{-- The main page content from other views will be injected here --}}
        {{-- @slot('slot') --}}
      </main>
    </div>
  </div>
</div>
