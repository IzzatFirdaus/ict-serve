/**
 * Demo Dashboard Scripts for ICTServe (iServe)
 * Simple toast functionality for demo pages
 * MYDS-compliant styling and accessibility features
 */

/**
 * Simple toast notification function for demo pages
 * @param {string} message - Toast message
 * @param {string} type - Toast type: 'info', 'success', 'warning', 'error'
 * @param {number} duration - Auto-dismiss duration in ms (0 = no auto-dismiss)
 */
function showToast(message, type = 'info', duration = 5000) {
  // Create toast element
  const toast = document.createElement('div');
  toast.className = `toast toast-${type} fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50`;

  // Set MYDS-compliant styling based on type
  const typeStyles = {
    success: 'bg-success-600 text-white border-success-600',
    error: 'bg-danger-600 text-white border-danger-600',
    warning: 'bg-warning-600 text-white border-warning-600',
    info: 'bg-primary-600 text-white border-primary-600'
  };

  toast.className += ` ${typeStyles[type] || typeStyles.info}`;

  // Create toast content with accessibility support
  toast.innerHTML = `
    <div class="flex items-center" role="alert" aria-live="polite">
      <span class="mr-2">${message}</span>
      <button
        class="close-button ml-2 text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 rounded"
        aria-label="Tutup notifikasi"
        type="button"
      >×</button>
    </div>
  `;

  // Add to page
  document.body.appendChild(toast);

  // Auto dismiss with fade out
  if (duration > 0) {
    setTimeout(() => {
      fadeOutAndRemove(toast);
    }, duration);
  }

  // Manual dismiss
  const closeButton = toast.querySelector('.close-button');
  if (closeButton) {
    closeButton.onclick = function (event) {
      event.stopPropagation();
      fadeOutAndRemove(toast);
    };
  }

  // Return toast element for further manipulation if needed
  return toast;
}

/**
 * Fade out toast and remove from DOM
 * @param {HTMLElement} toast - Toast element to remove
 */
function fadeOutAndRemove(toast) {
  if (!toast || !toast.parentNode) return;

  // Add fade out animation
  toast.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
  toast.style.opacity = '0';
  toast.style.transform = 'translateX(100%)';

  // Remove after animation
  setTimeout(() => {
    if (toast.parentNode) {
      toast.parentNode.removeChild(toast);
    }
  }, 300);
}

/**
 * Initialize demo dashboard functionality
 * Called when the page loads
 */
function initializeDemoDashboard() {
  // Add keyboard support for demo actions
  document.addEventListener('keydown', function(event) {
    // Demo: Press 'T' to show test toast
    if (event.key === 't' || event.key === 'T') {
      if (event.ctrlKey || event.metaKey) {
        event.preventDefault();
        showToast('Demo toast notification', 'info', 3000);
      }
    }
  });

  // Log initialization
  console.log('Demo dashboard initialized');
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeDemoDashboard);

// Export functions
export { showToast, fadeOutAndRemove, initializeDemoDashboard };

// Make available globally for backward compatibility
if (typeof window !== 'undefined') {
  window.showToast = showToast;
  window.initializeDemoDashboard = initializeDemoDashboard;
}
