<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\HelpdeskComment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHelpdeskCommentRequest;
use Illuminate\Http\Response;

/**
 * Controller for managing helpdesk comments (nested under tickets).
 */
class HelpdeskCommentController extends Controller
{
    /**
     * Display a listing of the comments for a ticket.
     * @param Ticket $ticket
     * @return Response
     */
    public function index(Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Store a newly created comment for a ticket.
     * @param StoreHelpdeskCommentRequest $request
     * @param Ticket $ticket
     * @return Response
     */
    public function store(StoreHelpdeskCommentRequest $request, Ticket $ticket): Response
    {
        // ...
    }

    /**
     * Remove the specified comment from a ticket.
     * @param Ticket $ticket
     * @param HelpdeskComment $comment
     * @return Response
     */
    public function destroy(Ticket $ticket, HelpdeskComment $comment): Response
    {
        // ...
    }
}
