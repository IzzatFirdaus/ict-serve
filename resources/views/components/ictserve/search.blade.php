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
            <svg 
                class="h-4 w-4 text-gray-400"
                :class="{ 'animate-spin': loading }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path 
                    x-show="!loading"
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
                <path 
                    x-show="loading"
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                />
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
            class="block w-full {{ $inputClasses }} pl-10 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-300 placeholder-gray-500"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            role="combobox"
            aria-expanded="false"
            aria-haspopup="listbox"
            :aria-expanded="showResults"
        />
        
        {{-- Clear Button --}}
        <button
            x-show="query.length > 0"
            @click="clearSearch()"
            class="absolute inset-y-0 right-0 pr-3 flex items-center"
            type="button"
            tabindex="-1"
        >
            <svg class="h-4 w-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
        class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 max-h-96 overflow-y-auto"
        role="listbox"
        x-cloak
    >
        {{-- Results by Category --}}
        @if($showCategories)
            <template x-for="(categoryResults, category) in groupedResults" :key="category">
                <div class="py-2">
                    {{-- Category Header --}}
                    <div class="px-4 py-2 text-xs font-medium text-gray-500 uppercase tracking-wide bg-gray-50 border-b border-gray-100">
                        <span x-text="getCategoryLabel(category)"></span>
                        <span class="ml-1 text-gray-400" x-text="'(' + categoryResults.length + ')'"></span>
                    </div>
                    
                    {{-- Category Results --}}
                    <template x-for="(result, index) in categoryResults.slice(0, maxResults)" :key="result.id">
                        <a
                            :href="result.url"
                            @click="selectResult(result)"
                            class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-b-0"
                            :class="{ 'bg-primary-50': isHighlighted(result) }"
                            role="option"
                        >
                            {{-- Result Icon --}}
                            <div class="flex-shrink-0 mr-3">
                                <div 
                                    class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    :class="getResultIconClasses(result.type)"
                                >
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path x-show="result.type === 'loan'" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        <path x-show="result.type === 'ticket'" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        <path x-show="result.type === 'equipment'" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        <path x-show="result.type === 'user'" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        <path x-show="!['loan', 'ticket', 'equipment', 'user'].includes(result.type)" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            
                            {{-- Result Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900" x-text="result.title"></div>
                                <div class="text-xs text-gray-500 mt-1" x-text="result.description"></div>
                                <div class="text-xs text-gray-400 mt-1" x-show="result.meta">
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
            <template x-for="(result, index) in results.slice(0, maxResults)" :key="result.id">
                <a
                    :href="result.url"
                    @click="selectResult(result)"
                    class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-b-0"
                    :class="{ 'bg-primary-50': highlightedIndex === index }"
                    role="option"
                >
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900" x-text="result.title"></div>
                        <div class="text-xs text-gray-500 mt-1" x-text="result.description"></div>
                    </div>
                </a>
            </template>
        @endif

        {{-- No Results --}}
        <div x-show="hasNoResults" class="px-4 py-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="mt-2 text-sm text-gray-600">Tiada hasil ditemui untuk "<span x-text="query"></span>"</p>
            <p class="text-xs text-gray-500 mt-1">Cuba gunakan kata kunci yang berbeza</p>
        </div>

        {{-- View All Results --}}
        <div x-show="results.length >= maxResults" class="border-t border-gray-100 px-4 py-3">
            <a 
                :href="'/search?q=' + encodeURIComponent(query)"
                class="text-sm text-primary-600 hover:text-primary-800 font-medium"
            >
                Lihat semua hasil (<span x-text="totalResults"></span>)
            </a>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div
        x-show="loading && showResults"
        class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 px-4 py-8"
        x-cloak
    >
        <div class="flex items-center justify-center">
            <svg class="animate-spin h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="ml-2 text-sm text-gray-600">Mencari...</span>
        </div>
    </div>
</div>

<script>
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
            
            if (this.query.length < config.minChars) {
                this.showResults = false;
                this.hasNoResults = false;
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
                const response = await fetch(`${config.endpoint}?q=${encodeURIComponent(this.query)}&limit=${config.maxResults}`);
                const data = await response.json();
                
                this.results = data.results || [];
                this.totalResults = data.total || this.results.length;
                this.groupedResults = this.groupResultsByCategory(this.results);
                this.hasNoResults = this.results.length === 0;
                this.highlightedIndex = -1;
                
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
                this.hasNoResults = true;
            } finally {
                this.loading = false;
            }
        },
        
        groupResultsByCategory(results) {
            return results.reduce((groups, result) => {
                const category = result.type || 'other';
                if (!groups[category]) {
                    groups[category] = [];
                }
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
                'loan': 'bg-blue-100 text-blue-600',
                'ticket': 'bg-orange-100 text-orange-600',
                'equipment': 'bg-green-100 text-green-600',
                'user': 'bg-purple-100 text-purple-600',
                'document': 'bg-gray-100 text-gray-600'
            };
            return classes[type] || 'bg-gray-100 text-gray-600';
        },
        
        getStatusBadgeClasses(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'approved': 'bg-green-100 text-green-800',
                'rejected': 'bg-red-100 text-red-800',
                'open': 'bg-blue-100 text-blue-800',
                'closed': 'bg-gray-100 text-gray-800',
                'completed': 'bg-green-100 text-green-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },
        
        handleFocus() {
            if (this.query.length >= config.minChars && this.results.length > 0) {
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
            
            if (result) {
                this.showResults = false;
                window.location.href = result.url;
            }
        },
        
        isHighlighted(result) {
            const index = this.results.findIndex(r => r.id === result.id);
            return index === this.highlightedIndex;
        },
        
        clearSearch() {
            this.query = '';
            this.results = [];
            this.showResults = false;
            this.hasNoResults = false;
            this.highlightedIndex = -1;
        }
    }
}
</script>