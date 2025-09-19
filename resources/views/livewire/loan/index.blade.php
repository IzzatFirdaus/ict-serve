<div
  class="space-y-6"
  x-data="{
    activeTab: 'catalog',
    showFilters: false,
    searchQuery: '',
    selectedCategory: 'all',
  }"
>
  <div class="flex items-center justify-between">
    <h2 class="text-2xl font-bold text-gray-900">Modul Peminjaman</h2>
    <button
      type="button"
      class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
      @click="window.showNotification('Permohonan baru akan dibuka', 'info')"
            ndow.showNotification('Permohonan baru akan dibuka', 'info')"
             Baru
            ts -->
            id grid-cols-1 md:grid-cols-3 gap-6">
            bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            ="flex items-center">
            "w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
            class="text-2xl">📋</span>
            ss="ml-4">
            ss="text-sm text-gray-600">Permohonan Aktif</p>
            ss="text-2xl font-semibold text-gray-900">
            Cw4f0QG2FZzF2SMyvy0SjjaSKNKk690xB
            bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            ="flex items-center">
            "w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
            class="text-2xl">✅</span>
            ss="ml-4">
            ss="text-sm text-gray-600">Sedang Dipinjam</p>
            ss="text-2xl font-semibold text-gray-900">
            lKTkUvJZeQqsNh1KG178cxWU4m8PgIaB
            bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            ="flex items-center">
            "w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center"
            class="text-2xl">⏱️</span>
            ss="ml-4">
            ss="text-sm text-gray-600">Perlu Pulangkan</p>
            ss="text-2xl font-semibold text-gray-900">
            LGUAy1EMildyI3R85Tvduk8ry7owourLzB
            gement Tabs with Alpine.js -->
            -white rounded-lg shadow-sm border border-gray-200">
            border-b border-gray-200">
            ="flex space-x-8 px-6" role="tablist">
            "py-4 px-1 border-b-2 font-medium text-sm transition-colors"
            ="activeTab === 'catalog' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            ="activeTab = 'catalog'"
            tab"
            O7aBk345cGEHkFODBeFnhTCfQ41BESQwSJmB />
            >
            "py-4 px-1 border-b-2 font-medium text-sm transition-colors"
            ="activeTab === 'my-loans' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            ="activeTab = 'my-loans'"
            tab"
            aman Saya
            >
            "py-4 px-1 border-b-2 font-medium text-sm transition-colors"
            ="activeTab === 'history' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
            ="activeTab = 'history'"
            tab"
            h
            >
            and Filters -->
            p-6 border-b border-gray-100">
            lex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0"
            ss="flex-1 max-w-lg">
             for="search" class="sr-only">Cari peralatan</label>
            lass="relative">
            ass="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
            vg
            class="h-5 w-5 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            ></path>
            svg>
            v>
            ut
            ="search"
            me="search"
            ass="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
            aceholder="Cari peralatan..."
            model="searchQuery"
            ss="flex items-center space-x-4">
            n
            ="button"
            s="flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            ck="showFilters = !showFilters"
            ass="mr-2 h-4 w-4"
            ll="none"
            roke="currentColor"
            ewBox="0 0 24 24"
            ath
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
            /path>
            g>
            s
            on>
            rs Panel -->
            BZ2WoonSpMx3BB"
            tion
            t-4 pt-4 border-t border-gray-100"
            ss="grid grid-cols-1 md:grid-cols-3 gap-4">
            el
            r="category"
            ass="block text-sm font-medium text-gray-700 mb-2"
            tegori
            bel>
            ect
            ="category"
            ass="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            model="selectedCategory"
            ption value="all">Semua Kategori</option>
            ption value="laptop">Laptop</option>
            ption value="projector">Projektor</option>
            ption value="camera">Kamera</option>
            ption value="accessories">Aksesori</option>
            lect>
            el
            r="availability"
            ass="block text-sm font-medium text-gray-700 mb-2"
            tersediaan
            bel>
            ect
            ="availability"
            ass="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ption value="all">Semua</option>
            ption value="available">Tersedia</option>
            ption value="borrowed">Sedang Dipinjam</option>
            ption value="maintenance">Dalam Pembaikan</option>
            lect>
            el
            r="sort"
            ass="block text-sm font-medium text-gray-700 mb-2"
            sun mengikut
            bel>
            ect
            ="sort"
            ass="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ption value="name">Nama</option>
            ption value="category">Kategori</option>
            ption value="availability">Ketersediaan</option>
            lect>
            tent -->
            p-6">
            og Tab -->
            w="activeTab === 'catalog'" x-transition>
            ss="text-center py-12">
            s="mx-auto h-12 w-12 text-gray-400"
            ="none"
            ke="currentColor"
            Box="0 0 24 24"
            h
            roke-linecap="round"
            roke-linejoin="round"
            roke-width="2"
            "M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"
            ath>
            ass="mt-2 text-sm font-medium text-gray-900">
            log Peralatan
            ss="mt-1 text-sm text-gray-500">
            ktJ5MrNiNHHJ6WEDKUss1QPNxrOq0nSlLCUoZj8AZoYsb0YeFB
            lass="mt-2 text-sm text-gray-500">
            plate x-if="searchQuery">
            pan>
            Mencari: "
            <span x-text="searchQuery"></span>
            "
              </span>
            </template>
            <template x-if="selectedCategory !== 'all'">
              <span class="ml-2">
                Kategori:
                <span x-text="selectedCategory"></span>
              </span>
            </template>
          </div>
        </div>
      </div>

      <!-- My Loans Tab -->
      <div x-show="activeTab === 'my-loans'" x-transition>
        <div class="text-center py-12">
          <svg
            class="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            ></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">
            Peminjaman Saya
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            Senarai peminjaman anda akan dipaparkan di sini.
          </p>
        </div>
      </div>

      <!-- History Tab -->
      <div x-show="activeTab === 'history'" x-transition>
        <div class="text-center py-12">
          <svg
            class="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">
            Sejarah Peminjaman
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            Sejarah peminjaman anda akan dipaparkan di sini.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
