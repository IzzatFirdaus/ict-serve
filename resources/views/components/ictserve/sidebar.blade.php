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
            const savedState = localStorage.getItem('ictserve-sidebar-state');
            if (savedState) {
                const state = JSON.parse(savedState);
                this.collapsed = state.collapsed;
                this.pinned = state.pinned;
            }
        },
        toggle() {
            this.collapsed = !this.collapsed;
            this.saveState();
        },
        togglePin() {
            this.pinned = !this.pinned;
            this.saveState();
        },
        saveState() {
            localStorage.setItem('ictserve-sidebar-state', JSON.stringify({
                collapsed: this.collapsed,
                pinned: this.pinned
            }));
        },
        onMouseEnter() {
            if (this.collapsed && !this.pinned) {
                this.collapsed = false;
            }
        },
        onMouseLeave() {
            if (!this.pinned) {
                this.collapsed = true;
            }
        }
    }"
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
    <div class="flex items-center justify-between p-4 border-b border-otl-divider">
        {{-- ICTServe Logo --}}
        <div class="flex items-center" :class="{ 'justify-center': collapsed }">
            <div class="flex-shrink-0">
                <img 
                    src="{{ asset('images/ictserve-logo.svg') }}" 
                    alt="ICTServe (iServe)"
                    class="h-8 w-auto"
                    :class="{ 'hidden': collapsed }"
                >
                <img 
                    src="{{ asset('images/ictserve-icon.svg') }}" 
                    alt="ICTServe"
                    class="h-8 w-8"
                    :class="{ 'hidden': !collapsed }"
                >
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
                class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                :class="{ 'text-txt-primary bg-primary-50': pinned }"
                :title="pinned ? 'Lepaskan pin sidebar' : 'Pin sidebar'"
                :aria-label="pinned ? 'Lepaskan pin sidebar' : 'Pin sidebar'"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </button>

            <button
                @click="toggle()"
                class="p-2 rounded-md text-txt-black-500 hover:text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
                title="Lipat sidebar"
                aria-label="Lipat sidebar"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
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
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
                    :class="{ 'justify-center': collapsed }"
                    :title="collapsed ? 'Papan Pemuka' : ''"
                >
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H10a2 2 0 01-2-2V5z" />
                    </svg>
                    <span class="ml-3" :class="{ 'hidden': collapsed }">Papan Pemuka</span>
                </a>
            </li>

            {{-- Loan Applications --}}
            <li>
                <a 
                    href="{{ route('loans.index') }}" 
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group {{ request()->routeIs('loans.*') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
                    :class="{ 'justify-center': collapsed }"
                    :title="collapsed ? 'Pinjaman Peralatan' : ''"
                >
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    <span class="ml-3" :class="{ 'hidden': collapsed }">Pinjaman Peralatan</span>
                </a>
            </li>

            {{-- Helpdesk --}}
            <li>
                <a 
                    href="{{ route('helpdesk.index') }}" 
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group {{ request()->routeIs('helpdesk.*') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
                    :class="{ 'justify-center': collapsed }"
                    :title="collapsed ? 'Aduan Kerosakan' : ''"
                >
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-3" :class="{ 'hidden': collapsed }">Aduan Kerosakan</span>
                </a>
            </li>

            {{-- My Requests --}}
            <li>
                <a 
                    href="{{ route('my-requests') }}" 
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group {{ request()->routeIs('my-requests') ? 'bg-primary-50 text-txt-primary border-l-4 border-primary-600' : 'text-txt-black-700 hover:text-txt-primary hover:bg-gray-50' }}"
                    :class="{ 'justify-center': collapsed }"
                    :title="collapsed ? 'Permohonan Saya' : ''"
                >
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="ml-3" :class="{ 'hidden': collapsed }">Permohonan Saya</span>
                </a>
            </li>

            {{-- Admin Section (if user has admin role) --}}
            @can('admin-access')
                <li class="pt-4">
                    <div class="border-t border-otl-divider mb-4" :class="{ 'hidden': collapsed }"></div>
                    <h3 class="px-3 text-xs font-semibold text-txt-black-500 uppercase tracking-wider" :class="{ 'hidden': collapsed }">
                        Pentadbiran
                    </h3>
                </li>

                <li>
                    <a 
                        href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors group {{ request()->routeIs('admin.*') ? 'bg-accent-50 text-txt-accent border-l-4 border-accent-600' : 'text-txt-black-700 hover:text-txt-accent hover:bg-gray-50' }}"
                        :class="{ 'justify-center': collapsed }"
                        :title="collapsed ? 'Panel Admin' : ''"
                    >
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-3" :class="{ 'hidden': collapsed }">Panel Admin</span>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="p-4 border-t border-otl-divider">
        <div class="flex items-center" :class="{ 'justify-center': collapsed }">
            <img 
                src="{{ asset('images/bpm-logo.svg') }}" 
                alt="BPM MOTAC"
                class="h-6 w-auto"
                :class="{ 'hidden': collapsed }"
            >
            <div class="h-6 w-6 bg-accent-600 rounded flex items-center justify-center" :class="{ 'hidden': !collapsed }">
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
    x-show="!collapsed && $store.mobile.isMobile" 
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="collapsed = true"
    class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden"
    x-cloak
></div>