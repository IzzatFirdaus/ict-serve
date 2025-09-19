@props([
  'collapsed' => false,
  'pinned' => false,
])

@php
  $sidebarId = 'ictserve-sidebar';
@endphp

<aside
  x-data="{
    collapsed: {{ $collapsed ? 'true' : 'false' }},
    pinned: {{ $pinned ? 'true' : 'false' }},
    init() {
      // Load sidebar state from localStorage
      const savedState = localStorage.getItem('ictserve-sidebar-state')
      if (savedState) {
        const state = JSON.parse(savedState)
        this.collapsed = ! ! state.collapsed
        this.pinned = ! ! state.pinned
      }
    },
    toggle() {
      this.collapsed = ! this.collapsed
      this.saveState()
    },
    togglePin() {
      this.pinned = ! this.pinned
      this.saveState()
    },
    saveState() {
      localStorage.setItem(
        'ictserve-sidebar-state',
        JSON.stringify({
          collapsed: this.collapsed,
          pinned: this.pinned,
        }),
      )
    },
    onMouseEnter() {
      if (this.collapsed && ! this.pinned) this.collapsed = false
    },
    onMouseLeave() {
      if (! this.pinned && $store.mobile?.isMobile !== true) this.collapsed = true
    },
  }"
  x-init="init()"
  @mouseenter="onMouseEnter()"
  @mouseleave="onMouseLeave()"
  :class="{ 'w-64': !collapsed, 'w-16': collapsed }"
  class="fixed left-0 top-0 h-full bg-bg-surface border-r border-otl-divider transition-all duration-300 z-40 shadow-sm"
  id="{{ $sidebarId }}"
  role="navigation"
  aria-label="Navigasi utama"
  {{ $attributes }}
