{{-- Dashboard Main Component - MYDS Compliant --}}
<div class="min-h-screen bg-background-light">
    {{-- Header --}}
    <x-myds.header>
        <a href="{{ route('dashboard') }}" class="text-white hover:text-primary-200 flex items-center gap-2">
            <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7v10a2 2 0 002 2h10a2 2 0 002-2V7"/><path d="M12 3v4h5l-5-4z"/><path d="M7 3v4H2l5-4z"/></svg>' />
            Dashboard
        </a>
        <a href="{{ route('profile') }}" class="text-white hover:text-primary-200 flex items-center gap-2">
            <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' />
            Profile
        </a>
    </x-myds.header>

    {{-- Main Content --}}
    <main class="container mx-auto px-6 py-8">
        {{-- Page Title --}}
        <div class="mb-8">
            <h1 class="font-poppins text-2xl font-semibold text-black-900 mb-2">Dashboard ICTServe</h1>
            <p class="font-inter text-sm text-black-700">Selamat datang ke sistem pengurusan ICT MOTAC</p>
        </div>

        {{-- Dashboard Grid - MYDS 12-8-4 Grid System --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            {{-- Quick Access Widget --}}
            <livewire:dashboard.quick-access-widget />

            {{-- Status Widget --}}
            <livewire:dashboard.status-widget />

            {{-- Notification Widget --}}
            <livewire:dashboard.notification-widget />
        </div>

        {{-- Recent Activity Section --}}
        <div class="bg-white rounded-lg border border-divider p-6">
            <h2 class="font-poppins text-xl font-medium text-black-900 mb-4">Aktiviti Terkini</h2>
            <div class="space-y-4">
                {{-- Activity items will be populated by Livewire --}}
                <div class="flex items-center gap-4 p-3 bg-background-light rounded-md">
                    <x-myds.icon svg='<svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="9,11 12,14 22,4"/></svg>' />
                    <div class="flex-1">
                        <p class="font-inter text-sm text-black-900">Permohonan pinjaman peralatan telah diluluskan</p>
                        <p class="font-inter text-xs text-black-500">2 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <x-myds.footer />
</div>
