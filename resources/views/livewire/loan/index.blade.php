{{--
    ICTServe (iServe) – Loan Module Index
    MYDS & MyGovEA compliant: Accessible, semantic, visually clear, responsive, keyboard-friendly
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>
            <x-myds.icon name="inbox" class="w-6 h-6 mr-2" />
            Modul Peminjaman ICT
        </x-myds.masthead-title>
    </x-myds.masthead-header>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{
    activeTab: 'catalog',
    showFilters: false,
    searchQuery: '',
    selectedCategory: 'all'
}">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <h1 class="text-heading-lg font-semibold text-txt-black-900 flex items-center gap-2">
            <x-myds.icon name="inbox" class="w-6 h-6" />
            Modul Peminjaman
        </h1>
        <x-myds.button
            variant="primary"
            size="md"
            @click="window.showNotification('Permohonan baru akan dibuka', 'info')"
        >
            <x-myds.button-icon>
                <x-myds.icon name="plus" class="w-5 h-5" />
            </x-myds.button-icon>
            Permohonan Baru
        </x-myds.button>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-myds.card>
            <x-myds.card-body>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-primary-50">
                        <x-myds.icon name="clipboard-list" class="w-7 h-7 text-primary-600" />
                    </div>
                    <div>
                        <div class="text-body-xs text-txt-black-500">Permohonan Aktif</div>
                        <div class="text-heading-lg font-semibold text-txt-black-900">{{ $userLoanStats['pending'] ?? 0 }}</div>
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>
        <x-myds.card>
            <x-myds.card-body>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-success-50">
                        <x-myds.icon name="check-circle" class="w-7 h-7 text-success-600" />
                    </div>
                    <div>
                        <div class="text-body-xs text-txt-black-500">Sedang Dipinjam</div>
                        <div class="text-heading-lg font-semibold text-txt-black-900">{{ $userLoanStats['active'] ?? 0 }}</div>
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>
        <x-myds.card>
            <x-myds.card-body>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-warning-50">
                        <x-myds.icon name="clock" class="w-7 h-7 text-warning-600" />
                    </div>
                    <div>
                        <div class="text-body-xs text-txt-black-500">Perlu Pulangkan</div>
                        <div class="text-heading-lg font-semibold text-txt-black-900">{{ $userLoanStats['due_soon'] ?? 0 }}</div>
                    </div>
                </div>
            </x-myds.card-body>
        </x-myds.card>
    </div>

    {{-- Tabs (MYDS tabs component) --}}
    <x-myds.tabs variant="line" size="medium" class="mb-6">
        <x-myds.tabs-list>
            <x-myds.tabs-trigger
                value="catalog"
                :active="activeTab === 'catalog'"
                @click="activeTab = 'catalog'"
            >
                <x-myds.tabs-icon>
                    <x-myds.icon name="folder" />
                </x-myds.tabs-icon>
                Katalog Peralatan
            </x-myds.tabs-trigger>
            <x-myds.tabs-trigger
                value="my-loans"
                :active="activeTab === 'my-loans'"
                @click="activeTab = 'my-loans'"
            >
                <x-myds.tabs-icon>
                    <x-myds.icon name="archive" />
                </x-myds.tabs-icon>
                Peminjaman Saya
            </x-myds.tabs-trigger>
            <x-myds.tabs-trigger
                value="history"
                :active="activeTab === 'history'"
                @click="activeTab = 'history'"
            >
                <x-myds.tabs-icon>
                    <x-myds.icon name="clock" />
                </x-myds.tabs-icon>
                Sejarah
            </x-myds.tabs-trigger>
        </x-myds.tabs-list>

        {{-- Filters/Search --}}
        <div class="p-6 border-b otl-divider">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex-1 max-w-lg">
                    <x-myds.search-bar size="medium">
                        <x-myds.search-bar-input-container>
                            <x-myds.search-bar-input x-model="searchQuery" placeholder="Cari peralatan..." />
                            <x-myds.search-bar-search-button />
                        </x-myds.search-bar-input-container>
                    </x-myds.search-bar>
                </div>
                <div class="flex items-center gap-4">
                    <x-myds.button
                        type="button"
                        variant="secondary"
                        size="sm"
                        @click="showFilters = !showFilters"
                        aria-expanded="showFilters"
                        aria-controls="loan-filters"
                    >
                        <x-myds.button-icon>
                            <x-myds.icon name="filter" />
                        </x-myds.button-icon>
                        Tapis
                    </x-myds.button>
                </div>
            </div>
            {{-- Filters Panel --}}
            <div id="loan-filters" x-show="showFilters" x-transition class="mt-4 pt-4 border-t otl-divider">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-myds.field>
                        <x-myds.label for="category">Kategori</x-myds.label>
                        <x-myds.select id="category" x-model="selectedCategory">
                            <option value="all">Semua Kategori</option>
                            <option value="laptop">Laptop</option>
                            <option value="projector">Projektor</option>
                            <option value="camera">Kamera</option>
                            <option value="accessories">Aksesori</option>
                        </x-myds.select>
                    </x-myds.field>
                    <x-myds.field>
                        <x-myds.label for="availability">Ketersediaan</x-myds.label>
                        <x-myds.select id="availability">
                            <option value="all">Semua</option>
                            <option value="available">Tersedia</option>
                            <option value="borrowed">Sedang Dipinjam</option>
                            <option value="maintenance">Dalam Pembaikan</option>
                        </x-myds.select>
                    </x-myds.field>
                    <x-myds.field>
                        <x-myds.label for="sort">Susun mengikut</x-myds.label>
                        <x-myds.select id="sort">
                            <option value="name">Nama</option>
                            <option value="category">Kategori</option>
                            <option value="availability">Ketersediaan</option>
                        </x-myds.select>
                    </x-myds.field>
                </div>
            </div>
        </div>

        {{-- Tab Contents --}}
        <x-myds.tabs-content value="catalog" x-show="activeTab === 'catalog'" x-transition>
            <div class="text-center py-12">
                <x-myds.icon name="table" class="mx-auto h-12 w-12 text-txt-black-300" />
                <div class="mt-2 text-heading-xs text-txt-black-900">Katalog Peralatan</div>
                <div class="mt-1 text-body-sm text-txt-black-500">Senarai peralatan akan dipaparkan di sini.</div>
                <div class="mt-2 text-body-sm text-txt-black-500">
                    <template x-if="searchQuery">
                        <span>Mencari: "<span x-text="searchQuery"></span>"</span>
                    </template>
                    <template x-if="selectedCategory !== 'all'">
                        <span class="ml-2">Kategori: <span x-text="selectedCategory"></span></span>
                    </template>
                </div>
            </div>
        </x-myds.tabs-content>
        <x-myds.tabs-content value="my-loans" x-show="activeTab === 'my-loans'" x-transition>
            <div class="text-center py-12">
                <x-myds.icon name="archive" class="mx-auto h-12 w-12 text-txt-black-300" />
                <div class="mt-2 text-heading-xs text-txt-black-900">Peminjaman Saya</div>
                <div class="mt-1 text-body-sm text-txt-black-500">Senarai peminjaman anda akan dipaparkan di sini.</div>
            </div>
        </x-myds.tabs-content>
        <x-myds.tabs-content value="history" x-show="activeTab === 'history'" x-transition>
            <div class="text-center py-12">
                <x-myds.icon name="clock" class="mx-auto h-12 w-12 text-txt-black-300" />
                <div class="mt-2 text-heading-xs text-txt-black-900">Sejarah Peminjaman</div>
                <div class="mt-1 text-body-sm text-txt-black-500">Sejarah peminjaman anda akan dipaparkan di sini.</div>
            </div>
        </x-myds.tabs-content>
    </x-myds.tabs>
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
            <div class="mt-2 flex gap-3">
                <a href="#" aria-label="Facebook" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="facebook" class="w-5 h-5" /></a>
                <a href="#" aria-label="Twitter" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="twitter" class="w-5 h-5" /></a>
                <a href="#" aria-label="Instagram" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="instagram" class="w-5 h-5" /></a>
                <a href="#" aria-label="YouTube" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="youtube" class="w-5 h-5" /></a>
            </div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>
