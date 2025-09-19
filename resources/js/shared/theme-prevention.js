/**
 * Theme Prevention Script
 * Prevents Flash of Unstyled Content (FOUC) by applying theme immediately
 * Part of MYDS theme system for ICTServe (iServe)
 */

/**
 * Initialize theme before DOM is fully loaded to prevent FOUC
 * This needs to run immediately, not on DOMContentLoaded
 */
(function initializeTheme() {
  const theme = localStorage.getItem('theme') || 'system';
  const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const shouldBeDark = theme === 'dark' || (theme === 'system' && systemDark);

  if (shouldBeDark) {
    document.documentElement.classList.add('dark');
    // Update theme color meta tag if it exists
    const themeColorMeta = document.getElementById('theme-color');
    if (themeColorMeta) {
      themeColorMeta.setAttribute('content', '#18181B');
    }
  }
})();
