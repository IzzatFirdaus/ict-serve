<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class StatusWidget extends Component
{
    public $pendingLoans = 0;

    public $openTickets = 0;

    public $notifications = 0;

    public function mount()
    {
        // Mock data - will be replaced with actual queries
        $this->pendingLoans = 3;
        $this->openTickets = 5;
        $this->notifications = 2;
    }

    public function render()
    {
        return view('livewire.dashboard.status-widget');
    }
}
