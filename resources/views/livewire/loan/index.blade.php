<div class="space-y-6" x-data="{
    activeTab: 'catalog',
    showFilters: false,
    searchQuery: '',
    selectedCategory: 'all'
}">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Modul Peminjaman</h2>
        <button
            type="button"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
            @click="window.showNotification('Permohonan baru akan dibuka', 'info')"
        >
            Permohonan Baru
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">📋</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Permohonan Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $userLoanStats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Sedang Dipinjam</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $userLoanStats['active'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <span class="text-2xl">⏱️</span>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Perlu Pulangkan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $userLoanStats['due_soon'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Management Tabs with Alpine.js -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" role="tablist">
                <button
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    :class="activeTab === 'catalog' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    @click="activeTab = 'catalog'"
                    role="tab"
                >
                    Katalog Peralatan
                </button>
                <button
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    :class="activeTab === 'my-loans' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    @click="activeTab = 'my-loans'"
                    role="tab"
                >
                    Peminjaman Saya
                </button>
                <button
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors"
                    :class="activeTab === 'history' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                    @click="activeTab = 'history'"
                    role="tab"
                >
                    Sejarah
                </button>
            </nav>
        </div>

        <!-- Search and Filters -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex-1 max-w-lg">
                    <label for="search" class="sr-only">Cari peralatan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                            id="search"
                            name="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari peralatan..."
                            x-model="searchQuery"
                        >
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button
                        type="button"
                        class="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        @click="showFilters = !showFilters"
                    >
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Tapis
                    </button>
                </div>
            </div>

            <!-- Filters Panel -->
            <div x-show="showFilters" x-transition class="mt-4 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select
                            id="category"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            x-model="selectedCategory"
                        >
                            <option value="all">Semua Kategori</option>
                            <option value="laptop">Laptop</option>
                            <option value="projector">Projektor</option>
                            <option value="camera">Kamera</option>
                            <option value="accessories">Aksesori</option>
                        </select>
                    </div>
                    <div>
                        <label for="availability" class="block text-sm font-medium text-gray-700 mb-2">Ketersediaan</label>
                        <select
                            id="availability"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="all">Semua</option>
                            <option value="available">Tersedia</option>
                            <option value="borrowed">Sedang Dipinjam</option>
                            <option value="maintenance">Dalam Pembaikan</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Susun mengikut</label>
                        <select
                            id="sort"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="name">Nama</option>
                            <option value="category">Kategori</option>
                            <option value="availability">Ketersediaan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Catalog Tab -->
            <div x-show="activeTab === 'catalog'" x-transition>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Katalog Peralatan</h3>
                    <p class="mt-1 text-sm text-gray-500">Senarai peralatan akan dipaparkan di sini.</p>
                    <div class="mt-2 text-sm text-gray-500">
                        <template x-if="searchQuery">
                            <span>Mencari: "<span x-text="searchQuery"></span>"</span>
                        </template>
                        <template x-if="selectedCategory !== 'all'">
                            <span class="ml-2">Kategori: <span x-text="selectedCategory"></span></span>
                        </template>
                    </div>
                </div>
            </div>

            <!-- My Loans Tab -->
            <div x-show="activeTab === 'my-loans'" x-transition>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Peminjaman Saya</h3>
                    <p class="mt-1 text-sm text-gray-500">Senarai peminjaman anda akan dipaparkan di sini.</p>
                </div>
            </div>

            <!-- History Tab -->
            <div x-show="activeTab === 'history'" x-transition>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sejarah Peminjaman</h3>
                    <p class="mt-1 text-sm text-gray-500">Sejarah peminjaman anda akan dipaparkan di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>
