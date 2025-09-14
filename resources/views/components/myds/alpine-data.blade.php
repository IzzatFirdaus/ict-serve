{{-- MYDS Alpine.js Data Components --}}
<script>
// MYDS Global Alpine.js Data
document.addEventListener('alpine:init', () => {
    // Mobile Navigation
    Alpine.data('mobileNav', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        }
    }));

    // Modal Management
    Alpine.data('modal', (defaultOpen = false) => ({
        open: defaultOpen,
        show() {
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        hide() {
            this.open = false;
            document.body.style.overflow = '';
        },
        toggle() {
            this.open ? this.hide() : this.show();
        }
    }));

    // Tabs Component
    Alpine.data('tabs', (defaultTab = null) => ({
        activeTab: defaultTab,
        setActive(tab) {
            this.activeTab = tab;
        },
        isActive(tab) {
            return this.activeTab === tab;
        }
    }));

    // Dropdown Management
    Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        }
    }));

    // Tooltip Management
    Alpine.data('tooltip', (delay = 0) => ({
        show: false,
        timeout: null,
        showTooltip() {
            if (this.timeout) clearTimeout(this.timeout);
            if (delay > 0) {
                this.timeout = setTimeout(() => this.show = true, delay);
            } else {
                this.show = true;
            }
        },
        hideTooltip() {
            if (this.timeout) clearTimeout(this.timeout);
            this.show = false;
        }
    }));

    // Form Validation Helpers
    Alpine.data('formValidation', () => ({
        errors: {},
        touched: {},
        setError(field, message) {
            this.errors[field] = message;
        },
        clearError(field) {
            delete this.errors[field];
        },
        hasError(field) {
            return this.errors.hasOwnProperty(field);
        },
        getError(field) {
            return this.errors[field] || '';
        },
        touch(field) {
            this.touched[field] = true;
        },
        isTouched(field) {
            return this.touched.hasOwnProperty(field);
        },
        validateField(field, value, rules) {
            this.touch(field);
            // Basic validation - extend as needed
            if (rules.required && (!value || value.trim() === '')) {
                this.setError(field, 'This field is required');
                return false;
            }
            if (rules.email && value && !this.isValidEmail(value)) {
                this.setError(field, 'Please enter a valid email address');
                return false;
            }
            if (rules.minLength && value && value.length < rules.minLength) {
                this.setError(field, `Must be at least ${rules.minLength} characters`);
                return false;
            }
            this.clearError(field);
            return true;
        },
        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    }));

    // Progress Tracking
    Alpine.data('progress', (initialValue = 0, max = 100) => ({
        value: initialValue,
        max: max,
        percentage: 0,
        init() {
            this.updatePercentage();
        },
        setValue(newValue) {
            this.value = Math.min(Math.max(0, newValue), this.max);
            this.updatePercentage();
        },
        updatePercentage() {
            this.percentage = (this.value / this.max) * 100;
        },
        increment(amount = 1) {
            this.setValue(this.value + amount);
        },
        decrement(amount = 1) {
            this.setValue(this.value - amount);
        }
    }));

    // Character Counter for Textareas
    Alpine.data('characterCounter', (maxLength) => ({
        count: 0,
        maxLength: maxLength,
        updateCount(value) {
            this.count = value ? value.length : 0;
        },
        isOverLimit() {
            return this.count > this.maxLength;
        },
        remainingCharacters() {
            return this.maxLength - this.count;
        }
    }));

    // File Upload Management
    Alpine.data('fileUpload', (maxFiles = 5, allowedTypes = []) => ({
        files: [],
        dragover: false,
        errors: [],
        maxFiles: maxFiles,
        allowedTypes: allowedTypes,
        addFiles(fileList) {
            this.errors = [];
            const newFiles = Array.from(fileList);

            // Check file count
            if (this.files.length + newFiles.length > this.maxFiles) {
                this.errors.push(`Maximum ${this.maxFiles} files allowed`);
                return;
            }

            // Validate file types
            for (const file of newFiles) {
                if (this.allowedTypes.length > 0 && !this.allowedTypes.includes(file.type)) {
                    this.errors.push(`${file.name}: Invalid file type`);
                    continue;
                }
                this.files.push(file);
            }
        },
        removeFile(index) {
            this.files.splice(index, 1);
        },
        clearFiles() {
            this.files = [];
            this.errors = [];
        },
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }));
});

// Global MYDS Utilities
window.MYDS = {
    // Focus management
    trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
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
        });

        firstElement.focus();
    },

    // Escape key handler
    onEscape(callback) {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                callback();
            }
        });
    },

    // Announce to screen readers
    announce(message, priority = 'polite') {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', priority);
        announcement.setAttribute('aria-atomic', 'true');
        announcement.setAttribute('class', 'sr-only');
        announcement.textContent = message;

        document.body.appendChild(announcement);

        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    },

    // Theme management
    setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('myds-theme', theme);
    },

    getTheme() {
        return localStorage.getItem('myds-theme') || 'light';
    },

    initTheme() {
        const savedTheme = this.getTheme();
        this.setTheme(savedTheme);
    }
};

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', () => {
    window.MYDS.initTheme();
});
</script>
