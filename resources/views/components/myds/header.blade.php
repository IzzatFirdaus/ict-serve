{{--
  MYDS Header Navigation for ICTServe (iServe)
  - Standards: MYDS (Design, Develop, Icons, Colour), MyGovEA (Berpaksikan Rakyat, Struktur Hierarki, Paparan/Menu Jelas, Minimalis, Seragam)
  - Features: Responsive 12/8/4 grid, skip link for accessibility, keyboard navigation, visible focus, semantic tokens, ARIA labelling
  - Includes: MOTAC logo, navigation links (ServiceDesk ICT with dropdown), search, mobile menu UX
--}}

@php
  $navLinks = [
    ['href' => '/', 'label' => 'Utama'],
    ['href' => '/informasi', 'label' => 'Informasi'],
    ['href' => '/muat-turun', 'label' => 'Muat Turun'],
    ['href' => '/direktori', 'label' => 'Direktori'],
    ['href' => '/webmail', 'label' => 'Webmail MyGovUC 3.0'],
    ['href' => '/my-integriti', 'label' => 'MY Integriti'],
  ];
@endphp

<x-myds.tokens />

<header class="bg-white border-b border-divider shadow-none z-30 relative" aria-label="Kepala Laman" x-data="mobileNav()">
  {{-- Skip link for accessibility --}}
  <a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 bg-white shadow-context-menu z-50 px-4 py-2 txt-black-900 radius-m transition"
     tabindex="0">
    Lompat ke kandungan utama
  </a>
  <div class="myds-container py-3">
    <div class="grid grid-cols-12 md:grid-cols-8 sm:grid-cols-4 items-center gap-2">
      {{-- Logo/Brand --}}
      <div class="col-span-3 md:col-span-2 sm:col-span-4 flex items-center gap-3 min-w-0">
        <a href="/" class="focus-ring-primary" aria-label="Laman Utama MOTAC">
          <img src="/images/motac-logo.png" alt="Logo MOTAC" class="h-10 w-auto" loading="lazy" />
        </a>
        <span class="font-poppins text-lg txt-primary font-semibold ml-2 hidden md:inline-block">ICTServe (iServe)</span>
      </div>
      {{-- Desktop Navigation --}}
      <nav class="col-span-6 md:col-span-4 sm:col-span-4 hidden md:flex gap-2 items-center" aria-label="Navigasi utama">
        @foreach($navLinks as $link)
          <a href="{{ $link['href'] }}"
            class="myds-footer-link px-3 py-2 text-sm txt-black-700 hover:txt-primary focus:txt-primary font-medium transition-colors focus:ring-2 focus:ring-fr-primary focus:outline-none radius-s"
          >{{ $link['label'] }}</a>
        @endforeach
        {{-- ServiceDesk ICT Dropdown --}}
        <div class="relative group">
          <button type="button"
            class="txt-primary font-semibold px-3 py-2 text-sm transition-colors border-b-2 border-otl-primary-200 flex items-center radius-s focus:outline-none focus:ring-2 focus:ring-fr-primary"
            aria-haspopup="true" aria-expanded="false" aria-controls="ictservicedesk-menu">
            ServiceDesk ICT
            <x-myds.icons.chevron-down class="ml-1 myds-icon" />
          </button>
          <div
            id="ictservicedesk-menu"
            class="absolute left-0 mt-2 w-64 bg-white radius-l shadow-context-menu border border-otl-divider opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50"
            role="menu"
            tabindex="-1"
          >
            <div class="py-2">
              <a href="{{ route('public.loan-request') }}"
                 class="px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary flex items-center gap-2 transition-colors"
                 role="menuitem"
              >
                <x-myds.icons.document class="w-4 h-4 txt-primary" />
                Permohonan Pinjaman Peralatan ICT
              </a>
              <a href="{{ route('public.damage-complaint.guest') }}"
                 class="px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary flex items-center gap-2 transition-colors"
                 role="menuitem"
              >
                <x-myds.icons.alert-triangle class="w-4 h-4 txt-danger" />
                Aduan Kerosakan/Isu ICT
              </a>
              <a href="{{ route('public.my-requests') }}"
                 class="px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary flex items-center gap-2 transition-colors"
                 role="menuitem"
              >
                <x-myds.icons.table class="w-4 h-4 txt-black-500" />
                Permohonan Saya
              </a>
              <div class="border-t border-otl-divider my-2"></div>
              <a href="/admin"
                 class="px-4 py-2 text-sm txt-black-700 hover:bg-gray-50 focus:bg-gray-50 focus:txt-primary flex items-center gap-2 transition-colors"
                 role="menuitem"
              >
                <x-myds.icons.info class="w-4 h-4 txt-black-500" />
                Panel Admin
              </a>
            </div>
          </div>
        </div>
      </nav>
      {{-- Desktop Search & Actions --}}
      <div class="col-span-3 md:col-span-2 sm:col-span-4 flex justify-end items-center gap-2">
        {{-- Search Button (for modal or search bar trigger) --}}
        <button type="button"
          class="txt-black-700 hover:txt-primary p-2 radius-m hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
          aria-label="Cari"
        >
          <x-myds.icons.search class="w-5 h-5 myds-icon" />
        </button>
        {{-- Mobile Menu Button --}}
        <button type="button"
          class="md:hidden txt-black-700 hover:txt-primary p-2 radius-m hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
          aria-label="Buka menu utama"
          @click="toggle()"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
  {{-- Mobile Navigation Menu (x-show needs Alpine/JS integration) --}}
  <div class="md:hidden border-t border-otl-divider bg-gray-50" x-show="open" x-cloak>
    <div class="px-2 pt-2 pb-3 space-y-1">
      @foreach($navLinks as $link)
        <a href="{{ $link['href'] }}" class="block px-3 py-2 text-sm font-medium txt-black-700 hover:txt-primary hover:bg-white radius-m transition-colors">
          {{ $link['label'] }}
        </a>
      @endforeach
      <div class="bg-primary-50 radius-m p-2 mt-2">
        <div class="text-sm font-semibold txt-primary px-1 py-1">ServiceDesk ICT</div>
        <a href="{{ route('public.loan-request') }}" class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white radius-s transition-colors">Permohonan Pinjaman Peralatan ICT</a>
        <a href="{{ route('public.damage-complaint.guest') }}" class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white radius-s transition-colors">Aduan Kerosakan/Isu ICT</a>
        <a href="{{ route('public.my-requests') }}" class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white radius-s transition-colors">Permohonan Saya</a>
        <a href="/admin" class="block px-3 py-2 text-sm txt-black-700 hover:txt-primary hover:bg-white radius-s transition-colors">Panel Admin</a>
      </div>
    </div>
  </div>
</header>
