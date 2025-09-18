/**
 * ICT Serve (iServe) Application Entry Point
 * MYDS and MyGOVEA Compliant Implementation
 * 
 * This file serves as the central import and initialization point for all
 * application JavaScript modules following modular architecture principles.
 */

'use strict';

import './bootstrap';

// Import styles
import '../css/app.css';

// Import MYDS compliant modules
import ThemeSwitch from './theme-switch.js';
import MobileMenu from './mobile-menu.js';
import LanguageSwitcher from './language-switcher.js';
import ToastManager from './toast-manager.js';

/**
 * Application Initialization
 * All modules are auto-initialized in their respective files, but we can
 * access them here for additional configuration or event handling.
 */
document.addEventListener('DOMContentLoaded', function () {
    console.log('ICT Serve (iServe) application initialized - MYDS/MyGOVEA compliant');

    // Application is ready - all modules are initialized
    initializeAccessibilityFeatures();
    initializeErrorHandling();
    initializeAnalytics();
    
    // Emit application ready event
    const appReadyEvent = new CustomEvent('appReady', {
        detail: { 
            timestamp: Date.now(),
            modules: {
                themeSwitch: !!window.themeSwitch,
                mobileMenu: !!window.mobileMenu,
                languageSwitcher: !!window.languageSwitcher,
                toastManager: !!window.toastManager
            }
        }
    });
    document.dispatchEvent(appReadyEvent);

    console.log('All MYDS modules loaded successfully');
});

/**
 * Initialize accessibility features and compliance checks
 */
function initializeAccessibilityFeatures() {
    // Ensure focus indicators are visible
    addGlobalFocusStyles();
    
    // Setup skip links
    setupSkipLinks();
    
    // Add keyboard navigation helpers
    addKeyboardNavigationHelpers();
    
    // Check for ARIA compliance
    checkAriaCompliance();
}

/**
 * Add global focus styles for better accessibility
 */
function addGlobalFocusStyles() {
    // Add focus styles dynamically if not present
    const focusStyleId = 'myds-focus-styles';
    if (!document.getElementById(focusStyleId)) {
        const style = document.createElement('style');
        style.id = focusStyleId;
        style.textContent = `
            /* MYDS Focus Ring Styles */
            .myds-focus-visible:focus,
            *:focus-visible {
                outline: 2px solid var(--color-fr-primary-600, #2563EB) !important;
                outline-offset: 2px !important;
                border-radius: 4px;
            }
            
            /* Screen reader only class */
            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }
        `;
        document.head.appendChild(style);
    }
}

/**
 * Setup skip links for better navigation
 */
function setupSkipLinks() {
    const skipLinks = document.querySelectorAll('.skip-link, [data-skip-link]');
    skipLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
                target.focus();
                
                // Make sure target is focusable
                if (!target.hasAttribute('tabindex')) {
                    target.setAttribute('tabindex', '-1');
                }
            }
        });
    });
}

/**
 * Add keyboard navigation helpers
 */
function addKeyboardNavigationHelpers() {
    // Add Escape key handler for modals and dropdowns
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            // Close any open dropdowns
            const openDropdowns = document.querySelectorAll('[x-show="true"], .dropdown-open');
            openDropdowns.forEach(dropdown => {
                if (dropdown.hasAttribute('x-show')) {
                    // Alpine.js dropdown
                    dropdown.__x_dataStack?.[0]?.open && (dropdown.__x_dataStack[0].open = false);
                } else {
                    dropdown.classList.remove('dropdown-open');
                }
            });
        }
    });

    // Add Tab trap for modal-like elements
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            const modal = document.querySelector('[role="dialog"]:not([aria-hidden="true"])');
            if (modal) {
                trapFocus(modal, e);
            }
        }
    });
}

/**
 * Trap focus within an element
 * @param {Element} element - Element to trap focus within
 * @param {Event} e - Keyboard event
 */
