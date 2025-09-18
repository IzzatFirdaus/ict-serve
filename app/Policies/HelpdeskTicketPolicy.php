<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\HelpdeskTicket;
use App\Models\User;

class HelpdeskTicketPolicy
{
    public function view(User $user, HelpdeskTicket $ticket): bool
    {
        if ($user->id === $ticket->user_id) {
            return true;
        }

        if ($ticket->assigned_to && $user->id === $ticket->getOriginal('assigned_to')) {
            return true;
        }

        return in_array($user->role, [UserRole::ICT_ADMIN, UserRole::HELPDESK_STAFF], true);
    }

    public function update(User $user, HelpdeskTicket $ticket): bool
    {
        if ($ticket->assigned_to && $user->id === $ticket->assigned_to) {
            return true;
        }

        return in_array($user->role, [UserRole::ICT_ADMIN, UserRole::HELPDESK_STAFF], true);
    }

    public function delete(User $user, HelpdeskTicket $ticket): bool
    {
        return in_array($user->role, [UserRole::ICT_ADMIN], true);
    }
}
