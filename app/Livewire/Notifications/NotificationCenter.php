<?php

declare(strict_types=1);

namespace App\Livewire\Notifications;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
#[Title('Pusat Notifikasi - ICTServe')]
class NotificationCenter extends Component
{
    use WithPagination;

    public string $filter = 'all';
    public string $category = 'all';
    public string $priority = 'all';
    public bool $showDropdown = false;
    public bool $showMarkAllModal = false;

    protected $listeners = [
        'markAsRead' => 'markNotificationAsRead',
        'markAllAsRead' => 'markAllAsRead',
        'deleteNotification' => 'deleteNotification',
        'refreshNotifications' => '$refresh',
        'notificationReceived' => 'handleNewNotification',
    ];

    public function mount(): void
    {
        // Subscribe to real-time notifications for the current user
        if (Auth::check()) {
            $this->dispatch('subscribeToNotifications', ['userId' => Auth::id()]);
        }
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingPriority()
    {
        $this->resetPage();
    }

    #[On('notificationReceived')]
    public function handleNewNotification($data)
    {
        $this->dispatch('$refresh');

        // Show toast notification
        $this->dispatch('showToast', [
            'type' => 'info',
            'message' => $data['title'] ?? 'Notifikasi baharu diterima',
        ]);
    }

    public function openMarkAllModal()
    {
        $this->showMarkAllModal = true;
    }

    public function closeMarkAllModal()
    {
        $this->showMarkAllModal = false;
    }

    public function render()
    {
        $notifications = $this->getNotifications();
        $unreadCount = $this->getUnreadCount();
        $stats = $this->getNotificationStats();

        return view('livewire.notifications.notification-center', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'stats' => $stats,
        ]);
    }

    private function getNotifications()
    {
    $userId = $this->currentUserId();

    $query = Notification::where('user_id', $userId ?? 0)
            ->with('user')
            ->notExpired()
            ->recent();

        // Apply filters
        if ($this->filter === 'unread') {
            $query->unread();
        } elseif ($this->filter === 'read') {
            $query->read();
        }

        if ($this->category !== 'all') {
            $query->byCategory($this->category);
        }

        if ($this->priority !== 'all') {
            $query->byPriority($this->priority);
        }

        return $query->paginate(10);
    }

    private function getUnreadCount(): int
    {
        $userId = $this->currentUserId();

        return Notification::where('user_id', $userId ?? 0)
            ->unread()
            ->notExpired()
            ->count();
    }

    private function getNotificationStats(): array
    {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();

    $userId = $user?->id;

        return [
            'total' => Notification::where('user_id', $userId ?? 0)->notExpired()->count(),
            'unread' => Notification::where('user_id', $userId ?? 0)->unread()->notExpired()->count(),
            'tickets' => Notification::where('user_id', $userId ?? 0)->byCategory('ticket')->notExpired()->count(),
            'loans' => Notification::where('user_id', $userId ?? 0)->byCategory('loan')->notExpired()->count(),
            'system' => Notification::where('user_id', $userId ?? 0)->byCategory('system')->notExpired()->count(),
            'urgent' => Notification::where('user_id', $userId ?? 0)->byPriority('urgent')->notExpired()->count(),
        ];
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
        $this->resetPage();
    }

    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
        $this->resetPage();
    }

    public function toggleDropdown(): void
    {
        $this->showDropdown = ! $this->showDropdown;
    }

    public function markNotificationAsRead(int $notificationId): void
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return;
        }

        $notification = Notification::where('user_id', $userId)
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('notificationRead', $notificationId);
        }
    }

    public function markAllAsRead(): void
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return;
        }

        $unreadCount = Notification::where('user_id', $userId)
            ->unread()
            ->notExpired()
            ->count();

        if ($unreadCount > 0) {
            Notification::where('user_id', $userId)
                ->unread()
                ->get()
                ->each(fn ($notification) => $notification->markAsRead());

            session()->flash('success', "Sebanyak {$unreadCount} notifikasi telah ditandai sebagai dibaca.");
            $this->dispatch('allNotificationsRead');
        } else {
            session()->flash('info', 'Tiada notifikasi yang belum dibaca.');
        }

        $this->closeMarkAllModal();
    }

    public function deleteNotification(int $notificationId): void
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return;
        }

        $notification = Notification::where('user_id', $userId)
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->delete();
            $this->dispatch('notificationDeleted', $notificationId);
            session()->flash('message', 'Notifikasi telah dihapus / Notification deleted');
        }
    }

    public function clearAllRead(): void
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return;
        }

        Notification::where('user_id', $userId)
            ->read()
            ->delete();

        $this->dispatch('readNotificationsCleared');
        session()->flash('message', 'Semua notifikasi yang telah dibaca telah dihapus / All read notifications cleared');
    }

    private function currentUserId(): ?int
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return $user?->id;
    }

    public function getFilterOptions(): array
    {
        return [
            'all' => 'Semua / All',
            'unread' => 'Belum Dibaca / Unread',
            'read' => 'Sudah Dibaca / Read',
        ];
    }

    public function getCategoryOptions(): array
    {
        return [
            'all' => 'Semua Kategori / All Categories',
            'ticket' => 'Helpdesk Tiket / Helpdesk Tickets',
            'loan' => 'Pinjaman Peralatan / Equipment Loans',
            'system' => 'Sistem / System',
            'general' => 'Umum / General',
        ];
    }

    public function getPriorityOptions(): array
    {
        return [
            'all' => 'Semua Prioriti / All Priorities',
            'urgent' => 'Segera / Urgent',
            'high' => 'Tinggi / High',
            'medium' => 'Sederhana / Medium',
            'low' => 'Rendah / Low',
        ];
    }

    public function getPriorityColor(string $priority): string
    {
        return match ($priority) {
            'urgent' => 'bg-red-100 text-red-800 border-red-200',
            'high' => 'bg-orange-100 text-orange-800 border-orange-200',
            'medium' => 'bg-blue-100 text-blue-800 border-blue-200',
            'low' => 'bg-gray-100 text-gray-800 border-gray-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function getCategoryColor(string $category): string
    {
        return match ($category) {
            'ticket' => 'bg-blue-100 text-blue-800 border-blue-200',
            'loan' => 'bg-green-100 text-green-800 border-green-200',
            'system' => 'bg-purple-100 text-purple-800 border-purple-200',
            'general' => 'bg-gray-100 text-gray-800 border-gray-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
