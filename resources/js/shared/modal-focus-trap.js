/**
 * Modal Focus Trap Helper for ICTServe (iServe)
 * MYDS-compliant accessibility utilities for modal dialogs
 * Ensures keyboard navigation is trapped within modal when open
 */

/**
 * Focus trap implementation for modal dialogs
 * Conforms to WCAG 2.1 guidelines for modal accessibility
 * @param {HTMLElement} modal - Modal element to trap focus within
 */
function trapFocus(modal) {
  if (!modal) {
    console.warn('trapFocus: Modal element is required');
    return;
  }

  // Find all focusable elements within the modal
  const focusableSelector = [
    'a[href]',
    'button:not([disabled])',
    'textarea:not([disabled])',
    'input:not([disabled])',
    'select:not([disabled])',
    '[tabindex]:not([tabindex="-1"])',
    '[contenteditable="true"]'
  ].join(', ');

  const focusable = modal.querySelectorAll(focusableSelector);

  if (!focusable.length) {
    console.warn('trapFocus: No focusable elements found in modal');
    return;
  }

  const first = focusable[0];
  const last = focusable[focusable.length - 1];

  // Focus the first element initially
  first.focus();

  // Add event listener for tab key navigation
  function handleTabKey(event) {
    if (event.key !== 'Tab') return;

    if (event.shiftKey) {
      // Shift + Tab (backwards)
      if (document.activeElement === first) {
        event.preventDefault();
        last.focus();
      }
    } else {
      // Tab (forwards)
      if (document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    }
  }

  // Add event listener
  modal.addEventListener('keydown', handleTabKey);

  // Return cleanup function
  return function cleanup() {
    modal.removeEventListener('keydown', handleTabKey);
  };
}

/**
 * Enhanced focus trap with escape key support
 * @param {HTMLElement} modal - Modal element
 * @param {Function} onEscape - Callback when escape is pressed
 * @returns {Function} Cleanup function
 */
function enhancedFocusTrap(modal, onEscape = null) {
  if (!modal) {
    console.warn('enhancedFocusTrap: Modal element is required');
    return () => {};
  }

  const basicTrapCleanup = trapFocus(modal);

  // Handle escape key
  function handleEscapeKey(event) {
    if (event.key === 'Escape' && onEscape) {
      onEscape();
    }
  }

  // Add escape key listener
  document.addEventListener('keydown', handleEscapeKey);

  // Return combined cleanup function
  return function cleanup() {
    if (basicTrapCleanup) basicTrapCleanup();
    document.removeEventListener('keydown', handleEscapeKey);
  };
}

/**
 * ARIA live region announcer for screen readers
 * @param {string} message - Message to announce
 * @param {string} priority - 'polite' or 'assertive'
 */
function announceToScreenReader(message, priority = 'polite') {
  const existingRegion = document.getElementById('aria-live-region');

  let liveRegion = existingRegion;
  if (!liveRegion) {
    liveRegion = document.createElement('div');
    liveRegion.id = 'aria-live-region';
    liveRegion.setAttribute('aria-live', priority);
    liveRegion.setAttribute('aria-atomic', 'true');
    liveRegion.className = 'sr-only';
    liveRegion.style.cssText = `
      position: absolute !important;
      width: 1px !important;
      height: 1px !important;
      padding: 0 !important;
      margin: -1px !important;
      overflow: hidden !important;
      clip: rect(0,0,0,0) !important;
      white-space: nowrap !important;
      border: 0 !important;
    `;
    document.body.appendChild(liveRegion);
  }

  // Clear and set message
  liveRegion.textContent = '';
  setTimeout(() => {
    liveRegion.textContent = message;
  }, 100);
}

// Export functions
export { trapFocus, enhancedFocusTrap, announceToScreenReader };

// Make available globally for backward compatibility
if (typeof window !== 'undefined') {
  window.trapFocus = trapFocus;
  window.enhancedFocusTrap = enhancedFocusTrap;
  window.announceToScreenReader = announceToScreenReader;
}
