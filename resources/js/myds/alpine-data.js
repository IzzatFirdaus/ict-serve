// Strictly follows MYDS standards and MyGovEA principles
// Bahasa Melayu comments for accessibility and citizen-centricity
document.addEventListener('alpine:init', () => {
  // Navigasi Mudah Alih (Mobile Navigation)
  Alpine.data('mobileNav', () => ({
    open: false,
    toggle() {
      this.open = !this.open;
    },
    close() {
      this.open = false;
    },
  }));

  // Pengurusan Modals (Modal Management)
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
    },
  }));

  // Komponen Tab (Tabs)
  Alpine.data('tabs', (defaultTab = null) => ({
    activeTab: defaultTab,
    setActive(tab) {
      this.activeTab = tab;
    },
    isActive(tab) {
      return this.activeTab === tab;
    },
  }));

  // Dropdown (Senarai Pilihan)
  Alpine.data('dropdown', () => ({
    open: false,
    toggle() {
      this.open = !this.open;
    },
    close() {
      this.open = false;
    },
  }));

  // Tooltip (Maklumat Bantuan)
  Alpine.data('tooltip', (delay = 0) => ({
    show: false,
    timeout: null,
    showTooltip() {
      if (this.timeout) clearTimeout(this.timeout);
      if (delay > 0) {
        this.timeout = setTimeout(() => (this.show = true), delay);
      } else {
        this.show = true;
      }
    },
    hideTooltip() {
      if (this.timeout) clearTimeout(this.timeout);
      this.show = false;
    },
  }));

  // Validasi Borang (Form Validation)
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
      // BM error messages
      if (rules.required && (!value || value.trim() === '')) {
        this.setError(field, 'Medan ini wajib diisi');
        return false;
      }
      if (rules.email && value && !this.isValidEmail(value)) {
        this.setError(field, 'Sila masukkan emel yang sah');
        return false;
      }
      if (rules.minLength && value && value.length < rules.minLength) {
        this.setError(field, `Minimum ${rules.minLength} aksara diperlukan`);
        return false;
      }
      this.clearError(field);
      return true;
    },
    isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    },
  }));

  // Penjejak Kemajuan (Progress Tracking)
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
    },
  }));

  // Kira Aksara (Character Counter)
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
    },
  }));

  // Pengurusan Fail (File Upload)
  Alpine.data('fileUpload', (maxFiles = 5, allowedTypes = []) => ({
    files: [],
    dragover: false,
    errors: [],
    maxFiles: maxFiles,
    allowedTypes: allowedTypes,
    addFiles(fileList) {
      this.errors = [];
      const newFiles = Array.from(fileList);
      if (this.files.length + newFiles.length > this.maxFiles) {
        this.errors.push(`Maksimum ${this.maxFiles} fail dibenarkan`);
        return;
      }
      for (const file of newFiles) {
        if (
          this.allowedTypes.length > 0 &&
          !this.allowedTypes.includes(file.type)
        ) {
          this.errors.push(`${file.name}: Jenis fail tidak sah`);
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
    },
  }));
});

// Utiliti MYDS Global
window.MYDS = {
  // Pengurusan Fokus (Focus management)
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
  // Pengumuman kepada pembaca skrin (Announce to screen readers)
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
  // Pengurusan Tema (Theme management)
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
  },
};
// Inisialisasi tema pada muat halaman
document.addEventListener('DOMContentLoaded', () => {
  window.MYDS.initTheme();
});
