/**
 * MYDS Toast Manager Module
 * Handles toast notifications with full accessibility support and ARIA compliance.
 * Supports multiple notification types following MYDS design tokens.
 * Compliant with MYDS and MyGOVEA standards.
 */

'use strict';

class ToastManager {
    constructor() {
        this.toasts = [];
        this.nextId = 1;
        this.containerId = 'toast-container';
        this.defaultDuration = 5000;
        this.maxToasts = 5;
        this.positions = {
            'top-right': 'fixed top-4 right-4',
            'top-left': 'fixed top-4 left-4', 
            'bottom-right': 'fixed bottom-4 right-4',
            'bottom-left': 'fixed bottom-4 left-4',
            'top-center': 'fixed top-4 left-1/2 transform -translate-x-1/2',
            'bottom-center': 'fixed bottom-4 left-1/2 transform -translate-x-1/2'
        };
        this.currentPosition = 'bottom-right';
        this.init();
    }

    /**
     * Initialize toast manager
     */
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.createContainer();
            this.setupGlobalFunction();
            this.setupKeyboardHandlers();
        });
    }

    /**
     * Create toast container if it doesn't exist
     */
    createContainer() {
        let container = document.getElementById(this.containerId);
        
        if (!container) {
            container = document.createElement('div');
            container.id = this.containerId;
            container.setAttribute('role', 'region');
            container.setAttribute('aria-label', 'Notifications');
            container.setAttribute('aria-live', 'polite');
            container.setAttribute('aria-atomic', 'false');
            container.className = `${this.positions[this.currentPosition]} z-50 space-y-3 pointer-events-none max-w-sm`;
            document.body.appendChild(container);
        }
    }

    /**
     * Setup global function for backward compatibility
     */
    setupGlobalFunction() {
        window.showToast = (type, title, message, duration) => {
            this.show(type, title, message, duration);
        };

        // Alternative function names for flexibility
        window.toast = {
            success: (title, message, duration) => this.success(title, message, duration),
            error: (title, message, duration) => this.error(title, message, duration),
            warning: (title, message, duration) => this.warning(title, message, duration),
            info: (title, message, duration) => this.info(title, message, duration),
            show: (type, title, message, duration) => this.show(type, title, message, duration),
            clear: () => this.clearAll()
        };
    }

    /**
     * Setup keyboard handlers for toast management
     */
    setupKeyboardHandlers() {
        document.addEventListener('keydown', (e) => {
            // Dismiss all toasts with Escape key
            if (e.key === 'Escape' && this.toasts.length > 0) {
                e.preventDefault();
                this.clearAll();
                this.announceToScreenReader('All notifications dismissed');
            }
        });
    }

    /**
     * Show a toast notification
     * @param {string} type - Type of toast (success, error, warning, info)
     * @param {string} title - Toast title
     * @param {string} message - Toast message
     * @param {number} duration - Duration in milliseconds (0 for persistent)
     * @returns {number} Toast ID
     */
    show(type = 'info', title = '', message = '', duration = this.defaultDuration) {
        const toast = this.createToast(type, title, message, duration);
        this.addToast(toast);
        return toast.id;
    }

    /**
     * Show success toast
     * @param {string} title - Toast title
     * @param {string} message - Toast message  
     * @param {number} duration - Duration in milliseconds
     * @returns {number} Toast ID
     */
    success(title, message, duration = this.defaultDuration) {
        return this.show('success', title, message, duration);
    }

    /**
     * Show error toast
     * @param {string} title - Toast title
     * @param {string} message - Toast message
     * @param {number} duration - Duration in milliseconds (0 = persistent)
     * @returns {number} Toast ID
     */
    error(title, message, duration = 0) {
        return this.show('error', title, message, duration);
    }

    /**
     * Show warning toast
     * @param {string} title - Toast title
     * @param {string} message - Toast message
     * @param {number} duration - Duration in milliseconds
     * @returns {number} Toast ID
     */
    warning(title, message, duration = this.defaultDuration) {
        return this.show('warning', title, message, duration);
    }

    /**
     * Show info toast
     * @param {string} title - Toast title
     * @param {string} message - Toast message
     * @param {number} duration - Duration in milliseconds
     * @returns {number} Toast ID
     */
    info(title, message, duration = this.defaultDuration) {
        return this.show('info', title, message, duration);
    }

    /**
     * Create toast object
     * @param {string} type - Toast type
     * @param {string} title - Toast title
     * @param {string} message - Toast message
     * @param {number} duration - Duration in milliseconds
     * @returns {Object} Toast object
     */
    createToast(type, title, message, duration) {
        const id = this.nextId++;
        return {
            id,
            type,
            title: title || this.getDefaultTitle(type),
            message: message || '',
            duration,
            timestamp: Date.now(),
            visible: true,
            element: null,
            timer: null,
            progressTimer: null
        };
    }

    /**
     * Get default title based on toast type
     * @param {string} type - Toast type
     * @returns {string} Default title
     */
    getDefaultTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error', 
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Notification';
    }

    /**
     * Add toast to DOM and manage queue
     * @param {Object} toast - Toast object
     */
    addToast(toast) {
        // Remove oldest toast if we've reached the maximum
        if (this.toasts.length >= this.maxToasts) {
            const oldestToast = this.toasts.shift();
            this.removeToastElement(oldestToast);
        }

        // Add to collection
        this.toasts.push(toast);

        // Create DOM element
        const element = this.createToastElement(toast);
        toast.element = element;

        // Add to container
        const container = document.getElementById(this.containerId);
        container.appendChild(element);

        // Trigger enter animation
        requestAnimationFrame(() => {
            element.classList.add('toast-enter-active');
        });

        // Setup auto-dismiss timer
        if (toast.duration > 0) {
            this.setupAutoDismiss(toast);
        }

        // Announce to screen readers
        this.announceToScreenReader(`${toast.title}: ${toast.message}`);

        // Emit custom event
        this.dispatchToastEvent('show', toast);
    }

    /**
     * Create toast DOM element
     * @param {Object} toast - Toast object
     * @returns {Element} Toast DOM element
     */
    createToastElement(toast) {
        const element = document.createElement('div');
        element.id = `toast-${toast.id}`;
        element.setAttribute('role', 'alert');
        element.setAttribute('aria-live', 'assertive');
        element.setAttribute('aria-atomic', 'true');
        
        const styles = this.getToastStyles(toast.type);
        element.className = `pointer-events-auto max-w-sm w-full bg-bg-white-0 border rounded-lg shadow-context-menu overflow-hidden toast-enter ${styles.border}`;

        element.innerHTML = `
            <div class="p-4">
                <div class="flex items-start">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        ${this.getToastIcon(toast.type, styles.iconColor)}
                    </div>
                    
                    <!-- Content -->
                    <div class="ml-3 flex-1">
                        <p class="text-body-sm font-medium text-txt-black-900">${this.escapeHtml(toast.title)}</p>
                        ${toast.message ? `<p class="mt-1 text-body-sm text-txt-black-700">${this.escapeHtml(toast.message)}</p>` : ''}
                    </div>

                    <!-- Close Button -->
                    <button type="button"
                            class="ml-4 flex-shrink-0 text-txt-black-400 hover:text-txt-black-600 focus:outline-none focus:ring-2 focus:ring-fr-primary-600 focus:ring-offset-2 rounded"
                            aria-label="Close notification"
                            data-toast-close="${toast.id}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            ${toast.duration > 0 ? `
                <!-- Progress Bar -->
                <div class="h-1 bg-bg-white-100">
                    <div class="h-full progress-bar-countdown ${styles.progressColor}" 
                         style="animation: countdown ${toast.duration}ms linear forwards;"></div>
                </div>
            ` : ''}
        `;

        // Setup event listeners
        this.setupToastEventListeners(element, toast);

        return element;
    }

    /**
     * Setup event listeners for toast element
     * @param {Element} element - Toast element
     * @param {Object} toast - Toast object
     */
    setupToastEventListeners(element, toast) {
        // Close button
        const closeButton = element.querySelector(`[data-toast-close="${toast.id}"]`);
        if (closeButton) {
            closeButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.dismiss(toast.id);
            });

            closeButton.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.dismiss(toast.id);
                }
            });
        }

        // Pause auto-dismiss on hover/focus
        if (toast.duration > 0) {
            element.addEventListener('mouseenter', () => {
                this.pauseToast(toast);
            });

            element.addEventListener('mouseleave', () => {
                this.resumeToast(toast);
            });

            element.addEventListener('focusin', () => {
                this.pauseToast(toast);
            });

            element.addEventListener('focusout', () => {
                this.resumeToast(toast);
            });
        }
    }

    /**
     * Setup auto-dismiss timer for toast
     * @param {Object} toast - Toast object
     */
    setupAutoDismiss(toast) {
        toast.timer = setTimeout(() => {
            this.dismiss(toast.id);
        }, toast.duration);
    }

    /**
     * Pause toast auto-dismiss
     * @param {Object} toast - Toast object
     */
    pauseToast(toast) {
        if (toast.timer) {
            clearTimeout(toast.timer);
            toast.timer = null;
        }
        
        // Pause CSS animation
        const progressBar = toast.element?.querySelector('.progress-bar-countdown');
        if (progressBar) {
            progressBar.style.animationPlayState = 'paused';
        }
    }

    /**
     * Resume toast auto-dismiss
     * @param {Object} toast - Toast object
     */
    resumeToast(toast) {
        if (toast.duration > 0 && !toast.timer) {
            // Calculate remaining time
            const elapsed = Date.now() - toast.timestamp;
            const remaining = Math.max(0, toast.duration - elapsed);
            
            if (remaining > 0) {
                toast.timer = setTimeout(() => {
                    this.dismiss(toast.id);
                }, remaining);
            }
        }

        // Resume CSS animation
        const progressBar = toast.element?.querySelector('.progress-bar-countdown');
        if (progressBar) {
            progressBar.style.animationPlayState = 'running';
        }
    }

    /**
     * Dismiss toast by ID
     * @param {number} id - Toast ID
     */
    dismiss(id) {
        const toastIndex = this.toasts.findIndex(t => t.id === id);
        if (toastIndex === -1) return;

        const toast = this.toasts[toastIndex];
        
        // Clear timer
        if (toast.timer) {
            clearTimeout(toast.timer);
        }

        // Remove from collection
        this.toasts.splice(toastIndex, 1);

        // Remove from DOM with animation
        this.removeToastElement(toast);

        // Emit custom event
        this.dispatchToastEvent('dismiss', toast);
    }

    /**
     * Remove toast element from DOM with animation
     * @param {Object} toast - Toast object
     */
    removeToastElement(toast) {
        const element = toast.element;
        if (!element || !element.parentNode) return;

        // Add exit animation
        element.classList.add('toast-exit-active');
        
        // Remove after animation
        setTimeout(() => {
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
        }, 200);
    }

    /**
     * Clear all toasts
     */
    clearAll() {
        const toastIds = this.toasts.map(t => t.id);
        toastIds.forEach(id => this.dismiss(id));
    }

    /**
     * Get toast styles based on type
     * @param {string} type - Toast type
     * @returns {Object} Style classes
     */
    getToastStyles(type) {
        const styles = {
            success: {
                border: 'border-l-4 border-l-success-600',
                iconColor: 'text-success-600',
                progressColor: 'bg-success-600'
            },
            error: {
                border: 'border-l-4 border-l-danger-600', 
                iconColor: 'text-danger-600',
                progressColor: 'bg-danger-600'
            },
            warning: {
                border: 'border-l-4 border-l-warning-600',
                iconColor: 'text-warning-600', 
                progressColor: 'bg-warning-600'
            },
            info: {
                border: 'border-l-4 border-l-primary-600',
                iconColor: 'text-primary-600',
                progressColor: 'bg-primary-600'
            }
        };

        return styles[type] || styles.info;
    }

    /**
     * Get toast icon SVG
     * @param {string} type - Toast type
     * @param {string} colorClass - Icon color class
     * @returns {string} Icon SVG HTML
     */
    getToastIcon(type, colorClass) {
        const icons = {
            success: `
                <svg class="w-5 h-5 ${colorClass}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            `,
            error: `
                <svg class="w-5 h-5 ${colorClass}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            `,
            warning: `
                <svg class="w-5 h-5 ${colorClass}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            `,
            info: `
                <svg class="w-5 h-5 ${colorClass}" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            `
        };

        return icons[type] || icons.info;
    }

    /**
     * Escape HTML to prevent XSS
     * @param {string} text - Text to escape
     * @returns {string} Escaped text
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Announce message to screen readers
     * @param {string} message - Message to announce
     */
    announceToScreenReader(message) {
        const announcer = document.createElement('div');
        announcer.setAttribute('aria-live', 'assertive');
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
     * Dispatch toast events
     * @param {string} action - Event action
     * @param {Object} toast - Toast object
     */
    dispatchToastEvent(action, toast) {
        const event = new CustomEvent('toast', {
            detail: { action, toast: { ...toast, element: null } }
        });
        document.dispatchEvent(event);
    }

    /**
     * Set toast position
     * @param {string} position - Position key
     */
    setPosition(position) {
        if (this.positions[position]) {
            this.currentPosition = position;
            const container = document.getElementById(this.containerId);
            if (container) {
                container.className = `${this.positions[position]} z-50 space-y-3 pointer-events-none max-w-sm`;
            }
        }
    }

    /**
     * Get all active toasts
     * @returns {Array} Array of active toasts
     */
    getActiveToasts() {
        return [...this.toasts];
    }

    /**
     * Get toast count
     * @returns {number} Number of active toasts
     */
    getCount() {
        return this.toasts.length;
    }
}

// Export for module usage
export default ToastManager;

// Auto-initialize
const toastManager = new ToastManager();

// Make available globally for compatibility
window.toastManager = toastManager;