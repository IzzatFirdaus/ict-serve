export function userMenu() {
  return {
    open: false,
    showNotifications: false,

    markAllAsRead() {
      // Placeholder: trigger an API call or Livewire action to mark notifications as read
      this.showNotifications = false;
      if (window.showToast)
        window.showToast('Semua notifikasi ditanda sebagai dibaca', 'success');
    },
  };
}
