<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class SystemNotificationBar extends Component
{
    public $notifications = [];
    public $isVisible = false;
    public $currentNotification = null;
    public $autoHideTimeout = 5000; // 5 seconds

    public function mount()
    {
        $this->loadSystemNotifications();
    }

    #[On('system-notification')]
    public function addSystemNotification($notification)
    {
        $this->notifications[] = [
            'id' => uniqid(),
            'type' => $notification['type'] ?? 'info',
            'title' => $notification['title'] ?? 'Pemberitahuan Sistem',
            'message' => $notification['message'],
            'timestamp' => now(),
            'action' => $notification['action'] ?? null,
            'persistent' => $notification['persistent'] ?? false
        ];

        $this->showNotification();
    }

    #[On('maintenance-mode')]
    public function showMaintenanceNotification($data)
    {
        $this->addSystemNotification([
            'type' => 'warning',
            'title' => 'Mod Penyelenggaraan',
            'message' => $data['message'] ?? 'Sistem akan menjalani penyelenggaraan berjadual.',
            'persistent' => true,
            'action' => [
                'label' => 'Maklumat Lanjut',
                'url' => route('maintenance.info')
            ]
        ]);
    }

    #[On('system-alert')]
    public function showSystemAlert($data)
    {
        $this->addSystemNotification([
            'type' => 'danger',
            'title' => 'Amaran Sistem',
            'message' => $data['message'],
            'persistent' => $data['persistent'] ?? true
        ]);
    }

    public function showNotification()
    {
        if (!empty($this->notifications)) {
            $this->currentNotification = array_shift($this->notifications);
            $this->isVisible = true;

            // Auto-hide for non-persistent notifications
            if (!$this->currentNotification['persistent']) {
                $this->dispatch('auto-hide-notification', timeout: $this->autoHideTimeout);
            }
        }
    }

    public function hideNotification()
    {
        $this->isVisible = false;
        $this->currentNotification = null;

        // Show next notification if any
        if (!empty($this->notifications)) {
            $this->showNotification();
        }
    }

    public function dismissNotification()
    {
        $this->hideNotification();
    }

    public function executeAction()
    {
        if ($this->currentNotification && isset($this->currentNotification['action']['url'])) {
            return redirect($this->currentNotification['action']['url']);
        }
    }

    protected function loadSystemNotifications()
    {
        // Load any pending system notifications
        // This could come from database, cache, or config
        $systemNotifications = collect([]);

        // Check for maintenance mode
        if (app()->isDownForMaintenance()) {
            $systemNotifications->push([
                'type' => 'warning',
                'title' => 'Mod Penyelenggaraan',
                'message' => 'Sistem sedang dalam mod penyelenggaraan.',
                'persistent' => true
            ]);
        }

        $this->notifications = $systemNotifications->toArray();

        if (!empty($this->notifications)) {
            $this->showNotification();
        }
    }

    protected function getNotificationClasses($type)
    {
        return match($type) {
            'warning' => 'bg-warning-50 border border-warning-200',
            'danger' => 'bg-danger-50 border border-danger-200',
            'success' => 'bg-success-50 border border-success-200',
            default => 'bg-primary-50 border border-primary-200'
        };
    }

    protected function getTitleColor($type)
    {
        return match($type) {
            'warning' => 'text-warning-800',
            'danger' => 'text-danger-800',
            'success' => 'text-success-800',
            default => 'text-primary-800'
        };
    }

    protected function getMessageColor($type)
    {
        return match($type) {
            'warning' => 'text-warning-700',
            'danger' => 'text-danger-700',
            'success' => 'text-success-700',
            default => 'text-primary-700'
        };
    }

    protected function getCloseIconColor($type)
    {
        return match($type) {
            'warning' => 'text-warning-600',
            'danger' => 'text-danger-600',
            'success' => 'text-success-600',
            default => 'text-primary-600'
        };
    }

    public function render()
    {
        return view('livewire.notifications.system-notification-bar');
    }
}
