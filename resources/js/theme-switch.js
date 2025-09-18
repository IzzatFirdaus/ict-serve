/**
 * MYDS Theme Switch Module
 * Handles dark/light mode toggling, system theme detection, and accessibility.
 * Compliant with MYDS and MyGOVEA standards.
 */

'use strict';

class ThemeSwitch {
  constructor() {
    this.key = 'darkMode';
    this.darkModeClass = 'dark';
    this.init();
  }

  /**
   * Initialize the theme switch functionality
   */
  init() {
    // Prevent FOUC by applying theme immediately
    this.applyThemeImmediate();

    // Setup theme listeners after DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
      this.setupEventListeners();
      this.updateMetaThemeColor();
    });
  }

  /**
   * Apply theme immediately to prevent Flash of Unstyled Content (FOUC)
   * This runs before DOM is ready
   */
  applyThemeImmediate() {
    const isDark =
      this.getStoredTheme() === 'dark' ||
      (!this.hasStoredTheme() && this.prefersDarkScheme());

    if (isDark) {
      document.documentElement.classList.add(this.darkModeClass);
    }
  }

  /**
   * Setup event listeners for theme switching
   */
  setupEventListeners() {
    // Find all theme toggle buttons
    const toggleButtons = document.querySelectorAll('[data-theme-toggle]');

    toggleButtons.forEach((button) => {
      // Add ARIA attributes for accessibility
      button.setAttribute('aria-label', this.getAriaLabel());
      button.setAttribute('aria-pressed', this.isDarkMode().toString());

      // Add click handler
      button.addEventListener('click', (e) => {
        e.preventDefault();
        this.toggleTheme();
      });

      // Add keyboard support (Enter and Space)
      button.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          this.toggleTheme();
        }
      });
    });

    // Listen for system theme changes
    if (window.matchMedia) {
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      mediaQuery.addEventListener('change', () => {
        if (!this.hasStoredTheme()) {
          this.applySystemTheme();
        }
      });
    }
  }

  /**
   * Toggle between dark and light themes
   */
  toggleTheme() {
    const newTheme = this.isDarkMode() ? 'light' : 'dark';
    this.setTheme(newTheme);

    // Announce theme change for screen readers
    this.announceThemeChange(newTheme);

    // Update button states
    this.updateToggleButtons();

    // Update meta theme color
    this.updateMetaThemeColor();

    // Emit custom event for other components
    this.dispatchThemeChangeEvent(newTheme);
  }

  /**
   * Set theme and persist to localStorage
   * @param {string} theme - 'dark' or 'light'
   */
  setTheme(theme) {
    localStorage.setItem(this.key, theme === 'dark' ? 'true' : 'false');

    if (theme === 'dark') {
      document.documentElement.classList.add(this.darkModeClass);
    } else {
      document.documentElement.classList.remove(this.darkModeClass);
    }
  }

  /**
   * Apply system theme preference
   */
  applySystemTheme() {
    const theme = this.prefersDarkScheme() ? 'dark' : 'light';
    this.setTheme(theme);
    this.updateToggleButtons();
    this.updateMetaThemeColor();
  }

  /**
   * Check if dark mode is currently active
   * @returns {boolean}
   */
  isDarkMode() {
    return document.documentElement.classList.contains(this.darkModeClass);
  }

  /**
   * Check if user prefers dark color scheme
   * @returns {boolean}
   */
  prefersDarkScheme() {
    return (
      window.matchMedia &&
      window.matchMedia('(prefers-color-scheme: dark)').matches
    );
  }

  /**
   * Check if theme is stored in localStorage
   * @returns {boolean}
   */
  hasStoredTheme() {
    return localStorage.getItem(this.key) !== null;
  }

  /**
   * Get stored theme from localStorage
   * @returns {string|null}
   */
  getStoredTheme() {
    const stored = localStorage.getItem(this.key);
    return stored === 'true' ? 'dark' : stored === 'false' ? 'light' : null;
  }

  /**
   * Update meta theme-color for mobile browsers
   * Following MYDS color tokens
   */
  updateMetaThemeColor() {
    let themeColorMeta = document.querySelector('meta[name="theme-color"]');

    if (!themeColorMeta) {
      themeColorMeta = document.createElement('meta');
      themeColorMeta.name = 'theme-color';
      document.head.appendChild(themeColorMeta);
    }

    // MYDS compliant theme colors
    const themeColor = this.isDarkMode() ? '#18181B' : '#FFFFFF'; // txt-black-900 : bg-white-0
    themeColorMeta.content = themeColor;
  }

  /**
   * Update all toggle button states and ARIA attributes
   */
  updateToggleButtons() {
    const toggleButtons = document.querySelectorAll('[data-theme-toggle]');
    const isDark = this.isDarkMode();

    toggleButtons.forEach((button) => {
      button.setAttribute('aria-pressed', isDark.toString());
      button.setAttribute('aria-label', this.getAriaLabel());

      // Update button text if it has a text indicator
      const textElement = button.querySelector('[data-theme-text]');
      if (textElement) {
        textElement.textContent = isDark ? 'Light Mode' : 'Dark Mode';
      }
    });
  }

  /**
   * Get appropriate ARIA label for theme toggle button
   * @returns {string}
   */
  getAriaLabel() {
    return this.isDarkMode() ? 'Switch to light mode' : 'Switch to dark mode';
  }

  /**
   * Announce theme change to screen readers
   * @param {string} theme - The new theme
   */
  announceThemeChange(theme) {
    const announcement = `Switched to ${theme} mode`;

    // Create a temporary element for screen reader announcement
    const announcer = document.createElement('div');
    announcer.setAttribute('aria-live', 'polite');
    announcer.setAttribute('aria-atomic', 'true');
    announcer.className = 'sr-only';
    announcer.textContent = announcement;

    document.body.appendChild(announcer);

    // Remove the announcer after announcement
    setTimeout(() => {
      document.body.removeChild(announcer);
    }, 1000);
  }

  /**
   * Dispatch custom event for theme changes
   * @param {string} theme - The new theme
   */
  dispatchThemeChangeEvent(theme) {
    const event = new CustomEvent('themeChange', {
      detail: { theme, isDark: theme === 'dark' },
    });
    document.dispatchEvent(event);
  }

  /**
   * Get current theme
   * @returns {string} 'dark' or 'light'
   */
  getCurrentTheme() {
    return this.isDarkMode() ? 'dark' : 'light';
  }
}

// Export for module usage
export default ThemeSwitch;

// Auto-initialize for immediate usage
const themeSwitch = new ThemeSwitch();

// Make available globally for compatibility
window.themeSwitch = themeSwitch;
