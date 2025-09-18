<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Create a ticket notification for relevant users
     */
    public function notifyTicketEvent(HelpdeskTicket $ticket, string $event, ?string $customMessage = null): void
    {
        $usersToNotify = collect();

        // Always notify ticket creator
        if ($ticket->user_id) {
            $usersToNotify->push($ticket->user_id);
        }

        // Notify assigned user if different
        if ($ticket->assigned_to && $ticket->assigned_to !== $ticket->user_id) {
            $usersToNotify->push($ticket->assigned_to);
        }

        // For assignment events, also notify ICT admins
        if (in_array($event, ['ticket_assigned', 'ticket_escalated'])) {
            $ictAdmins = User::where('role', 'ict_admin')->pluck('id');
            $usersToNotify = $usersToNotify->merge($ictAdmins);
        }

        // Remove duplicates
        $usersToNotify = $usersToNotify->unique();

        foreach ($usersToNotify as $userId) {
            Notification::createTicketNotification($userId, $event, $ticket, $customMessage);
        }
    }

    /**
     * Create a loan notification for relevant users
     */
    public function notifyLoanEvent(LoanRequest $loan, string $event, ?string $customMessage = null): void
    {
        $usersToNotify = collect();

        // Always notify loan requester
        if ($loan->user_id) {
            $usersToNotify->push($loan->user_id);
        }

        // Notify supervisor if different
        if ($loan->supervisor_id && $loan->supervisor_id !== $loan->user_id) {
            $usersToNotify->push($loan->supervisor_id);
        }

        // Notify ICT admin if assigned
        if ($loan->ict_admin_id && $loan->ict_admin_id !== $loan->user_id) {
            $usersToNotify->push($loan->ict_admin_id);
        }

        // For overdue equipment, also notify supervisors and ICT admins
        if (in_array($event, ['equipment_overdue', 'equipment_due'])) {
            $ictAdmins = User::where('role', 'ict_admin')->pluck('id');
            $supervisors = User::where('role', 'supervisor')->pluck('id');
            $usersToNotify = $usersToNotify->merge($ictAdmins)->merge($supervisors);
        }

        // Remove duplicates
        $usersToNotify = $usersToNotify->unique();

        foreach ($usersToNotify as $userId) {
            Notification::createLoanNotification($userId, $event, $loan, $customMessage);
        }
    }

    /**
     * Notify about new loan request
     */
    public function notifyNewLoanRequest(LoanRequest $loanRequest): void
    {
        $this->notifyLoanEvent($loanRequest, 'loan_request_submitted', 'Permohonan peminjaman baharu telah dihantar');
    }

    /**
     * Notify about loan status update
     */
    public function notifyLoanStatusUpdate(LoanRequest $loanRequest): void
    {
        $status = $loanRequest->status->name;
        $messages = [
            'approved' => 'Permohonan peminjaman anda telah diluluskan',
            'rejected' => 'Permohonan peminjaman anda telah ditolak',
            'returned' => 'Peralatan telah dikembalikan',
        ];

        $message = $messages[$status] ?? 'Status permohonan peminjaman telah dikemas kini';
        $this->notifyLoanEvent($loanRequest, "loan_status_{$status}", $message);
    }

    /**
     * Create a system-wide notification
     */
    public function notifySystemEvent(string $title, string $message, array $options = []): void
    {
        $targetRoles = $options['roles'] ?? ['all'];
        $targetUsers = $options['users'] ?? [];
        $priority = $options['priority'] ?? 'medium';
        $expiresAt = $options['expires_at'] ?? null;

        $usersToNotify = collect();

        // If specific users are targeted
        if (! empty($targetUsers)) {
            $usersToNotify = collect($targetUsers);
        }

        // If roles are targeted
        if (! empty($targetRoles)) {
            if (in_array('all', $targetRoles)) {
                $roleUsers = User::where('is_active', true)->pluck('id');
            } else {
                $roleUsers = User::whereIn('role', $targetRoles)
                    ->where('is_active', true)
                    ->pluck('id');
            }
            $usersToNotify = $usersToNotify->merge($roleUsers);
        }

        // Remove duplicates
        $usersToNotify = $usersToNotify->unique();

        foreach ($usersToNotify as $userId) {
            Notification::createSystemNotification($userId, $title, $message, [
                'priority' => $priority,
                'expires_at' => $expiresAt,
                'type' => $options['type'] ?? 'system_announcement',
                'icon' => $options['icon'] ?? null,
                'color' => $options['color'] ?? null,
                'action_url' => $options['action_url'] ?? null,
            ]);
        }
    }

    /**
     * Create equipment due/overdue notifications
     */
    public function notifyEquipmentDue(): void
    {
        $dueItems = LoanRequest::where('status', 'approved')
            ->whereHas('equipmentItem')
            ->where('expected_return_date', '>', now())
            ->where('expected_return_date', '<=', now()->addDays(3))
            ->with(['user', 'equipmentItem'])
            ->get();

        foreach ($dueItems as $loan) {
            $this->notifyLoanEvent($loan, 'equipment_due',
                "Peralatan {$loan->equipmentItem->name} akan tamat tempoh dalam 3 hari."
            );
        }

        $overdueItems = LoanRequest::where('status', 'approved')
            ->whereHas('equipmentItem')
            ->where('expected_return_date', '<', now())
            ->with(['user', 'equipmentItem'])
            ->get();

        foreach ($overdueItems as $loan) {
            $this->notifyLoanEvent($loan, 'equipment_overdue',
                "Peralatan {$loan->equipmentItem->name} telah lewat tempoh!"
            );
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->markAsRead();

            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(int $userId): int
    {
        $count = Notification::where('user_id', $userId)
            ->unread()
            ->count();

        Notification::where('user_id', $userId)
            ->unread()
            ->get()
            ->each(fn ($notification) => $notification->markAsRead());

        return $count;
    }

    /**
     * Get unread notification count for user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->unread()
            ->notExpired()
            ->count();
    }

    /**
     * Clean up expired notifications
     */
    public function cleanupExpired(): int
    {
        return (int) Notification::where('expires_at', '<', now())->delete();
    }

    /**
     * Get recent notifications for user
     */
    public function getRecentNotifications(int $userId, int $limit = 10): Collection
    {
        return Notification::where('user_id', $userId)
            ->notExpired()
            ->recent()
            ->limit($limit)
            ->get();
    }

    /**
     * Delete old read notifications (older than 30 days)
     */
    public function cleanupOldReadNotifications(): int
    {
        return (int) Notification::where('is_read', true)
            ->where('read_at', '<', now()->subDays(30))
            ->delete();
    }
}
