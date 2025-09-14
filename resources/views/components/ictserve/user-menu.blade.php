@props([
    'user' => null,
    'placement' => 'bottom-end',
    'showAvatar' => true,
    'showNotifications' => true,
    'notificationCount' => 0,
])

@php
$currentUser = $user ?? auth()->user();
$hasNotifications = $showNotifications && $notificationCount > 0;
@endphp

<div 
    class="user-menu relative"
    x-data="userMenu()"
    @click.away="open = false"
    {{ $attributes }}
>
    {{-- User Profile Button --}}
    <button
        @click="open = !open"
        class="flex items-center space-x-3 text-sm rounded-lg px-3 py-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-300 transition-colors duration-200"
        :class="{ 'bg-gray-100': open }"
        aria-expanded="false"
        aria-haspopup="true"
        id="user-menu-button"
    >
        {{-- User Avatar --}}
        @if($showAvatar)
            <div class="flex-shrink-0">
                @if($currentUser && $currentUser->avatar)
                    <img 
                        class="h-8 w-8 rounded-full object-cover"
                        src="{{ asset('storage/' . $currentUser->avatar) }}"
                        alt="Avatar {{ $currentUser->name }}"
                    />
                @else
                    <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                        <span class="text-sm font-medium text-white">
                            {{ $currentUser ? strtoupper(substr($currentUser->name, 0, 1)) : 'U' }}
                        </span>
                    </div>
                @endif
            </div>
        @endif

        {{-- User Info --}}
        <div class="hidden md:block text-left">
            <div class="font-medium text-gray-900">
                {{ $currentUser->name ?? 'Pengguna' }}
            </div>
            <div class="text-xs text-gray-500">
                {{ $currentUser->email ?? 'user@example.com' }}
            </div>
        </div>

        {{-- Dropdown Arrow --}}
        <svg 
            class="h-4 w-4 text-gray-400 transition-transform duration-200"
            :class="{ 'rotate-180': open }"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Notifications Button --}}
    @if($showNotifications)
        <button 
            @click="showNotifications = !showNotifications"
            class="ml-2 relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-300 transition-colors duration-200"
            aria-label="Notifikasi"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 19.5L21 9 12 2.25 5.25 7.5H15l-4.5 12z"/>
            </svg>
            
            {{-- Notification Badge --}}
            @if($hasNotifications)
                <span class="absolute -top-1 -right-1 h-5 w-5 bg-danger-600 text-white text-xs rounded-full flex items-center justify-center">
                    {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                </span>
            @endif
        </button>
    @endif

    {{-- Dropdown Menu --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        x-cloak
    >
        {{-- User Profile Header --}}
        <div class="px-4 py-3 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    @if($currentUser && $currentUser->avatar)
                        <img 
                            class="h-10 w-10 rounded-full object-cover"
                            src="{{ asset('storage/' . $currentUser->avatar) }}"
                            alt="Avatar {{ $currentUser->name }}"
                        />
                    @else
                        <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                            <span class="text-lg font-medium text-white">
                                {{ $currentUser ? strtoupper(substr($currentUser->name, 0, 1)) : 'U' }}
                            </span>
                        </div>
                    @endif
                </div>
                
                {{-- User Details --}}
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 truncate">
                        {{ $currentUser->name ?? 'Pengguna' }}
                    </div>
                    <div class="text-sm text-gray-500 truncate">
                        {{ $currentUser->email ?? 'user@example.com' }}
                    </div>
                    @if($currentUser && $currentUser->staff_id)
                        <div class="text-xs text-gray-400">
                            ID Staff: {{ $currentUser->staff_id }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Menu Items --}}
        <div class="py-1">
            {{-- Profile Link --}}
            <a 
                href="{{ route('profile.show') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil Saya
            </a>

            {{-- Settings Link --}}
            <a 
                href="{{ route('settings.index') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Tetapan
            </a>

            {{-- My Applications --}}
            <a 
                href="{{ route('loans.my-applications') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Permohonan Saya
            </a>

            {{-- My Tickets --}}
            <a 
                href="{{ route('helpdesk.my-tickets') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Tiket Saya
            </a>

            {{-- Divider --}}
            <div class="border-t border-gray-100 my-1"></div>

            {{-- Help Center --}}
            <a 
                href="{{ route('help.index') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pusat Bantuan
            </a>

            {{-- Documentation --}}
            <a 
                href="{{ route('docs.index') }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                role="menuitem"
            >
                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Dokumentasi
            </a>

            {{-- Divider --}}
            <div class="border-t border-gray-100 my-1"></div>

            {{-- Sign Out --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm text-danger-600 hover:bg-danger-50 transition-colors duration-200"
                    role="menuitem"
                >
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Notifications Panel --}}
    @if($showNotifications)
        <div
            x-show="showNotifications"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
            @click.away="showNotifications = false"
            x-cloak
        >
            {{-- Notifications Header --}}
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                @if($hasNotifications)
                    <button 
                        @click="markAllAsRead()"
                        class="text-xs text-primary-600 hover:text-primary-800"
                    >
                        Tanda Semua Dibaca
                    </button>
                @endif
            </div>

            {{-- Notifications List --}}
            <div class="max-h-64 overflow-y-auto">
                @if($hasNotifications)
                    {{-- Sample Notifications --}}
                    <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-2 w-2 bg-primary-600 rounded-full mt-2"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Permohonan pinjaman anda telah diluluskan</p>
                                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-4 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 19.5L21 9 12 2.25 5.25 7.5H15l-4.5 12z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Tiada notifikasi baharu</p>
                    </div>
                @endif
            </div>

            {{-- View All Link --}}
            @if($hasNotifications)
                <div class="px-4 py-3 border-t border-gray-100">
                    <a 
                        href="{{ route('notifications.index') }}"
                        class="text-sm text-primary-600 hover:text-primary-800 font-medium"
                    >
                        Lihat Semua Notifikasi
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>

<script>
function userMenu() {
    return {
        open: false,
        showNotifications: false,
        
        markAllAsRead() {
            // Handle mark all notifications as read
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    this.showNotifications = false;
                    // Refresh notification count
                    window.location.reload();
                }
            });
        }
    }
}
</script>