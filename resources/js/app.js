import './bootstrap';
import './theme';

// Import styles
import '../css/app.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Initialize any custom JavaScript functionality here
document.addEventListener('DOMContentLoaded', function () {
  console.log('ICT Serve application initialized with MYDS theme support');

  // Custom Alpine.js data or directives can be added here
  // window.Alpine is automatically available with Livewire 3
});

// Show loading indicator initially (for SPA/Livewire/JS hydration)
document.addEventListener('DOMContentLoaded', function() {
  const loading = document.getElementById('loading-indicator');
  if (loading) loading.style.display = 'flex';
});
window.addEventListener('load', function() {
  setTimeout(function() {
    const loading = document.getElementById('loading-indicator');
    if (loading) loading.style.display = 'none';
  }, 800); // Slight delay for perceived performance
});

// Accessibility: focus visible polyfill for better keyboard navigation
(function() {
  if (!document.querySelector('#myds-focus-visible')) {
    var style = document.createElement('style');
    style.id = 'myds-focus-visible';
    style.innerHTML = `.js-focus-visible :focus:not([data-focus-visible-added]) { outline: none !important; }`;
    document.head.appendChild(style);
  }
})();

// Enhanced notification system with MYDS styling
window.showNotification = function (message, type = 'info', duration = 5000) {
  const notification = document.createElement('div');

  // MYDS-compliant notification styling
  const typeClasses = {
    success: 'bg-success-600 text-white border-success-600',
    error: 'bg-danger-600 text-white border-danger-600',
    warning: 'bg-warning-600 text-white border-warning-600',
    info: 'bg-primary-600 text-white border-primary-600',
  };

  notification.className = `
    fixed top-4 right-4 p-4 rounded-radius-m shadow-context-menu z-50 max-w-sm
    border animate-slide-in-right ${typeClasses[type] || typeClasses.info}
  `;

  // Add icon based on type
  const icons = {
    success: `<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>`,
    error: `<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>`,
    warning: `<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>`,
    info: `<svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
           </svg>`,
  };

  notification.innerHTML = `
    <div class="flex items-center">
      ${icons[type] || icons.info}
      <span class="text-body-sm">${message}</span>
      <button class="ml-3 text-white/80 hover:text-white" onclick="this.parentElement.parentElement.remove()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
  `;

  document.body.appendChild(notification);

  // Auto remove notification
  setTimeout(() => {
    notification.style.animation = 'slide-out-right 0.3s ease-in forwards';
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove();
      }
    }, 300);
  }, duration);

  return notification;
};

// Add CSS animations for notifications
if (!document.querySelector('#myds-animations')) {
  const style = document.createElement('style');
  style.id = 'myds-animations';
  style.textContent = `
    @keyframes slide-in-right {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slide-out-right {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(100%);
        opacity: 0;
      }
    }

    .animate-slide-in-right {
      animation: slide-in-right 0.3s ease-out;
    }
  `;
  document.head.appendChild(style);
}

// Import extracted component helpers
import { searchComponent } from './components/search';
import { fileUpload } from './components/file-upload';
import { toastContainer, registerGlobalToastHelpers } from './components/toast';
import { userMenu } from './components/user-menu';

// Register toast helpers globally
registerGlobalToastHelpers();

// Expose components to global scope so Blade x-data can reference them
window.searchComponent = searchComponent;
window.fileUpload = fileUpload;
window.toastContainer = toastContainer;
window.userMenu = userMenu;
