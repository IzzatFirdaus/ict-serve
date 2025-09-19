// Mobile menu toggle
window.addEventListener('DOMContentLoaded', function () {
  const menuBtn = document.getElementById('mobile-menu-button');
  if (menuBtn) {
    menuBtn.addEventListener('click', function () {
      const mobileMenu = document.getElementById('mobile-menu');
      if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
      }
    });
  }
  // Language switcher (placeholder - would need proper implementation)
  const langSelect = document.querySelector('select');
  if (langSelect) {
    langSelect.addEventListener('change', function () {
      // Implement language switching logic
    });
  }
});
