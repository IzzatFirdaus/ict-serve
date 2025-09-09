<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'title',
        'message',
        'data',
        'category',
        'priority',
        'is_read',
        'read_at',
        'action_url',
        'icon',
        'color',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function markAsRead(): void
    {
        if (! $this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPriority(): bool
    {
        return in_array($this->priority, ['high', 'urgent']);
    }

    public function getIconAttribute(?string $value): string
    {
        if ($value) {
            return $value;
        }

        // Default icons based on type
        return match ($this->type) {
            'ticket_created' => 'exclamation-circle',
            'ticket_updated' => 'refresh',
            'ticket_assigned' => 'user-add',
            'ticket_resolved' => 'check-circle',
            'loan_requested' => 'clipboard-list',
            'loan_approved' => 'check',
            'loan_rejected' => 'x-circle',
            'loan_returned' => 'arrow-left',
            'equipment_due' => 'clock',
            'equipment_overdue' => 'exclamation-triangle',
            'system_announcement' => 'speakerphone',
            'system_maintenance' => 'cog',
            'user_assigned' => 'user-group',
            default => 'information-circle'
        };
    }

    public function getColorAttribute(?string $value): string
    {
        if ($value) {
            return $value;
        }

        // Default colors based on priority and type
        return match ($this->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'blue',
            default => match ($this->category) {
                'ticket' => 'blue',
                'loan' => 'green',
                'system' => 'purple',
                default => 'gray'
            }
        };
    }

    public function getTimeAgo(): string
    {
        $diffInMinutes = $this->created_at->diffInMinutes();

        if ($diffInMinutes < 1) {
            return 'Baru sahaja / Just now';
        } elseif ($diffInMinutes < 60) {
            return $diffInMinutes.' minit lalu / minutes ago';
        } elseif ($diffInMinutes < 1440) { // Less than 24 hours
            $hours = floor($diffInMinutes / 60);

            return $hours.' jam lalu / hours ago';
        } elseif ($diffInMinutes < 10080) { // Less than 7 days
            $days = floor($diffInMinutes / 1440);

            return $days.' hari lalu / days ago';
        } else {
            return $this->created_at->format('d/m/Y');
        }
    }

    // Static methods for creating notifications
    public static function createForUser(int $userId, array $data): self
    {
        return static::create([
            'user_id' => $userId,
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'data' => $data['data'] ?? null,
            'category' => $data['category'] ?? 'general',
            'priority' => $data['priority'] ?? 'medium',
            'action_url' => $data['action_url'] ?? null,
            'icon' => $data['icon'] ?? null,
            'color' => $data['color'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);
    }

    public static function createTicketNotification(int $userId, string $type, HelpdeskTicket $ticket, ?string $message = null): self
    {
        $titles = [
            'ticket_created' => 'Tiket Baharu Dicipta / New Ticket Created',
            'ticket_updated' => 'Tiket Dikemaskini / Ticket Updated',
            'ticket_assigned' => 'Tiket Ditugaskan / Ticket Assigned',
            'ticket_resolved' => 'Tiket Diselesaikan / Ticket Resolved',
        ];

        return static::createForUser($userId, [
            'type' => $type,
            'title' => $titles[$type] ?? 'Kemaskini Tiket / Ticket Update',
            'message' => $message ?: "Tiket #{$ticket->ticket_number} - {$ticket->title}",
            'category' => 'ticket',
            'priority' => match ($ticket->priority) {
                'critical' => 'urgent',
                'high' => 'high',
                'medium' => 'medium',
                'low' => 'low',
                default => 'medium'
            },
            'action_url' => route('helpdesk.index-enhanced'),
            'data' => [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'ticket_title' => $ticket->title,
            ],
        ]);
    }

    public static function createLoanNotification(int $userId, string $type, LoanRequest $loan, ?string $message = null): self
    {
        $titles = [
            'loan_requested' => 'Permohonan Pinjaman Baharu / New Loan Request',
            'loan_approved' => 'Pinjaman Diluluskan / Loan Approved',
            'loan_rejected' => 'Pinjaman Ditolak / Loan Rejected',
            'loan_returned' => 'Pinjaman Dipulangkan / Loan Returned',
            'equipment_due' => 'Peralatan Hampir Tamat Tempoh / Equipment Due Soon',
            'equipment_overdue' => 'Peralatan Lewat Tempoh / Equipment Overdue',
        ];

        return static::createForUser($userId, [
            'type' => $type,
            'title' => $titles[$type] ?? 'Kemaskini Pinjaman / Loan Update',
            'message' => $message ?: "Pinjaman untuk {$loan->equipmentItem->name}",
            'category' => 'loan',
            'priority' => in_array($type, ['equipment_overdue']) ? 'urgent' : 'medium',
            'action_url' => route('loan.index'),
            'data' => [
                'loan_id' => $loan->id,
                'equipment_name' => $loan->equipmentItem->name,
                'loan_status' => $loan->status,
            ],
        ]);
    }

    public static function createSystemNotification(int $userId, string $title, string $message, array $options = []): self
    {
        return static::createForUser($userId, array_merge([
            'type' => 'system_announcement',
            'title' => $title,
            'message' => $message,
            'category' => 'system',
            'priority' => 'medium',
        ], $options));
    }
}
