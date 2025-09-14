<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\Attributes\On;

class ToastContainer extends Component
{
    public $toasts = [];

    #[On('showToast')]
    public function showToast($data)
    {
        $toast = [
            'id' => uniqid(),
            'type' => $data['type'] ?? 'info',
            'title' => $data['title'] ?? '',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 5000,
            'timestamp' => now(),
        ];

        $this->toasts[] = $toast;

        // Auto-dismiss the toast after the specified duration
        $this->dispatch('dismissToast', $toast['id']);
    }

    #[On('dismissToast')]
    public function dismissToast($toastId)
    {
        $this->toasts = array_filter($this->toasts, function ($toast) use ($toastId) {
            return $toast['id'] !== $toastId;
        });
    }

    public function removeToast($toastId)
    {
        $this->dismissToast($toastId);
    }

    public function render()
    {
        return view('livewire.notifications.toast-container');
    }
}
