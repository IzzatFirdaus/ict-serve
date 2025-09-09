<?php

declare(strict_types=1);

namespace App\Livewire\Loan;

use Livewire\Component;

class Index extends Component
{
    public $userLoanStats = [];

    public function mount()
    {
        $this->loadUserStats();
    }

    public function render()
    {
        return view('livewire.loan.index');
    }

    private function loadUserStats()
    {
        $user = auth()->user();

        if (! $user) {
            $this->userLoanStats = [
                'pending' => 0,
                'active' => 0,
                'due_soon' => 0,
            ];
            return;
        }

        // In a real implementation, you would fetch this from the database
        // For now, using placeholder data
        $this->userLoanStats = [
            'pending' => 2,
            'active' => 1,
            'due_soon' => 0,
        ];
    }
}
