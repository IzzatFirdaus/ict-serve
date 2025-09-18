/**
 * MYDS Mobile Menu Module
 * Handles mobile navigation menu toggle with full accessibility support.
 * Compliant with MYDS and MyGOVEA standards.
 */

'use strict';

class MobileMenu {
  constructor() {
    this.toggleSelector = '[data-mobile-menu-toggle]';
    this.menuSelector = '[data-mobile-menu]';
    this.isOpen = false;
    this.init();
  }

  /**
   * Initialize mobile menu functionality
   */
  init() {
    document.addEventListener('DOMContentLoaded', () => {
      this.setupEventListeners();
      this.setupKeyboardNavigation();
      this.setupClickOutside();
    });
  }

  /**
   * Setup event listeners for menu toggle
   */
  setupEventListeners() {
    const toggleButtons = document.querySelectorAll(this.toggleSelector);

    toggleButtons.forEach((button) => {
      // Add ARIA attributes
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('aria-haspopup', 'true');
      button.setAttribute('aria-label', 'Open main menu');

      // Add click handler
      button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.toggleMenu();
      });

      // Add keyboard support
      button.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.toggleMenu();
        }
      });
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      this.handleResize();
    });
  }

  /**
   * Setup keyboard navigation for menu items
   */
  setupKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
      if (!this.isOpen) return;

      switch (e.key) {
        case 'Escape':
          e.preventDefault();
          this.closeMenu();
          this.focusToggleButton();
          break;

        case 'Tab':
          this.handleTabNavigation(e);
          break;

        case 'ArrowDown':
          e.preventDefault();
          this.focusNextItem();
          break;

        case 'ArrowUp':
          e.preventDefault();
          this.focusPreviousItem();
          break;

        case 'Home':
          e.preventDefault();
          this.focusFirstItem();
          break;

        case 'End':
          e.preventDefault();
          this.focusLastItem();
          break;
      }
    });
  }

  /**
   * Setup click outside to close menu
   */
  setupClickOutside() {
    document.addEventListener('click', (e) => {
      if (!this.isOpen) return;

      const menu = document.querySelector(this.menuSelector);
      const toggleButton = document.querySelector(this.toggleSelector);

      if (!menu || !toggleButton) return;

      // Close if clicking outside menu and toggle button
      if (!menu.contains(e.target) && !toggleButton.contains(e.target)) {
        this.closeMenu();
      }
    });
  }

  /**
   * Toggle menu open/close
   */
  toggleMenu() {
    if (this.isOpen) {
      this.closeMenu();
    } else {
      this.openMenu();
    }
  }

  /**
   * Open mobile menu
   */
  openMenu() {
    const menu = document.querySelector(this.menuSelector);
    const toggleButtons = document.querySelectorAll(this.toggleSelector);

    if (!menu) return;

    // Show menu
    menu.classList.remove('hidden');
    menu.classList.add('block');

    // Update state
    this.isOpen = true;

    // Update toggle buttons
    toggleButtons.forEach((button) => {
      button.setAttribute('aria-expanded', 'true');
      button.setAttribute('aria-label', 'Close main menu');

      // Update icon if present
      this.updateToggleIcon(button, true);
    });

    // Add body lock to prevent scrolling
    document.body.style.overflow = 'hidden';

    // Focus first menu item for accessibility
    this.focusFirstItem();

    // Announce to screen readers
    this.announceMenuState('Menu opened');

    // Emit custom event
    this.dispatchMenuEvent('open');

    // Add animation class if present
    requestAnimationFrame(() => {
      menu.classList.add('menu-open');
    });
  }

  /**
   * Close mobile menu
   */
  closeMenu() {
    const menu = document.querySelector(this.menuSelector);
    const toggleButtons = document.querySelectorAll(this.toggleSelector);

    if (!menu) return;

    // Hide menu
    menu.classList.add('hidden');
    menu.classList.remove('block', 'menu-open');

    // Update state
    this.isOpen = false;

    // Update toggle buttons
    toggleButtons.forEach((button) => {
      button.setAttribute('aria-expanded', 'false');
      button.setAttribute('aria-label', 'Open main menu');

      // Update icon if present
      this.updateToggleIcon(button, false);
    });

    // Remove body lock
    document.body.style.overflow = '';

    // Announce to screen readers
    this.announceMenuState('Menu closed');

    // Emit custom event
    this.dispatchMenuEvent('close');
  }

  /**
   * Handle tab navigation within menu
   * @param {KeyboardEvent} e - The keyboard event
   */
  handleTabNavigation(e) {
    const menu = document.querySelector(this.menuSelector);
    if (!menu) return;

    const focusableElements = this.getFocusableElements(menu);
    if (focusableElements.length === 0) return;

    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    if (e.shiftKey) {
      // Shift + Tab: moving backwards
      if (document.activeElement === firstElement) {
        e.preventDefault();
        lastElement.focus();
      }
    } else {
      // Tab: moving forwards
      if (document.activeElement === lastElement) {
        e.preventDefault();
        firstElement.focus();
      }
    }
  }

  /**
   * Focus next menu item
   */
  focusNextItem() {
    const menu = document.querySelector(this.menuSelector);
    if (!menu) return;

    const focusableElements = this.getFocusableElements(menu);
    const currentIndex = focusableElements.indexOf(document.activeElement);

    if (currentIndex < focusableElements.length - 1) {
      focusableElements[currentIndex + 1].focus();
    } else {
      focusableElements[0].focus();
    }
  }

  /**
   * Focus previous menu item
   */
  focusPreviousItem() {
    const menu = document.querySelector(this.menuSelector);
    if (!menu) return;

    const focusableElements = this.getFocusableElements(menu);
    const currentIndex = focusableElements.indexOf(document.activeElement);

    if (currentIndex > 0) {
      focusableElements[currentIndex - 1].focus();
    } else {
      focusableElements[focusableElements.length - 1].focus();
    }
  }

  /**
   * Focus first menu item
   */
  focusFirstItem() {
    const menu = document.querySelector(this.menuSelector);
    if (!menu) return;

    const focusableElements = this.getFocusableElements(menu);
    if (focusableElements.length > 0) {
      focusableElements[0].focus();
    }
  }

  /**
   * Focus last menu item
   */
  focusLastItem() {
    const menu = document.querySelector(this.menuSelector);
    if (!menu) return;

    const focusableElements = this.getFocusableElements(menu);
    if (focusableElements.length > 0) {
      focusableElements[focusableElements.length - 1].focus();
    }
  }

  /**
   * Focus toggle button
   */
  focusToggleButton() {
    const toggleButton = document.querySelector(this.toggleSelector);
    if (toggleButton) {
      toggleButton.focus();
    }
  }

  /**
   * Get all focusable elements within container
   * @param {Element} container - Container element
   * @returns {Array} Array of focusable elements
   */
  getFocusableElements(container) {
    const focusableSelectors = [
      'a[href]',
      'button:not([disabled])',
      'input:not([disabled])',
      'select:not([disabled])',
      'textarea:not([disabled])',
      '[tabindex]:not([tabindex="-1"])',
    ].join(',');

    return Array.from(container.querySelectorAll(focusableSelectors)).filter(
      (element) => {
        return (
          element.offsetParent !== null && // visible
          !element.disabled &&
          element.tabIndex !== -1
        );
      }
    );
  }

  /**
   * Update toggle button icon
   * @param {Element} button - Toggle button element
   * @param {boolean} isOpen - Whether menu is open
   */
  updateToggleIcon(button, isOpen) {
    const hamburgerIcon = button.querySelector('[data-icon="hamburger"]');
    const closeIcon = button.querySelector('[data-icon="close"]');

    if (hamburgerIcon && closeIcon) {
      if (isOpen) {
        hamburgerIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
      } else {
        hamburgerIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      }
    }
  }

  /**
   * Handle window resize
   */
  handleResize() {
    // Close menu if window becomes large enough (desktop breakpoint)
    if (window.innerWidth >= 768 && this.isOpen) {
      // md breakpoint
      this.closeMenu();
    }
  }

  /**
   * Announce menu state to screen readers
   * @param {string} message - Message to announce
   */
  announceMenuState(message) {
    const announcer = document.createElement('div');
    announcer.setAttribute('aria-live', 'polite');
    announcer.setAttribute('aria-atomic', 'true');
    announcer.className = 'sr-only';
    announcer.textContent = message;

    document.body.appendChild(announcer);

    setTimeout(() => {
      document.body.removeChild(announcer);
    }, 1000);
  }

  /**
   * Dispatch custom menu events
   * @param {string} action - 'open' or 'close'
   */
  dispatchMenuEvent(action) {
    const event = new CustomEvent('mobileMenu', {
      detail: { action, isOpen: this.isOpen },
    });
    document.dispatchEvent(event);
  }

  /**
   * Get current menu state
   * @returns {boolean}
   */
  isMenuOpen() {
    return this.isOpen;
  }

  /**
   * Programmatically open menu
   */
  open() {
    if (!this.isOpen) {
      this.openMenu();
    }
  }

  /**
   * Programmatically close menu
   */
  close() {
    if (this.isOpen) {
      this.closeMenu();
    }
  }
}

// Export for module usage
export default MobileMenu;

// Auto-initialize
const mobileMenu = new MobileMenu();

// Make available globally for compatibility
window.mobileMenu = mobileMenu;
