/**
 * MYDS Language Switcher Module
 * Handles language selection and locale switching with accessibility support.
 * Compliant with MYDS and MyGOVEA bilingual requirements (Bahasa Malaysia & English).
 */

'use strict';

class LanguageSwitcher {
  constructor() {
    this.currentLocale = document.documentElement.lang || 'ms';
    this.supportedLocales = ['ms', 'en'];
    this.localeLabels = {
      ms: 'Bahasa Malaysia',
      en: 'English',
    };
    this.init();
  }

  /**
   * Initialize language switcher functionality
   */
  init() {
    document.addEventListener('DOMContentLoaded', () => {
      this.setupEventListeners();
      this.updateLanguageIndicators();
    });
  }

  /**
   * Setup event listeners for language switching
   */
  setupEventListeners() {
    // Handle dropdown/select language switchers
    const selectElements = document.querySelectorAll('[data-language-select]');
    selectElements.forEach((select) => {
      this.setupSelectLanguageSwitcher(select);
    });

    // Handle link-based language switchers
    const linkElements = document.querySelectorAll('[data-language-link]');
    linkElements.forEach((link) => {
      this.setupLinkLanguageSwitcher(link);
    });

    // Handle button-based language switchers
    const buttonElements = document.querySelectorAll('[data-language-button]');
    buttonElements.forEach((button) => {
      this.setupButtonLanguageSwitcher(button);
    });
  }

