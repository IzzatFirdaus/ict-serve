<?php

namespace App\Http\Controllers\Helpdesk;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 * Controller for managing helpdesk tickets.
 */
class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Show the form for creating a new ticket.
     * @return Response
     */
    public function create(): Response
    {
        // ...
    }

    /**
     * Store a newly created ticket in storage.
     * @param StoreTicketRequest $request
     * @return Response
     */
    public function store(StoreTicketRequest $request): Response
    {
        // ...
    }

    /**
     * Display the specified ticket.
     * @param Ticket $ticket
     * @return Response
     */
    public function show(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Show the form for editing the specified ticket.
     * @param Ticket $ticket
     * @return Response
     */
    public function edit(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Update the specified ticket in storage.
     * @param UpdateTicketRequest $request
     * @param Ticket $ticket
     * @return Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Remove the specified ticket from storage (soft delete).
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Assign the specified ticket to an agent.
     * @param Ticket $ticket
     * @return Response
     */
    public function assign(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Close the specified ticket.
     * @param Ticket $ticket
     * @return Response
     */
    public function close(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Reopen the specified ticket.
     * @param Ticket $ticket
     * @return Response
     */
    public function reopen(Ticket $ticket): Response
    {
        // ...
    }
}
