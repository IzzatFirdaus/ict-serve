<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class QuickAccessWidget extends Component
{
    public function render()
    {
        return view('livewire.dashboard.quick-access-widget');
    }

    public function navigateToLoanApplication()
    {
        return redirect()->route('loan.application.create');
    }

    public function navigateToHelpdeskTicket()
    {
        return redirect()->route('helpdesk.ticket.create');
    }
}
