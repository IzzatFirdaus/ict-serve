<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpdeskTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'status_id',
        'title',
        'description',
        'damage_type',
        'status',
        'priority',
        'urgency',
        'assigned_to',
        'assigned_at',
        'equipment_item_id',
        'location',
        'contact_phone',
        'due_at',
        'resolved_at',
        'closed_at',
        'resolution',
        'resolution_notes',
        'resolved_by',
        'satisfaction_rating',
        'feedback',
        'attachments',
    ];

    protected function casts(): array
    {
        return [
            'priority' => TicketPriority::class,
            'urgency' => TicketUrgency::class,
            'attachments' => 'array',
            'assigned_at' => 'datetime',
            'due_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
            'satisfaction_rating' => 'integer',
        ];
    }

    /**
     * Get the user who created the ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ticket category.
     */
    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Get the ticket status.
     */
    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the assigned staff member.
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the staff who resolved the ticket.
     */
    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the equipment item related to this ticket.
     */
    public function equipmentItem()
    {
        return $this->belongsTo(EquipmentItem::class, 'equipment_item_id');
    }

    /**
     * Generate unique ticket number.
     */
    public static function generateTicketNumber(): string
    {
        $prefix = 'TK' . date('Y');
        $lastTicket = static::where('ticket_number', 'like', $prefix . '%')
            ->orderBy('ticket_number', 'desc')
            ->first();

        if ($lastTicket) {
            $lastNumber = (int) substr($lastTicket->ticket_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if ticket is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_at && $this->due_at < now() && !$this->resolved_at;
    }

    /**
     * Check if ticket is resolved.
     */
    public function isResolved(): bool
    {
        return !is_null($this->resolved_at);
    }

    /**
     * Check if ticket is closed.
     */
    public function isClosed(): bool
    {
        return !is_null($this->closed_at);
    }

    /**
     * Get the response time in hours.
     */
    public function getResponseTimeAttribute(): ?float
    {
        if (!$this->assigned_at) {
            return null;
        }

        return $this->created_at->diffInHours($this->assigned_at);
    }

    /**
     * Get the resolution time in hours.
     */
    public function getResolutionTimeAttribute(): ?float
    {
        if (!$this->resolved_at) {
            return null;
        }

        return $this->created_at->diffInHours($this->resolved_at);
    }
}
