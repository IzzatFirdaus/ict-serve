export function searchComponent(config) {
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
        const response = await fetch(url, {
          headers: { Accept: 'application/json' },
        });
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();

        this.results = Array.isArray(data.results) ? data.results : [];
        this.totalResults = Number.isFinite(data.total)
          ? data.total
          : this.results.length;
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
        loan: 'Permohonan Pinjaman',
        ticket: 'Tiket Helpdesk',
        equipment: 'Peralatan ICT',
        user: 'Pengguna',
        document: 'Dokumen',
        other: 'Lain-lain',
      };
      return labels[category] || category;
    },

    getResultIconClasses(type) {
      const classes = {
        loan: 'bg-primary-100 text-txt-primary',
        ticket: 'bg-warning-100 text-txt-warning',
        equipment: 'bg-success-100 text-txt-success',
        user: 'bg-purple-100 text-purple-600',
        document: 'bg-gray-100 text-txt-black-500',
      };
      return classes[type] || 'bg-gray-100 text-txt-black-500';
    },

    getStatusBadgeClasses(status) {
      const classes = {
        pending: 'bg-warning-100 text-warning-800',
        approved: 'bg-success-100 text-success-800',
        rejected: 'bg-danger-100 text-danger-800',
        open: 'bg-primary-100 text-primary-800',
        closed: 'bg-gray-100 text-txt-black-700',
        completed: 'bg-success-100 text-success-800',
      };
      return classes[status] || 'bg-gray-100 text-txt-black-700';
    },

    handleFocus() {
      if (
        this.query.length >= config.minChars &&
        (this.results.length > 0 || this.hasNoResults)
      ) {
        this.showResults = true;
      }
    },

    highlightNext() {
      if (!this.showResults || this.results.length === 0) return;
      this.highlightedIndex = Math.min(
        this.highlightedIndex + 1,
        this.results.length - 1
      );
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
      const index = this.results.findIndex(
        (r) => (r.id ?? r.title) === (result.id ?? result.title)
      );
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
    },
  };
}