  /**
   * Setup select/dropdown language switcher
   * @param {Element} select - Select element
   */
  setupSelectLanguageSwitcher(select) {
    // Add ARIA attributes
    select.setAttribute('aria-label', 'Pilih Bahasa / Select Language');

    // Set current value
    select.value = this.currentLocale;

    // Add change event listener
    select.addEventListener('change', (e) => {
      const newLocale = e.target.value;
      this.switchLanguage(newLocale);
    });

    // Add keyboard support for better UX
    select.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const newLocale = e.target.value;
        if (newLocale !== this.currentLocale) {
          this.switchLanguage(newLocale);
        }
      }
    });
  }

  /**
   * Setup link-based language switcher
   * @param {Element} link - Link element
   */
  setupLinkLanguageSwitcher(link) {
    const locale = link.dataset.languageLink;

    if (!this.supportedLocales.includes(locale)) {
      console.warn(`Unsupported locale: ${locale}`);
      return;
    }

    // Add ARIA attributes
    link.setAttribute(
      'aria-label',
      `Switch to ${this.localeLabels[locale]} / Tukar kepada ${this.localeLabels[locale]}`
    );

    // Add role if not already a proper link
    if (!link.href) {
      link.setAttribute('role', 'button');
      link.setAttribute('tabindex', '0');
    }

    // Add click handler
    link.addEventListener('click', (e) => {
      e.preventDefault();
      if (locale !== this.currentLocale) {
        this.switchLanguage(locale);
      }
    });

    // Add keyboard support for button-role links
    if (link.getAttribute('role') === 'button') {
      link.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          if (locale !== this.currentLocale) {
            this.switchLanguage(locale);
          }
        }
      });
    }
  }

  /**
   * Setup button-based language switcher
   * @param {Element} button - Button element
   */
  setupButtonLanguageSwitcher(button) {
    const locale = button.dataset.languageButton;

    if (!this.supportedLocales.includes(locale)) {
      console.warn(`Unsupported locale: ${locale}`);
      return;
    }

    // Add ARIA attributes
    button.setAttribute(
      'aria-label',
      `Switch to ${this.localeLabels[locale]} / Tukar kepada ${this.localeLabels[locale]}`
    );
    button.setAttribute(
      'aria-pressed',
      (locale === this.currentLocale).toString()
    );

    // Add click handler
    button.addEventListener('click', (e) => {
      e.preventDefault();
      if (locale !== this.currentLocale) {
        this.switchLanguage(locale);
      }
    });

    // Keyboard support is built-in for buttons
  }

  /**
   * Switch to specified language with confirmation for better UX
   * @param {string} locale - Target locale (e.g., 'ms', 'en')
   */
  switchLanguage(locale) {
    if (!this.supportedLocales.includes(locale)) {
      console.error(`Unsupported locale: ${locale}`);
      return;
    }

    if (locale === this.currentLocale) {
      return; // Already in target language
    }

    // Show loading state
    this.showLoadingState();

    // Announce language change to screen readers
    this.announceLanguageChange(locale);

    // Emit event before switching
    this.dispatchLanguageEvent('beforeSwitch', {
      from: this.currentLocale,
      to: locale,
    });

    // Perform the switch with a slight delay for better UX
    setTimeout(() => {
      this.performLanguageSwitch(locale);
    }, 100);
  }

  /**
   * Perform the actual language switch
   * @param {string} locale - Target locale
   */
  performLanguageSwitch(locale) {
    // Method 1: Use route-based switching if available
    const routeUrl = this.buildLanguageRoute(locale);
    if (routeUrl) {
      window.location.href = routeUrl;
      return;
    }

    // Method 2: Form submission for Laravel route model
    this.submitLanguageForm(locale);
  }

  /**
   * Build language route URL
   * @param {string} locale - Target locale
   * @returns {string|null} Route URL or null if not available
   */
  buildLanguageRoute(locale) {
    // Check if Laravel route helper is available
    if (typeof route !== 'undefined') {
      try {
        return route('language.switch', locale);
      } catch (e) {
        console.warn(
          'Laravel route helper not available for language switching'
        );
      }
    }

    // Fallback to URL construction
    const baseUrl = window.location.origin;
    const path = window.location.pathname;

    // Simple URL-based switching
    return `${baseUrl}/language/${locale}?redirect=${encodeURIComponent(path)}`;
  }

  /**
   * Submit language form (fallback method)
   * @param {string} locale - Target locale
   */
  submitLanguageForm(locale) {
    // Create a form to submit the language change
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/language';
    form.style.display = 'none';

    // Add CSRF token if available
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = csrfToken.content;
      form.appendChild(csrfInput);
    }

    // Add locale input
    const localeInput = document.createElement('input');
    localeInput.type = 'hidden';
    localeInput.name = 'locale';
    localeInput.value = locale;
    form.appendChild(localeInput);

    // Add redirect URL
    const redirectInput = document.createElement('input');
    redirectInput.type = 'hidden';
    redirectInput.name = 'redirect';
    redirectInput.value = window.location.pathname + window.location.search;
    form.appendChild(redirectInput);

    // Submit form
    document.body.appendChild(form);
    form.submit();
  }

  /**
   * Show loading state during language switch
   */
  showLoadingState() {
    const switchers = document.querySelectorAll(
      '[data-language-select], [data-language-link], [data-language-button]'
    );

    switchers.forEach((element) => {
      element.style.opacity = '0.7';
      element.style.pointerEvents = 'none';

      // Add loading indicator if it doesn't exist
      if (!element.querySelector('[data-loading]')) {
        const loader = document.createElement('span');
        loader.setAttribute('data-loading', '');
        loader.setAttribute('aria-hidden', 'true');
        loader.innerHTML = '⏳'; // Simple loading indicator
        loader.style.marginLeft = '4px';
        element.appendChild(loader);
      }
    });
  }

  /**
   * Update language indicators to show current locale
   */
  updateLanguageIndicators() {
    // Update select elements
    const selectElements = document.querySelectorAll('[data-language-select]');
    selectElements.forEach((select) => {
      select.value = this.currentLocale;
    });

    // Update link/button active states
    const linkElements = document.querySelectorAll(
      '[data-language-link], [data-language-button]'
    );
    linkElements.forEach((element) => {
      const locale =
        element.dataset.languageLink || element.dataset.languageButton;
      const isActive = locale === this.currentLocale;

      // Update aria-pressed for buttons
      if (element.hasAttribute('aria-pressed')) {
        element.setAttribute('aria-pressed', isActive.toString());
      }

      // Update visual active state
      if (isActive) {
        element.classList.add('active', 'text-primary-600', 'font-medium');
        element.classList.remove('text-gray-500');
      } else {
        element.classList.remove('active', 'text-primary-600', 'font-medium');
        element.classList.add('text-gray-500');
      }
    });
  }

  /**
   * Announce language change to screen readers
   * @param {string} locale - Target locale
   */
  announceLanguageChange(locale) {
    const messages = {
      ms: `Menukar kepada ${this.localeLabels[locale]}`,
      en: `Switching to ${this.localeLabels[locale]}`,
    };

    const message = messages[this.currentLocale] || messages['en'];

    const announcer = document.createElement('div');
    announcer.setAttribute('aria-live', 'polite');
    announcer.setAttribute('aria-atomic', 'true');
    announcer.className = 'sr-only';
    announcer.textContent = message;

    document.body.appendChild(announcer);

    setTimeout(() => {
      if (document.body.contains(announcer)) {
        document.body.removeChild(announcer);
      }
    }, 1000);
  }

  /**
   * Dispatch custom language events
   * @param {string} eventType - Event type (e.g., 'beforeSwitch', 'afterSwitch')
   * @param {Object} detail - Event details
   */
  dispatchLanguageEvent(eventType, detail) {
    const event = new CustomEvent(
      `language${eventType.charAt(0).toUpperCase() + eventType.slice(1)}`,
      {
        detail: { ...detail, currentLocale: this.currentLocale },
      }
    );
    document.dispatchEvent(event);
  }

  /**
   * Get current locale
   * @returns {string}
   */
  getCurrentLocale() {
    return this.currentLocale;
  }

  /**
   * Get supported locales
   * @returns {Array}
   */
  getSupportedLocales() {
    return [...this.supportedLocales];
  }

  /**
   * Check if locale is supported
   * @param {string} locale - Locale to check
   * @returns {boolean}
   */
  isLocaleSupported(locale) {
    return this.supportedLocales.includes(locale);
  }
}

// Export for module usage
export default LanguageSwitcher;

// Auto-initialize
const languageSwitcher = new LanguageSwitcher();

// Make available globally for compatibility
window.languageSwitcher = languageSwitcher;

// Global function for backward compatibility
window.changeLanguage = function (locale) {
  languageSwitcher.switchLanguage(locale);
};