>
  {{-- Sidebar Header --}}
  <div
    class="flex items-center justify-between p-4 border-b border-otl-divider"
  >
    {{-- ICTServe Logo --}}
    <div
      class="flex items-center w-full"
      :class="{ 'justify-center': collapsed }"
    >
      <div class="flex-shrink-0">
        <img
          src="{{ asset('images/ictserve-logo.svg') }}"
          alt="ICTServe (iServe)"
          class="h-8 w-auto"
          :class="{ 'hidden': collapsed }"
        />
        <img
          src="{{ asset('images/ictserve-icon.svg') }}"
          alt="ICTServe"
          class="h-8 w-8"
          :class="{ 'hidden': !collapsed }"
        />
      </div>
      <span
        class="ml-3 text-lg font-semibold text-txt-primary font-heading"
        :class="{ 'hidden': collapsed }"
      >
        ICTServe
      </span>
    </div>

    {{-- Collapse/Pin Controls --}}
    <div class="flex items-center space-x-2" :class="{ 'hidden': collapsed }">
      <button
        @click="togglePin()"
        class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
        :class="{ 'text-txt-primary bg-primary-50': pinned }"
        :title="pinned ? 'Lepaskan pin sidebar' : 'Pin sidebar'"
        :aria-label="pinned ? 'Lepaskan pin sidebar' : 'Pin sidebar'"
        aria-controls="{{ $sidebarId }}"
      >
        {{-- MYDS pin icon 20x20 --}}
        <svg
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 3h8v5l-3 3v4l-2 2v-6L6 8V3z"
          />
        </svg>
      </button>

      <button
        @click="toggle()"
        class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary transition-colors"
        title="Lipat sidebar"
        aria-label="Lipat sidebar"
        aria-controls="{{ $sidebarId }}"
        :aria-expanded="!collapsed"
      >
        {{-- MYDS chevrons icon 20x20 --}}
        <svg
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="none"
          stroke="currentColor"
          stroke-width="1.5"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 15l-4-5 4-5M11 15l4-5-4-5"
          />
        </svg>
      </button>
    </div>
  </div>

  {{-- Navigation Menu --}}
  <nav class="flex-1 p-4" aria-label="Menu navigasi">
    <ul class="space-y-2">
      {{-- Dashboard --}}
      <li>
        <a
          href="{{ route('dashboard') }}"
          class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
          :class="{ 'justify-center': collapsed }"
          :title="collapsed ? 'Papan Pemuka' : ''"
          aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}"
        >
          <svg
            class="h-5 w-5 flex-shrink-0"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path
              d="M3 7v8a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"
            />
            <path
              d="M7 5a2 2 0 012-2h2a2 2 0 012 2v1a2 2 0 01-2 2H9a2 2 0 01-2-2V5z"
            />
          </svg>
          <span class="ml-3" :class="{ 'hidden': collapsed }">
            Papan Pemuka
          </span>
        </a>
      </li>

      {{-- Loan Applications --}}
      <li>
        <a
          href="{{ route('loans.index') }}"
          class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary {{ request()->routeIs('loans.*') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
          :class="{ 'justify-center': collapsed }"
          :title="collapsed ? 'Pinjaman Peralatan' : ''"
          aria-current="{{ request()->routeIs('loans.*') ? 'page' : 'false' }}"
        >
          <svg
            class="h-5 w-5 flex-shrink-0"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path d="M3 6h14v8a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
            <path d="M7 9h6v4H7z" />
          </svg>
          <span class="ml-3" :class="{ 'hidden': collapsed }">
            Pinjaman Peralatan
          </span>
        </a>
      </li>

      {{-- Helpdesk --}}
      <li>
        <a
          href="{{ route('helpdesk.index') }}"
          class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary {{ request()->routeIs('helpdesk.*') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
          :class="{ 'justify-center': collapsed }"
          :title="collapsed ? 'Aduan Kerosakan' : ''"
          aria-current="{{ request()->routeIs('helpdesk.*') ? 'page' : 'false' }}"
        >
          <svg
            class="h-5 w-5 flex-shrink-0"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M10 2a8 8 0 100 16 8 8 0 000-16zM10 10v3m0-6h.01"
            />
          </svg>
          <span class="ml-3" :class="{ 'hidden': collapsed }">
            Aduan Kerosakan
          </span>
        </a>
      </li>

      {{-- My Requests --}}
      <li>
        <a
          href="{{ route('my-requests') }}"
          class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary {{ request()->routeIs('my-requests') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
          :class="{ 'justify-center': collapsed }"
          :title="collapsed ? 'Permohonan Saya' : ''"
          aria-current="{{ request()->routeIs('my-requests') ? 'page' : 'false' }}"
        >
          <svg
            class="h-5 w-5 flex-shrink-0"
            viewBox="0 0 20 20"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            aria-hidden="true"
          >
            <path d="M4 5h8l4 4v6a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2z" />
            <path d="M8 9h4M8 13h4" />
          </svg>
          <span class="ml-3" :class="{ 'hidden': collapsed }">
            Permohonan Saya
          </span>
        </a>
      </li>

      {{-- Admin Section (if user has admin role) --}}
      @can('admin-access')
        <li class="pt-4">
          <div
            class="border-t border-otl-divider mb-4"
            :class="{ 'hidden': collapsed }"
          ></div>
          <h3
            class="px-3 text-xs font-semibold text-txt-black-500 uppercase tracking-wider"
            :class="{ 'hidden': collapsed }"
          >
            Pentadbiran
          </h3>
        </li>

        <li>
          <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary {{ request()->routeIs('admin.*') ? 'bg-accent-50 text-txt-accent border-l-4 border-accent-600' : 'text-txt-black-700 hover:text-txt-accent hover:bg-gray-50' }}"
            :class="{ 'justify-center': collapsed }"
            :title="collapsed ? 'Panel Admin' : ''"
            aria-current="{{ request()->routeIs('admin.*') ? 'page' : 'false' }}"
          >
            <svg
              class="h-5 w-5 flex-shrink-0"
              viewBox="0 0 20 20"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M10 3l2 4 4 .5-3 3 .7 4.5-3.7-2-3.7 2 .7-4.5-3-3 4-.5 2-4z"
              />
            </svg>
            <span class="ml-3" :class="{ 'hidden': collapsed }">
              Panel Admin
            </span>
          </a>
        </li>
      @endcan
    </ul>
  </nav>

  {{-- Sidebar Footer --}}
  <div class="p-4 border-t border-otl-divider">
    <div class="flex items-center" :class="{ 'justify-center': collapsed }">
      <img
        src="{{ asset('images/bpm-logo-50.png') }}"
        alt="BPM MOTAC"
        class="h-6 w-auto"
        :class="{ 'hidden': collapsed }"
      />
      <div
        class="h-6 w-6 bg-accent-600 rounded flex items-center justify-center"
        :class="{ 'hidden': !collapsed }"
        aria-hidden="true"
      >
        <span class="text-white text-xs font-bold">BPM</span>
      </div>
    </div>
    <p class="text-xs text-txt-black-500 mt-1" :class="{ 'hidden': collapsed }">
      Bahagian Pengurusan Maklumat
    </p>
  </div>
</aside>

{{-- Overlay for mobile --}}
<div
  x-show="!collapsed && $store.mobile?.isMobile"
  x-transition:enter="transition-opacity ease-linear duration-300"
  x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100"
  x-transition:leave="transition-opacity ease-linear duration-300"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  @click="collapsed = true"
  class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden"
  x-cloak
  aria-hidden="true"
></div>
