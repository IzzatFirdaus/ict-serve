<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read TicketStatus $status
 */
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
            'assigned_at' => 'datetime',
            'due_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
            'satisfaction_rating' => 'integer',
            'attachments' => 'json',
        ];
    }

    /**
     * Get the user who created this ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of this ticket
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Get the current status of this ticket
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the user assigned to this ticket
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who resolved this ticket
     */
    public function resolvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the related equipment item
     */
    public function equipmentItem(): BelongsTo
    {
        return $this->belongsTo(EquipmentItem::class);
    }

    /**
     * Generate unique ticket number
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = static::generateTicketNumber();
            }

            // Set due_at based on category SLA if not set
            if (empty($ticket->due_at) && $ticket->category) {
                $ticket->due_at = now()->addHours($ticket->category->default_sla_hours);
            }
        });
    }

    /**
     * Generate ticket number in format: HD-YYYY-MMDD-XXX
     */
    protected static function generateTicketNumber(): string
    {
        $date = now();
        $prefix = 'HD-'.$date->format('Y-md');

        $lastTicket = static::where('ticket_number', 'like', $prefix.'%')
            ->orderBy('ticket_number', 'desc')
            ->first();

        if ($lastTicket) {
            $lastSequence = intval(substr($lastTicket->ticket_number, -3));
            $sequence = str_pad(strval($lastSequence + 1), 3, '0', STR_PAD_LEFT);
        } else {
            $sequence = '001';
        }

        return $prefix.'-'.$sequence;
    }

    /**
     * Check if ticket is overdue
     */
    public function isOverdue(): bool
    {
        if ($this->status->is_final) {
            return false;
        }

        return $this->due_at && now()->isAfter($this->due_at);
    }

    /**
     * Check if ticket is new
     */
    public function isNew(): bool
    {
        return $this->status->code === 'new';
    }

    /**
     * Check if ticket is assigned
     */
    public function isAssigned(): bool
    {
        return ! is_null($this->assigned_to);
    }

    /**
     * Check if ticket is resolved
     */
    public function isResolved(): bool
    {
        return $this->status->code === 'resolved';
    }

    /**
     * Check if ticket is closed
     */
    public function isClosed(): bool
    {
        return $this->status->code === 'closed';
    }
}
