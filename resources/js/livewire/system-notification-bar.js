// Livewire System Notification Bar JS
// Listen for Livewire events (client-side hooks)
document.addEventListener('livewire:init', function () {
    const isLivewireAvailable = window.Livewire && typeof window.Livewire.on === 'function';

    function safeEmit(eventName, detail = {}) {
        if (isLivewireAvailable) {
            window.Livewire.emit(eventName, detail);
        }
        // Also dispatch a DOM event for non-Livewire consumers
        document.dispatchEvent(new CustomEvent(eventName, { detail }));
    }

    // Handle incoming Livewire events (if any)
    if (isLivewireAvailable) {
        window.Livewire.on('system-notification', function(notification) {
            // When Livewire triggers a notification, announce it for screen readers
            try {
                const region = document.querySelector('[role="status"]') || document.body;
                const sr = document.createElement('div');
                sr.className = 'sr-only';
                sr.setAttribute('aria-live', 'polite');
                sr.textContent = notification?.title ? `${notification.title} - ${notification.message || ''}` : (notification?.message || '');
                region.appendChild(sr);
                setTimeout(() => sr.remove(), 2000);
            } catch (e) {
                // ignore
            }
        });

        window.Livewire.on('maintenance-mode', function(data) {
            // Provide a console hook and dispatch DOM event
            safeEmit('maintenance-mode', data);
        });

        window.Livewire.on('system-alert', function(data) {
            safeEmit('system-alert', data);
        });
    }

    // Listen for DOM events to coordinate auto-hide and progress
    document.addEventListener('system-notification:show', function(e) {
        const detail = e.detail || {};
        const timeout = parseInt(detail.timeout || detail.autoHideTimeout || 5000, 10);
        // Inform Livewire to auto-hide after timeout if component expects it
        if (isLivewireAvailable) {
            window.Livewire.emit('requestAutoHide', { timeout });
        }

        // Dispatch an event that Livewire components can listen to (for compatibility)
        document.dispatchEvent(new CustomEvent('auto-hide-notification', { detail: { timeout } }));

        // Update CSS progress if present
        const progressBar = document.querySelector('.myds-notification-progress');
        if (progressBar) {
            progressBar.style.transition = `width ${Math.max(timeout, 400)}ms linear`;
            requestAnimationFrame(() => { progressBar.style.width = '100%'; });
        }
    });

    // Keyboard accessibility: close on Escape when notification is focused
    document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape' || ev.key === 'Esc') {
            // Let Livewire dismiss if available
            if (isLivewireAvailable) {
                window.Livewire.emit('dismissNotification');
            }
            // Also dispatch DOM event
            document.dispatchEvent(new CustomEvent('dismiss-notification'));
        }
    });

});
