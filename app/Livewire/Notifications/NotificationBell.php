<?php

declare(strict_types=1);

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $showDropdown = false;

    public int $maxNotifications = 5;

    protected $listeners = [
        'notificationRead' => '$refresh',
        'allNotificationsRead' => '$refresh',
        'notificationDeleted' => '$refresh',
        'refreshNotifications' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.notifications.notification-bell', [
            'unreadCount' => $this->getUnreadCount(),
            'recentNotifications' => $this->getRecentNotifications(),
        ]);
    }

    #[Computed]
    public function getUnreadCount(): int
    {
        return Notification::where('user_id', auth()->id())
            ->unread()
            ->notExpired()
            ->count();
    }

    #[Computed]
    public function getRecentNotifications()
    {
        return Notification::where('user_id', auth()->id())
            ->notExpired()
            ->recent()
            ->limit($this->maxNotifications)
            ->get();
    }

    public function toggleDropdown(): void
    {
        $this->showDropdown = ! $this->showDropdown;
    }

    public function closeDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function markAsRead(int $notificationId): void
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('notificationRead', $notificationId);
        }
    }

    public function markAllAsRead(): void
    {
        Notification::where('user_id', auth()->id())
            ->unread()
            ->get()
            ->each(fn ($notification) => $notification->markAsRead());

        $this->dispatch('allNotificationsRead');
        $this->showDropdown = false;
    }

    public function getNotificationIcon(string $type): string
    {
        return match ($type) {
            'ticket_created' => 'exclamation-circle',
            'ticket_updated' => 'arrow-path',
            'ticket_assigned' => 'user-plus',
            'ticket_resolved' => 'check-circle',
            'loan_requested' => 'clipboard-document-list',
            'loan_approved' => 'check',
            'loan_rejected' => 'x-circle',
            'loan_returned' => 'arrow-left',
            'equipment_due' => 'clock',
            'equipment_overdue' => 'exclamation-triangle',
            'system_announcement' => 'megaphone',
            'system_maintenance' => 'cog-6-tooth',
            'user_assigned' => 'user-group',
            default => 'information-circle'
        };
    }

    public function getPriorityColor(string $priority): string
    {
        return match ($priority) {
            'urgent' => 'text-red-600',
            'high' => 'text-orange-600',
            'medium' => 'text-blue-600',
            'low' => 'text-gray-600',
            default => 'text-gray-600',
        };
    }

    public function formatTimeAgo(string $createdAt): string
    {
        $diff = now()->diffInMinutes($createdAt);

        if ($diff < 1) {
            return 'Baru sahaja';
        } elseif ($diff < 60) {
            return $diff.' minit lalu';
        } elseif ($diff < 1440) {
            $hours = floor($diff / 60);

            return $hours.' jam lalu';
        } else {
            $days = floor($diff / 1440);

            return $days.' hari lalu';
        }
    }
}
