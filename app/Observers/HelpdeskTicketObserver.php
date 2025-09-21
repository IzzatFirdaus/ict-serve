<?php

namespace App\Observers;

use App\Models\HelpdeskTicket;

class HelpdeskTicketObserver
{
    /**
     * Handle the HelpdeskTicket "created" event.
     */
    public function created(HelpdeskTicket $helpdeskTicket): void
    {
        //
    }

    /**
     * Handle the HelpdeskTicket "updated" event.
     */
    public function updated(HelpdeskTicket $helpdeskTicket): void
    {
        //
    }

    /**
     * Handle the HelpdeskTicket "deleted" event.
     */
    public function deleted(HelpdeskTicket $helpdeskTicket): void
    {
        //
    }

    /**
     * Handle the HelpdeskTicket "restored" event.
     */
    public function restored(HelpdeskTicket $helpdeskTicket): void
    {
        //
    }

    /**
     * Handle the HelpdeskTicket "force deleted" event.
     */
    public function forceDeleted(HelpdeskTicket $helpdeskTicket): void
    {
        //
    }
}
