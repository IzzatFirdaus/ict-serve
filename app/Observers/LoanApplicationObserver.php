<?php

namespace App\Observers;

use App\Models\LoanRequest;

class LoanApplicationObserver
{
    /**
     * Handle the LoanApplication "created" event.
     */
    public function created(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanApplication "updated" event.
     */
    public function updated(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanApplication "deleted" event.
     */
    public function deleted(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanApplication "restored" event.
     */
    public function restored(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanApplication "force deleted" event.
     */
    public function forceDeleted(LoanRequest $loanRequest): void
    {
        //
    }
}