function trapFocus(element, e) {
    const focusableElements = element.querySelectorAll(
        'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    if (e.shiftKey) {
        if (document.activeElement === firstElement) {
            lastElement.focus();
            e.preventDefault();
        }
    } else {
        if (document.activeElement === lastElement) {
            firstElement.focus();
            e.preventDefault();
        }
    }
}

/**
 * Check basic ARIA compliance
 */
function checkAriaCompliance() {
    // Check for form labels
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        const hasLabel = input.labels?.length > 0 || 
                        input.hasAttribute('aria-label') || 
                        input.hasAttribute('aria-labelledby');
        
        if (!hasLabel && input.type !== 'hidden') {
            console.warn('Form element missing label:', input);
        }
    });

    // Check for button labels
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        const hasLabel = button.textContent.trim() || 
                        button.hasAttribute('aria-label') ||
                        button.hasAttribute('aria-labelledby');
        
        if (!hasLabel) {
            console.warn('Button missing accessible label:', button);
        }
    });
}

/**
 * Initialize global error handling
 */
function initializeErrorHandling() {
    // Global error handler
    window.addEventListener('error', (e) => {
        console.error('Global error caught:', e.error);
        
        // Show user-friendly error message
        if (window.toastManager) {
            window.toastManager.error('System Error', 'An unexpected error occurred. Please try again.', 0);
        }
    });

    // Promise rejection handler
    window.addEventListener('unhandledrejection', (e) => {
        console.error('Unhandled promise rejection:', e.reason);
        
        if (window.toastManager) {
            window.toastManager.error('System Error', 'A system error occurred. Please try again.', 0);
        }
    });
}

/**
 * Initialize analytics (placeholder for future implementation)
 */
function initializeAnalytics() {
    // Placeholder for analytics initialization
    // This would integrate with Malaysian government-approved analytics solutions
    console.log('Analytics initialization placeholder - MYDS/MyGOVEA compliance required');
}

/**
 * Utility function for showing confirmations for destructive actions
 * @param {string} message - Confirmation message
 * @param {string} title - Confirmation title
 * @returns {Promise<boolean>} User confirmation result
 */
window.confirmDestructiveAction = async function(message = 'Are you sure?', title = 'Confirm Action') {
    return new Promise((resolve) => {
        // Create custom confirmation dialog
        const dialog = document.createElement('div');
        dialog.setAttribute('role', 'dialog');
        dialog.setAttribute('aria-modal', 'true');
        dialog.setAttribute('aria-labelledby', 'confirm-title');
        dialog.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50';
        
        dialog.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md mx-4 shadow-xl">
                <h3 id="confirm-title" class="text-lg font-semibold mb-4">${title}</h3>
                <p class="text-gray-700 mb-6">${message}</p>
                <div class="flex space-x-3 justify-end">
                    <button type="button" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500" data-action="cancel">
                        Cancel
                    </button>
                    <button type="button" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500" data-action="confirm">
                        Confirm
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(dialog);
        
        // Focus first button
        const firstButton = dialog.querySelector('button');
        firstButton?.focus();

        // Handle clicks
        dialog.addEventListener('click', (e) => {
            const action = e.target.dataset.action;
            if (action === 'confirm') {
                resolve(true);
            } else if (action === 'cancel' || e.target === dialog) {
                resolve(false);
            }
            document.body.removeChild(dialog);
        });

        // Handle escape key
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                resolve(false);
                document.body.removeChild(dialog);
                document.removeEventListener('keydown', handleEscape);
            }
        };
        document.addEventListener('keydown', handleEscape);
    });
};

/**
 * Legacy compatibility function for notifications
 * @deprecated Use window.toastManager methods instead
 */
window.showNotification = function(message, type = 'info') {
    console.warn('showNotification is deprecated. Use toastManager methods instead.');
    
    if (window.toastManager) {
        window.toastManager.show(type, type.charAt(0).toUpperCase() + type.slice(1), message);
    } else {
        // Fallback for cases where toast manager isn't loaded yet
        setTimeout(() => {
            if (window.toastManager) {
                window.toastManager.show(type, type.charAt(0).toUpperCase() + type.slice(1), message);
            }
        }, 100);
    }
};
