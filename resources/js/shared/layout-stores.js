/**
 * Alpine.js Global Stores for ICTServe Layout
 * Manages loading states, mobile detection, and sidebar state
 * MYDS-compliant responsive behavior and accessibility features
 */

/**
 * Initialize Alpine.js stores for the ICTServe layout
 * Call this after Alpine.js is loaded
 */
function initializeLayoutStores() {
  // Ensure Alpine is available
  if (typeof Alpine === 'undefined') {
    console.error('Alpine.js is required for layout stores');
    return;
  }

  // Loading state store
  Alpine.store('loading', {
    isLoading: false,

    show() {
      this.isLoading = true;
    },

    hide() {
      this.isLoading = false;
    },
  });

  // Mobile detection store
  Alpine.store('mobile', {
    isMobile: window.innerWidth < 1024,

    init() {
      // Listen for resize events to update mobile state
      window.addEventListener('resize', () => {
        this.isMobile = window.innerWidth < 1024;
      });
    },
  });

  // Sidebar state management store
  Alpine.store('sidebar', {
    collapsed: false,
    pinned: false,

    toggle() {
      this.collapsed = !this.collapsed;
      this.saveState();
    },

    pin() {
      this.pinned = true;
      this.saveState();
    },

    unpin() {
      this.pinned = false;
      this.saveState();
    },

    /**
     * Save sidebar state to localStorage
     * Follows MYDS preferences persistence guidelines
     */
    saveState() {
      try {
        localStorage.setItem(
          'ictserve-sidebar-state',
          JSON.stringify({
            collapsed: this.collapsed,
            pinned: this.pinned,
          })
        );
      } catch (error) {
        console.warn('Could not save sidebar state to localStorage:', error);
      }
    },

    /**
     * Load sidebar state from localStorage
     * Gracefully handles missing or corrupted data
     */
    loadState() {
      try {
        const saved = localStorage.getItem('ictserve-sidebar-state');
        if (saved) {
          const state = JSON.parse(saved);
          this.collapsed = Boolean(state.collapsed);
          this.pinned = Boolean(state.pinned);
        }
      } catch (error) {
        console.warn('Could not load sidebar state from localStorage:', error);
      }
    },
  });
}

/**
 * Initialize stores and their dependencies
 * Call this on DOMContentLoaded
 */
function initializeStores() {
  document.addEventListener('alpine:init', () => {
    initializeLayoutStores();
  });

  // Initialize after DOM is loaded
  document.addEventListener('DOMContentLoaded', function () {
    // Wait for Alpine to be fully initialized
    if (Alpine && Alpine.store) {
      const mobileStore = Alpine.store('mobile');
      const sidebarStore = Alpine.store('sidebar');

      if (mobileStore && typeof mobileStore.init === 'function') {
        mobileStore.init();
      }

      if (sidebarStore && typeof sidebarStore.loadState === 'function') {
        sidebarStore.loadState();
      }
    }
  });
}

// Auto-initialize if this script is loaded directly
if (typeof window !== 'undefined') {
  initializeStores();
}

// Export for module usage
export { initializeLayoutStores, initializeStores };
