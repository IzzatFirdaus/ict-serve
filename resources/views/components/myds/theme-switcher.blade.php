@props(['position' => 'right', 'size' => 'md'])

@php
$buttonSizes = [
    'sm' => 'p-1',
    'md' => 'p-2',
    {{--
        MYDS Theme Switcher (Alpine.js) for ICTServe (iServe)
        - Props: position (left|right), size (sm|md|lg)
        - A11y: aria-expanded, aria-label, focus ring
        - No dependency on icon components (inline SVG for portability)
    --}}
    @props(['position' => 'right', 'size' => 'md'])

    @php
        $buttonSizes = ['sm' => 'p-1', 'md' => 'p-2', 'lg' => 'p-3'];
        $dropdownPositions = ['left' => 'right-0 origin-top-right', 'right' => 'left-0 origin-top-left'];
        $buttonSize = $buttonSizes[$size] ?? $buttonSizes['md'];
        $dropdownPosition = $dropdownPositions[$position] ?? $dropdownPositions['right'];
    @endphp

    <div class="relative"
             x-data="{
                    open: false,
                    theme: localStorage.getItem('theme') || 'system',
                    getThemeIcon() { return this.theme === 'dark' ? 'moon' : (this.theme === 'system' ? 'computer' : 'sun') },
                    getThemeLabel() { this.theme.charAt(0).toUpperCase() + this.theme.slice(1) },
                    toggle() { this.open = !this.open },
                    close() { this.open = false },
                    setTheme(t) {
                        this.theme = t;
                        localStorage.setItem('theme', t);
                        if (t === 'system') {
                            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                            document.documentElement.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
                        } else {
                            document.documentElement.setAttribute('data-theme', t === 'dark' ? 'dark' : 'light');
                        }
                    },
                    init() { this.setTheme(this.theme); }
             }"
             x-init="init()"
             @keydown.escape="close()"
             @click.outside="close()">

        <button
            @click="toggle()"
            class="{{ $buttonSize }} rounded-s txt-black-500 hover:txt-black-700 focus:outline-none focus:ring-2 focus:ring-fr-primary transition-colors"
            :aria-expanded="open.toString()"
            aria-haspopup="true"
            :aria-label="`Tema semasa: ${getThemeLabel()}. Klik untuk tukar.`"
            title="Tukar tema"
        >
            <template x-if="getThemeIcon() === 'sun'">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </template>
            <template x-if="getThemeIcon() === 'moon'">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </template>
            <template x-if="getThemeIcon() === 'computer'">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </template>
        </button>

        <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute {{ $dropdownPosition }} mt-2 w-48 rounded-m shadow-context-menu bg-white ring-1 ring-otl-gray-200 focus:outline-none z-50"
                 role="menu"
                 aria-orientation="vertical">

            <div class="p-1">
                <button
                    @click="setTheme('light'); close()"
                    class="flex items-center w-full px-3 py-2 text-sm rounded-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                    :class="{ 'bg-primary-50 txt-primary': theme === 'light', 'txt-black-700 hover:bg-black-100': theme !== 'light' }"
                    role="menuitem">
                    <svg class="w-4 h-4 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Light Mode
                    <svg x-show="theme === 'light'" class="w-4 h-4 ml-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <button
                    @click="setTheme('dark'); close()"
                    class="flex items-center w-full px-3 py-2 text-sm rounded-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                    :class="{ 'bg-primary-50 txt-primary': theme === 'dark', 'txt-black-700 hover:bg-black-100': theme !== 'dark' }"
                    role="menuitem">
                    <svg class="w-4 h-4 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Dark Mode
                    <svg x-show="theme === 'dark'" class="w-4 h-4 ml-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <button
                    @click="setTheme('system'); close()"
                    class="flex items-center w-full px-3 py-2 text-sm rounded-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                    :class="{ 'bg-primary-50 txt-primary': theme === 'system', 'txt-black-700 hover:bg-black-100': theme !== 'system' }"
                    role="menuitem">
                    <svg class="w-4 h-4 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    System Mode
                    <svg x-show="theme === 'system'" class="w-4 h-4 ml-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="px-4 py-3 border-t border-otl-gray-200">
                <p class="text-xs txt-black-500">
                    <span x-show="theme === 'system'">Ikut tetapan peranti anda</span>
                    <span x-show="theme === 'light'">Sentiasa paparan cerah</span>
                    <span x-show="theme === 'dark'">Sentiasa paparan gelap</span>
                </p>
            </div>
        </div>
    </div>
