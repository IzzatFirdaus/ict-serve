<?php

namespace App\Livewire;

use App\Models\LoanRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class LoanRequestTracker extends Component
{
    public LoanRequest $loanRequest;

    public bool $showDetails = false;

    public bool $polling = false;

    public string $pollInterval = '5s';

    public function mount(LoanRequest $loanRequest, bool $polling = false, string $pollInterval = '5s')
    {
        $this->loanRequest = $loanRequest;
        $this->polling = $polling;
        $this->pollInterval = $pollInterval;
    }

    #[On('refresh-loan-status')]
    public function refreshStatus()
    {
        $this->loanRequest->refresh();
        $this->dispatch('status-refreshed', loanRequestId: $this->loanRequest->id);
    }

    public function toggleDetails()
    {
        $this->showDetails = ! $this->showDetails;
    }

    public function enablePolling()
    {
        $this->polling = true;
        $this->dispatch('polling-enabled');
    }

    public function disablePolling()
    {
        $this->polling = false;
        $this->dispatch('polling-disabled');
    }

    public function togglePolling()
    {
        $this->polling = ! $this->polling;
        $this->dispatch('polling-toggled');
    }

    public function render()
    {
        return view('livewire.loan-request-tracker');
    }
}
