{{--
  MYDS Navigation Component for ICTServe (iServe)
  - Compliant with MYDS (Design, Develop, Icons, Colour) and MyGovEA (citizen-centric, clear menu, minimalis, seragam)
  - Responsive, accessible, with semantic tokens, ARIA, and visible focus
  - Usage: Place at the top or side of page for primary navigation
  - Props:
  navLinks: Array of ['href' => string, 'label' => string, 'active' => bool] (optional)
  class: string|null (extra classes)
  - Supports keyboard navigation, screen readers, and clear visual hierarchy
--}}

{{--
  @php
  $navLinks = $navLinks ?? [
  ['href' => '/', 'label' => 'Utama', 'active' => request()->is('/')],
  ['href' => '/informasi', 'label' => 'Informasi', 'active' => request()->is('informasi*')],
  ['href' => '/muat-turun', 'label' => 'Muat Turun', 'active' => request()->is('muat-turun*')],
  ['href' => '/direktori', 'label' => 'Direktori', 'active' => request()->is('direktori*')],
  ['href' => '/webmail', 'label' => 'Webmail MyGovUC 3.0', 'active' => request()->is('webmail*')],
  ['href' => '/my-integriti', 'label' => 'MY Integriti', 'active' => request()->is('my-integriti*')],
  ];
  @endphp
--}}

<x-myds.tokens />

<nav
  class="bg-white border-b border-otl-divider shadow-none z-30 relative {{ $class ?? '' }}"
  aria-label="Navigasi utama ICTServe"
>
  <div class="myds-container py-3">
    <div class="flex items-center gap-x-4">
      {{-- Logo/Brand --}}
      <a
        href="/"
        class="focus-ring-primary flex items-center gap-2 min-w-0"
        aria-label="Laman Utama MOTAC"
      >
        <img
          src="/images/motac-logo.png"
          alt="Logo MOTAC"
          class="h-10 w-auto"
          loading="lazy"
        />
        <span
          class="font-poppins text-lg txt-primary font-semibold hidden sm:inline-block"
        >
          ICTServe (iServe)
        </span>
      </a>
      {{-- Desktop Navigation --}}
      <ul
        class="hidden md:flex gap-0.5 items-center flex-1 justify-center"
        role="menubar"
      >
        @foreach ($navLinks as $link)
          <li role="none">
            <a
              href="{{ $link['href'] }}"
              class="px-3 py-2 text-sm font-medium transition-colors rounded-s {{ $link['active'] ? 'txt-primary border-b-2 border-otl-primary-200 font-semibold bg-washed' : 'txt-black-700 hover:txt-primary hover:bg-washed' }} focus:outline-none focus:ring-2 focus:ring-fr-primary"
              aria-current="{{ $link['active'] ? 'page' : false }}"
              role="menuitem"
              tabindex="0"
            >
              {{ $link['label'] }}
            </a>
          </li>
        @endforeach

        {{-- ServiceDesk ICT: Dropdown --}}
        <li class="relative group" role="none">
          <button
            type="button"
            class="txt-primary font-semibold px-3 py-2 text-sm transition-colors border-b-2 border-otl-primary-200 flex items-center rounded-s focus:outline-none focus:ring-2 focus:ring-fr-primary"
            aria-haspopup="true"
            aria-expanded="false"
            aria-controls="ictservicedesk-menu"
            role="menuitem"
          >
            ServiceDesk ICT
            <x-myds.icons.chevron-down class="ml-1 myds-icon" />
          </button>
          <div
            id="ictservicedesk-menu"
            class="absolute left-0 mt-2 w-64 bg-white rounded-l shadow-context-menu border border-otl-divider opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50"
            role="menu"
            tabindex="-1"
          >
            <div class="py-2">
              <a
                href="{{ route('public.loan-request') }}"
                class="flex px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary items-center gap-2 transition-colors"
                role="menuitem"
              >
                <x-myds.icons.document class="w-4 h-4 txt-primary" />
                Permohonan Pinjaman Peralatan ICT
              </a>
              <a
                href="{{ route('public.damage-complaint.guest') }}"
                class="flex px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary items-center gap-2 transition-colors"
                role="menuitem"
              >
                <x-myds.icons.alert-triangle class="w-4 h-4 txt-danger" />
                Aduan Kerosakan/Isu ICT
              </a>
              <a
                href="{{ route('public.my-requests') }}"
                class="flex px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary items-center gap-2 transition-colors"
                role="menuitem"
              >
                <x-myds.icons.table class="w-4 h-4 txt-black-500" />
                Permohonan Saya
              </a>
              <div class="border-t border-otl-divider my-2"></div>
              <a
                href="/admin"
                class="flex px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary items-center gap-2 transition-colors"
                role="menuitem"
              >
                <x-myds.icons.info class="w-4 h-4 txt-black-500" />
                Panel Admin
              </a>
            </div>
          </div>
        </li>
      </ul>

      {{-- Search & Mobile Menu Controls --}}
      <div class="flex items-center gap-x-2 ml-auto">
        {{-- Search Button --}}
        <button
          type="button"
          class="txt-black-700 hover:txt-primary p-2 rounded-m hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
          aria-label="Cari"
        >
          <x-myds.icons.search class="w-5 h-5 myds-icon" />
        </button>
        {{-- Mobile Menu Button --}}
        <button
          type="button"
          class="md:hidden txt-black-700 hover:txt-primary p-2 rounded-m hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
          aria-label="Buka menu utama"
          @click="openMobileNav = !openMobileNav"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
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

  {{-- Mobile Navigation Menu --}}
  <div
    class="md:hidden border-t border-otl-divider bg-gray-50"
    x-show="openMobileNav"
    x-cloak
  >
    <div class="px-2 pt-2 pb-3 space-y-1">
      @foreach ($navLinks as $link)
        <a
          href="{{ $link['href'] }}"
          class="block px-3 py-2 text-sm font-medium txt-black-700 hover:txt-primary hover:bg-white rounded-m transition-colors"
        >
          {{ $link['label'] }}
        </a>
      @endforeach

      <div class="bg-primary-50 rounded-m p-2 mt-2">
        <div class="text-sm font-semibold txt-primary px-1 py-1">
          ServiceDesk ICT
        </div>
        <a
          href="{{ route('public.loan-request') }}"
          class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white rounded-s transition-colors"
        >
          Permohonan Pinjaman Peralatan ICT
        </a>
        <a
          href="{{ route('public.damage-complaint.guest') }}"
          class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white rounded-s transition-colors"
        >
          Aduan Kerosakan/Isu ICT
        </a>
        <a
          href="{{ route('public.my-requests') }}"
          class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white rounded-s transition-colors"
        >
          Permohonan Saya
        </a>
        <a
          href="/admin"
          class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white rounded-s transition-colors"
        >
          Panel Admin
        </a>
      </div>
    </div>
  </div>
</nav>
