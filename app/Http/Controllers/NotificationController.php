<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Controller for managing notifications (current user only).
 */
class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     * @return Response
     */
    public function index(): Response
    {
        // ...
    }

    /**
     * Display the specified notification.
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        // ...
    }

    /**
     * Remove the specified notification from storage.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id): Response
    {
        // ...
    }

    /**
     * Mark the specified notification as read.
     * @param string $id
     * @return Response
     */
    public function markAsRead(string $id): Response
    {
        // ...
    }
}
