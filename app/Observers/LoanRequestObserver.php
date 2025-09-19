<?php

namespace App\Observers;

use App\Models\LoanRequest;

class LoanRequestObserver
{
    /**
     * Handle the LoanRequest "created" event.
     */
    public function created(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanRequest "updated" event.
     */
    public function updated(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanRequest "deleted" event.
     */
    public function deleted(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanRequest "restored" event.
     */
    public function restored(LoanRequest $loanRequest): void
    {
        //
    }

    /**
     * Handle the LoanRequest "force deleted" event.
     */
    public function forceDeleted(LoanRequest $loanRequest): void
    {
        //
    }
}
