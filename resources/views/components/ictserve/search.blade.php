@props([
    'placeholder' => 'Cari...',
    'endpoint' => '/search',
    'minChars' => 2,
    'debounce' => 300,
    'showCategories' => true,
    'maxResults' => 8,
    'size' => 'md', // 'sm', 'md', 'lg'
])

@php
$sizeClasses = [
    'sm' => 'h-8 text-sm',
    'md' => 'h-10 text-sm',
    'lg' => 'h-12 text-base'
];

$inputClasses = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div
    class="search-component relative"
    x-data="searchComponent({
        endpoint: '{{ $endpoint }}',
        minChars: {{ $minChars }},
        debounce: {{ $debounce }},
        maxResults: {{ $maxResults }}
    })"
    @click.away="showResults = false"
    {{ $attributes }}
>
    {{-- Search Input --}}
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            {{-- MYDS Icon 20x20, stroke 1.5 --}}
            <svg
                class="h-4 w-4 text-txt-black-400"
                :class="{ 'animate-spin': loading }"
                viewBox="0 0 20 20"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                aria-hidden="true"
            >
                <template x-if="!loading">
                    <g>
                        <circle cx="8" cy="8" r="5"></circle>
                        <path stroke-linecap="round" d="M12 12l4 4"></path>
                    </g>
                </template>
                <template x-if="loading">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v4m12 0A6 6 0 104 8h4m8 8v-4m0 0A6 6 0 018 16v-4" />
                </template>
            </svg>
        </div>

        <input
            x-model="query"
            @input="search()"
            @focus="handleFocus()"
            @keydown.arrow-down.prevent="highlightNext()"
            @keydown.arrow-up.prevent="highlightPrevious()"
            @keydown.enter.prevent="selectResult()"
            @keydown.escape="showResults = false"
            type="text"
            class="block w-full {{ $inputClasses }} pl-10 pr-9 border border-otl-gray-300 rounded-lg focus-visible:ring-2 focus-visible:ring-fr-primary focus-visible:outline-none placeholder-txt-black-500"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            role="combobox"
            aria-expanded="false"
            aria-haspopup="listbox"
            :aria-expanded="showResults"
            :aria-activedescendant="highlightedIndex >= 0 ? ('search-result-' + (results[highlightedIndex]?.id || highlightedIndex)) : null"
            aria-controls="search-results-listbox"
            aria-label="Carian"
        />

        {{-- Clear Button --}}
        <button
            x-show="query.length > 0"
            @click="clearSearch()"
            class="absolute inset-y-0 right-0 pr-3 flex items-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
            type="button"
            tabindex="-1"
            aria-label="Kosongkan carian"
        >
            {{-- MYDS close icon 20x20, 1.5 stroke --}}
            <svg class="h-4 w-4 text-txt-black-400 hover:text-txt-black-600" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 14l8-8M6 6l8 8"/>
            </svg>
        </button>
    </div>

    {{-- Search Results Dropdown --}}
    <div
        x-show="showResults && (results.length > 0 || hasNoResults)"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-bg-white rounded-lg shadow-context-menu ring-1 ring-otl-divider max-h-96 overflow-y-auto"
        role="listbox"
        id="search-results-listbox"
        x-cloak
        aria-label="Keputusan carian"
    >
        {{-- Results by Category --}}
        @if($showCategories)
            <template x-for="(categoryResults, category) in groupedResults" :key="category">
                <div class="py-2">
                    {{-- Category Header --}}
                    <div class="px-4 py-2 text-xs font-medium text-txt-black-500 uppercase tracking-wide bg-gray-50 border-b border-otl-divider">
                        <span x-text="getCategoryLabel(category)"></span>
                        <span class="ml-1 text-txt-black-400" x-text="'(' + categoryResults.length + ')'"></span>
                    </div>

                    {{-- Category Results --}}
                    <template x-for="(result, index) in categoryResults.slice(0, maxResults)" :key="result.id || ('c' + category + '-' + index)">
                        <a
                            :id="'search-result-' + (result.id || index)"
                            :href="result.url"
                            @click="selectResult(result)"
                            class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-b-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                            :class="{ 'bg-primary-50': isHighlighted(result) }"
                            role="option"
                            :aria-selected="isHighlighted(result)"
                        >
                            {{-- Result Icon --}}
                            <div class="flex-shrink-0 mr-3">
                                <div
                                    class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    :class="getResultIconClasses(result.type)"
                                    aria-hidden="true"
                                >
                                    {{-- Generic multi-type glyph using MYDS icon guidelines --}}
                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path x-show="result.type === 'loan'" d="M8 14l2 2 4-4a6 6 0 10-6-6v8z"/>
                                        <path x-show="result.type === 'ticket'" d="M3 7h14a2 2 0 010 4H3a2 2 0 010-4zM5 13h10v2H5z"/>
                                        <path x-show="result.type === 'equipment'" d="M3 6h14v8a2 2 0 01-2 2H5a2 2 0 01-2-2V6zM5 3h10v3H5z"/>
                                        <path x-show="result.type === 'user'" d="M10 2a4 4 0 110 8 4 4 0 010-8zm-6 14a6 6 0 1112 0H4z"/>
                                        <path x-show="!['loan','ticket','equipment','user'].includes(result.type)" d="M10 2a8 8 0 100 16 8 8 0 000-16z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Result Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-txt-black-900" x-text="result.title"></div>
                                <div class="text-xs text-txt-black-500 mt-1" x-text="result.description"></div>
                                <div class="text-xs text-txt-black-400 mt-1" x-show="result.meta">
                                    <span x-text="result.meta"></span>
                                </div>
                            </div>

                            {{-- Result Status Badge --}}
                            <div class="flex-shrink-0 ml-3" x-show="result.status">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                    :class="getStatusBadgeClasses(result.status)"
                                    x-text="result.status"
                                ></span>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
        @else
            {{-- Simple Results List --}}
            <template x-for="(result, index) in results.slice(0, maxResults)" :key="result.id || index">
                <a
                    :id="'search-result-' + (result.id || index)"
                    :href="result.url"
                    @click="selectResult(result)"
                    class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-b-0 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
                    :class="{ 'bg-primary-50': highlightedIndex === index }"
                    role="option"
                    :aria-selected="highlightedIndex === index"
                >
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-txt-black-900" x-text="result.title"></div>
                        <div class="text-xs text-txt-black-500 mt-1" x-text="result.description"></div>
                    </div>
                </a>
            </template>
        @endif

        {{-- No Results --}}
        <div x-show="hasNoResults" class="px-4 py-8 text-center">
            {{-- MYDS search icon 20x20 --}}
            <svg class="mx-auto h-12 w-12 text-txt-black-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <circle cx="8" cy="8" r="5"></circle>
                <path stroke-linecap="round" d="M12 12l4 4"></path>
            </svg>
            <p class="mt-2 text-sm text-txt-black-600">Tiada hasil ditemui untuk "<span x-text="query"></span>"</p>
            <p class="text-xs text-txt-black-500 mt-1">Cuba gunakan kata kunci yang berbeza</p>
        </div>

        {{-- View All Results --}}
        <div x-show="results.length >= maxResults" class="border-t border-otl-divider px-4 py-3">
            <a
                :href="'/search?q=' + encodeURIComponent(query)"
                class="text-sm text-txt-primary hover:text-primary-800 font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
            >
                Lihat semua hasil (<span x-text="totalResults"></span>)
            </a>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div
        x-show="loading && showResults"
        class="absolute z-50 w-full mt-1 bg-bg-white rounded-lg shadow-context-menu ring-1 ring-otl-divider px-4 py-8"
        x-cloak
        role="status"
        aria-live="polite"
        aria-label="Sedang mencari"
    >
        <div class="flex items-center justify-center">
            {{-- MYDS spinner --}}
            <svg class="animate-spin h-6 w-6 text-txt-primary" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <circle cx="10" cy="10" r="8" class="opacity-25"></circle>
                <path class="opacity-75" stroke-linecap="round" d="M10 2a8 8 0 018 8" />
            </svg>
            <span class="ml-2 text-sm text-txt-black-600">Mencari...</span>
        </div>
    </div>
