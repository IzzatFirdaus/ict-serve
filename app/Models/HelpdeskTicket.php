<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $ticket_number
 * @property int $user_id
 * @property int $category_id
 * @property int $status_id
 * @property string $title
 * @property string $description
 * @property TicketPriority $priority
 * @property TicketUrgency $urgency
 * @property int|null $assigned_to
 * @property \Carbon\Carbon|null $assigned_at
 * @property int|null $equipment_item_id
 * @property string|null $location
 * @property string|null $contact_phone
 * @property \Carbon\Carbon|null $due_at
 * @property \Carbon\Carbon|null $resolved_at
 * @property \Carbon\Carbon|null $closed_at
 * @property string|null $resolution
 * @property string|null $resolution_notes
 * @property int|null $resolved_by
 * @property int|null $satisfaction_rating
 * @property string|null $feedback
 * @property array|null $attachments
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read User $user
 * @property-read TicketCategory $category
 * @property-read TicketStatus $status
 * @property-read User|null $assignedToUser
 * @property-read User|null $resolvedByUser
 * @property-read EquipmentItem|null $equipmentItem
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TicketComment> $comments
 * @property-read float|null $response_time
 * @property-read float|null $resolution_time
 * @property-read string $reference_code
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ticket category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    /**
     * Get the ticket status.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the user assigned to this ticket.
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the staff who resolved the ticket.
     */
    public function resolvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the equipment item related to this ticket.
     */
    public function equipmentItem(): BelongsTo
    {
        return $this->belongsTo(EquipmentItem::class, 'equipment_item_id');
    }

    /**
     * Alias for assignedToUser relationship.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->assignedToUser();
    }

    /**
     * Alias for resolvedByUser relationship.
     */
    public function resolvedBy(): BelongsTo
    {
        return $this->resolvedByUser();
    }

    /**
     * Alias for status relationship.
     */
    public function ticketStatus(): BelongsTo
    {
        return $this->status();
    }

    /**
     * Get ticket comments relationship.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class, 'ticket_id');
    }

    /**
     * Check if ticket is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_at && $this->due_at < now() && ! $this->resolved_at;
    }

    /**
     * Check if ticket is resolved.
     */
    public function isResolved(): bool
    {
        return ! is_null($this->resolved_at);
    }

    /**
     * Check if ticket is closed.
     */
    public function isClosed(): bool
    {
        return ! is_null($this->closed_at);
    }

    /**
     * Get the response time in hours.
     */
    public function getResponseTimeAttribute(): ?float
    {
        if (! $this->assigned_at) {
            return null;
        }

        return $this->created_at->diffInHours($this->assigned_at);
    }

    /**
     * Get the resolution time in hours.
     */
    public function getResolutionTimeAttribute(): ?float
    {
        if (! $this->resolved_at) {
            return null;
        }

        return $this->created_at->diffInHours($this->resolved_at);
    }

    /**
     * Generate ticket number in format: HD-YYYY-MMDD-XXX
     */
    public static function generateTicketNumber(): string
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
     * Generate unique ticket number
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($ticket): void {
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
     * Get the reference code (alias for ticket_number).
     */
    public function getReferenceCodeAttribute(): string
    {
        return $this->ticket_number;
    }
}
