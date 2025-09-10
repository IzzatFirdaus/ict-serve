import './bootstrap';

// Import styles
import '../css/app.css';

// Initialize any custom JavaScript functionality here
document.addEventListener('DOMContentLoaded', function () {
  console.log('ICT Serve application initialized');

  // Custom Alpine.js data or directives can be added here
  // window.Alpine is automatically available with Livewire 3
});

// Any additional JavaScript functionality
window.showNotification = function (message, type = 'info') {
  // Simple notification system
  const notification = document.createElement('div');
  notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${
    type === 'success'
      ? 'bg-green-500'
      : type === 'error'
        ? 'bg-red-500'
        : type === 'warning'
          ? 'bg-yellow-500'
          : 'bg-blue-500'
  }`;
  notification.textContent = message;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.remove();
  }, 5000);
};