</div>

<script>
/**
 * Accessible, tokenized MYDS-compliant search component.
 * - Keyboard: Up/Down to navigate, Enter to select, Esc to close
 * - ARIA: Proper combobox/listbox roles and relationships
 * - Performance: Debounced fetch with graceful error handling
 */
function searchComponent(config) {
    return {
        query: '',
        results: [],
        groupedResults: {},
        loading: false,
        showResults: false,
        hasNoResults: false,
        highlightedIndex: -1,
        totalResults: 0,
        searchTimeout: null,

        search() {
            clearTimeout(this.searchTimeout);

            if ((this.query || '').trim().length < config.minChars) {
                this.showResults = false;
                this.hasNoResults = false;
                this.results = [];
                this.groupedResults = {};
                this.highlightedIndex = -1;
                return;
            }

            this.searchTimeout = setTimeout(() => {
                this.performSearch();
            }, config.debounce);
        },

        async performSearch() {
            this.loading = true;
            this.showResults = true;

            try {
                const url = `${config.endpoint}?q=${encodeURIComponent(this.query)}&limit=${config.maxResults}`;
                const response = await fetch(url, { headers: { 'Accept': 'application/json' }});
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();

                this.results = Array.isArray(data.results) ? data.results : [];
                this.totalResults = Number.isFinite(data.total) ? data.total : this.results.length;
                this.groupedResults = this.groupResultsByCategory(this.results);
                this.hasNoResults = this.results.length === 0;
                this.highlightedIndex = -1;

            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
                this.groupedResults = {};
                this.hasNoResults = true;
                this.totalResults = 0;
            } finally {
                this.loading = false;
            }
        },

        groupResultsByCategory(results) {
            return results.reduce((groups, result) => {
                const category = result.type || 'other';
                if (!groups[category]) groups[category] = [];
                groups[category].push(result);
                return groups;
            }, {});
        },

        getCategoryLabel(category) {
            const labels = {
                'loan': 'Permohonan Pinjaman',
                'ticket': 'Tiket Helpdesk',
                'equipment': 'Peralatan ICT',
                'user': 'Pengguna',
                'document': 'Dokumen',
                'other': 'Lain-lain'
            };
            return labels[category] || category;
        },

        getResultIconClasses(type) {
            const classes = {
                'loan': 'bg-primary-100 text-txt-primary',
                'ticket': 'bg-warning-100 text-txt-warning',
                'equipment': 'bg-success-100 text-txt-success',
                'user': 'bg-purple-100 text-purple-600',
                'document': 'bg-gray-100 text-txt-black-500'
            };
            return classes[type] || 'bg-gray-100 text-txt-black-500';
        },

        getStatusBadgeClasses(status) {
            const classes = {
                'pending': 'bg-warning-100 text-warning-800',
                'approved': 'bg-success-100 text-success-800',
                'rejected': 'bg-danger-100 text-danger-800',
                'open': 'bg-primary-100 text-primary-800',
                'closed': 'bg-gray-100 text-txt-black-700',
                'completed': 'bg-success-100 text-success-800'
            };
            return classes[status] || 'bg-gray-100 text-txt-black-700';
        },

        handleFocus() {
            if (this.query.length >= config.minChars && (this.results.length > 0 || this.hasNoResults)) {
                this.showResults = true;
            }
        },

        highlightNext() {
            if (!this.showResults || this.results.length === 0) return;
            this.highlightedIndex = Math.min(this.highlightedIndex + 1, this.results.length - 1);
        },

        highlightPrevious() {
            if (!this.showResults || this.results.length === 0) return;
            this.highlightedIndex = Math.max(this.highlightedIndex - 1, -1);
        },

        selectResult(result = null) {
            if (!result && this.highlightedIndex >= 0) {
                result = this.results[this.highlightedIndex];
            }
            if (result && result.url) {
                this.showResults = false;
                window.location.href = result.url;
            }
        },

        isHighlighted(result) {
            const index = this.results.findIndex(r => (r.id ?? r.title) === (result.id ?? result.title));
            return index === this.highlightedIndex;
        },

        clearSearch() {
            this.query = '';
            this.results = [];
            this.groupedResults = {};
            this.showResults = false;
            this.hasNoResults = false;
            this.highlightedIndex = -1;
            this.totalResults = 0;
        }
    }
}
</script>
