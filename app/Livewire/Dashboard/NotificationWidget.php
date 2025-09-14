<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class NotificationWidget extends Component
{
    public $notifications = [];

    public function mount()
    {
        // Mock data - will be replaced with actual queries
        $this->notifications = [
            [
                'id' => 1,
                'title' => 'Permohonan Diluluskan',
                'message' => 'Permohonan pinjaman laptop telah diluluskan.',
                'time' => '2 jam yang lalu',
                'type' => 'success'
            ],
            [
                'id' => 2,
                'title' => 'Tiket Baharu',
                'message' => 'Tiket helpdesk #HD-001 telah diterima.',
                'time' => '1 hari yang lalu',
                'type' => 'info'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.notification-widget');
    }
}
