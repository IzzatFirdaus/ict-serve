@props(['position' => 'right', 'size' => 'md'])

@php
$buttonSizes = [
    'sm' => 'p-1',
    'md' => 'p-2',
    'lg' => 'p-3'
];

$dropdownPositions = [
    'left' => 'right-0 origin-top-right',
    'right' => 'left-0 origin-top-left'
];

$buttonSize = $buttonSizes[$size] ?? $buttonSizes['md'];
$dropdownPosition = $dropdownPositions[$position] ?? $dropdownPositions['right'];
@endphp

<div class="relative"
     x-data="{
        ...themeManager(),
        ...themeDropdown(),
        mounted() {
            this.init();
        }
     }"
     x-init="mounted()"
     @keydown.escape="close()"
     @click.outside="close()">

    <!-- Theme Toggle Button -->
    <button
        @click="toggle()"
        class="{{ $buttonSize }} rounded-radius-s text-txt-black-500 hover:text-txt-black-700 focus:outline-none focus:ring-2 focus:ring-fr-primary dark:text-txt-black-500 dark:hover:text-txt-black-700 transition-colors"
        :aria-expanded="open.toString()"
        aria-haspopup="true"
        :aria-label="`Current theme: ${getThemeLabel()}. Click to change theme.`"
        title="Change theme"
    >
        <!-- Light Mode Icon -->
        <svg x-show="getThemeIcon() === 'sun'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>

        <!-- Dark Mode Icon -->
        <svg x-show="getThemeIcon() === 'moon'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>

        <!-- System Mode Icon -->
        <svg x-show="getThemeIcon() === 'computer'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute {{ $dropdownPosition }} mt-2 w-48 rounded-radius-m shadow-context-menu bg-bg-white-0 dark:bg-bg-white-0 ring-1 ring-otl-gray-200 dark:ring-otl-gray-200 focus:outline-none z-50"
         role="menu"
         aria-orientation="vertical"
         aria-labelledby="theme-menu-button">

        <div class="p-1">
            <!-- Light Theme Option -->
            <button
                @click="setTheme('light'); close()"
                class="flex items-center w-full px-3 py-2 text-body-sm rounded-radius-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                :class="{
                    'bg-primary-50 text-primary-700 dark:bg-primary-50 dark:text-primary-700': theme === 'light',
                    'text-txt-black-700 hover:bg-bg-white-50 dark:text-txt-black-700 dark:hover:bg-bg-white-50': theme !== 'light'
                }"
                role="menuitem">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Light Mode
                <svg x-show="theme === 'light'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Dark Theme Option -->
            <button
                @click="setTheme('dark'); close()"
                class="flex items-center w-full px-3 py-2 text-body-sm rounded-radius-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                :class="{
                    'bg-primary-50 text-primary-700 dark:bg-primary-50 dark:text-primary-700': theme === 'dark',
                    'text-txt-black-700 hover:bg-bg-white-50 dark:text-txt-black-700 dark:hover:bg-bg-white-50': theme !== 'dark'
                }"
                role="menuitem">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                Dark Mode
                <svg x-show="theme === 'dark'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- System Theme Option -->
            <button
                @click="setTheme('system'); close()"
                class="flex items-center w-full px-3 py-2 text-body-sm rounded-radius-s transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary"
                :class="{
                    'bg-primary-50 text-primary-700 dark:bg-primary-50 dark:text-primary-700': theme === 'system',
                    'text-txt-black-700 hover:bg-bg-white-50 dark:text-txt-black-700 dark:hover:bg-bg-white-50': theme !== 'system'
                }"
                role="menuitem">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                System Mode
                <svg x-show="theme === 'system'" class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <!-- Theme Description -->
        <div class="px-4 py-3 border-t border-otl-gray-200 dark:border-otl-gray-200">
            <p class="text-body-xs text-txt-black-500 dark:text-txt-black-500">
                <span x-show="theme === 'system'">Matches your device settings</span>
                <span x-show="theme === 'light'">Always uses light appearance</span>
                <span x-show="theme === 'dark'">Always uses dark appearance</span>
            </p>
        </div>
    </div>
</div>
