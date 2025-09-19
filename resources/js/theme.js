/**
 * MYDS Theme Management System
 * Provides light/dark mode switching with system preference detection
 * and localStorage persistence following MYDS guidelines
 */

document.addEventListener('alpine:init', () => {
  // Theme Manager Alpine.js Component
  Alpine.data('themeManager', () => ({
    theme: 'system', // 'light', 'dark', 'system'
    isDark: false,
    isSystemDark: false,

    init() {
      // Initialize theme from localStorage or default to system
      this.theme = localStorage.getItem('theme') || 'system';
      this.isSystemDark = window.matchMedia(
        '(prefers-color-scheme: dark)'
      ).matches;

      // Apply initial theme
      this.updateTheme();

      // Listen for system preference changes
      window
        .matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', (e) => {
          this.isSystemDark = e.matches;
          if (this.theme === 'system') {
            this.updateTheme();
          }
        });
    },

    setTheme(newTheme) {
      this.theme = newTheme;
      localStorage.setItem('theme', newTheme);
      this.updateTheme();

      // Dispatch custom event for other components
      window.dispatchEvent(
        new CustomEvent('theme-changed', {
          detail: { theme: newTheme, isDark: this.isDark },
        })
      );
    },

    updateTheme() {
      const shouldBeDark =
        this.theme === 'dark' || (this.theme === 'system' && this.isSystemDark);

      this.isDark = shouldBeDark;

      // Update document class
      if (shouldBeDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }

      // Update meta theme-color for mobile browsers
      const themeColorMeta = document.querySelector('meta[name="theme-color"]');
      if (themeColorMeta) {
        themeColorMeta.setAttribute(
          'content',
          shouldBeDark ? '#18181B' : '#FFFFFF'
        );
      }
    },

    toggleTheme() {
      if (this.theme === 'light') {
        this.setTheme('dark');
      } else if (this.theme === 'dark') {
        this.setTheme('system');
      } else {
        this.setTheme('light');
      }
    },

    getThemeIcon() {
      switch (this.theme) {
        case 'light':
          return 'sun';
        case 'dark':
          return 'moon';
        default:
          return 'computer';
      }
    },

    getThemeLabel() {
      switch (this.theme) {
        case 'light':
          return 'Light Mode';
        case 'dark':
          return 'Dark Mode';
        default:
          return 'System Mode';
      }
    },
  }));

  // Accessible dropdown component for theme selector
  Alpine.data('themeDropdown', () => ({
    open: false,

    toggle() {
      this.open = !this.open;
    },

    close() {
      this.open = false;
    },

    handleKeydown(event) {
      if (event.key === 'Escape') {
        this.close();
      }
    },
  }));
});

/**
 * Utility function to prevent FOUC (Flash of Unstyled Content)
 * This should be inlined in the HTML head
 */
function preventFOUC() {
  const theme = localStorage.getItem('theme');
  const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const shouldBeDark =
    theme === 'dark' || ((!theme || theme === 'system') && systemDark);

  if (shouldBeDark) {
    document.documentElement.classList.add('dark');
  }
}

/**
 * Initialize theme before DOM is fully loaded
 * This prevents theme flickering
 */
if (document.readyState === 'loading') {
  preventFOUC();
} else {
  // DOM already loaded
  const theme = localStorage.getItem('theme');
  const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const shouldBeDark =
    theme === 'dark' || ((!theme || theme === 'system') && systemDark);

  if (shouldBeDark) {
    document.documentElement.classList.add('dark');
  }
}

/**
 * Theme change event handler for third-party integrations
 */
window.addEventListener('theme-changed', (event) => {
  // Custom logic for theme changes
  console.log('Theme changed:', event.detail);
});

/**
 * Accessibility improvements for theme switching
 */
document.addEventListener('DOMContentLoaded', () => {
  // Announce theme changes to screen readers
  const announcer = document.createElement('div');
  announcer.setAttribute('aria-live', 'polite');
  announcer.setAttribute('aria-atomic', 'true');
  announcer.setAttribute('class', 'sr-only');
  announcer.id = 'theme-announcer';
  document.body.appendChild(announcer);

  window.addEventListener('theme-changed', (event) => {
    const { theme, isDark } = event.detail;
    const message = `Theme changed to ${theme} mode. Currently using ${isDark ? 'dark' : 'light'} appearance.`;

    announcer.textContent = '';
    setTimeout(() => {
      announcer.textContent = message;
    }, 100);
  });
});
