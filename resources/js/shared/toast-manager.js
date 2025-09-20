/**
 * Toast Manager for ICTServe (iServe)
 * MYDS-compliant toast notification system using Alpine.js
 * Follows accessibility and WCAG guidelines
 */

/**
 * Alpine.js data function for toast management
 * @returns {Object} Toast manager Alpine data
 */
function toastManager() {
  return {
    toasts: [],

    /**
     * Add a new toast notification
     * @param {string} type - Toast type: 'success', 'error', 'warning', 'info'
     * @param {string} title - Toast title
     * @param {string} message - Toast message content
     * @param {number} duration - Auto-dismiss duration in ms (0 = no auto-dismiss)
     */
    addToast(type, title, message, duration = 3000) {
      const id = Date.now();
      const toast = {
        id,
        type,
        title,
        message,
        visible: true,
        progress: duration > 0,
      };

      this.toasts.push(toast);

      if (duration > 0) {
        setTimeout(() => {
          this.removeToast(id);
        }, duration);
      }
    },

    /**
     * Remove a toast by ID
     * @param {number} id - Toast ID to remove
     */
    removeToast(id) {
      const index = this.toasts.findIndex((t) => t.id === id);
      if (index > -1) {
        this.toasts[index].visible = false;
        setTimeout(() => {
          this.toasts.splice(index, 1);
        }, 200);
      }
    },
  };
}

/**
 * Global toast function for easy access from anywhere
 * @param {string} type - Toast type: 'success', 'error', 'warning', 'info'
 * @param {string} title - Toast title
 * @param {string} message - Toast message content
 * @param {number} duration - Auto-dismiss duration in ms
 */
function showToast(type, title, message, duration = 3000) {
  const toastContainer = document.querySelector('[x-data*="toastManager"]');
  if (
    toastContainer &&
    toastContainer._x_dataStack &&
    toastContainer._x_dataStack[0]
  ) {
    toastContainer._x_dataStack[0].addToast(type, title, message, duration);
  } else {
    // Fallback for when Alpine.js is not available
    console.warn('Toast container not found, falling back to console');
    console.log(`${type.toUpperCase()}: ${title} - ${message}`);
  }
}

// Export for use in other modules
export { toastManager, showToast };

// Make available globally for backward compatibility
if (typeof window !== 'undefined') {
  window.toastManager = toastManager;
  window.showToast = showToast;
}
