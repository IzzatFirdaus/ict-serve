export function toastContainer() {
  return {
    toasts: [],
    nextId: 1,

    addToast(data) {
      const toast = {
        id: this.nextId++,
        type: data.type || 'info',
        title: data.title || null,
        message: data.message || '',
        duration: typeof data.duration === 'number' ? data.duration : 5000,
        ...data,
      };

      this.toasts.push(toast);
      if (this.toasts.length > 5) this.toasts.shift();
    },
  };
}

// Global toast helpers aligned with MYDS AutoToast pattern
export function registerGlobalToastHelpers() {
  window.toast = function (type, message, title = null, options = {}) {
    window.dispatchEvent(
      new CustomEvent('toast', {
        detail: {
          type,
          message,
          title,
          ...options,
        },
      })
    );
  };

  window.showToast = function (message, type = 'info', duration = 5000) {
    window.dispatchEvent(
      new CustomEvent('toast', {
        detail: { type, message, duration },
      })
    );
  };
}
