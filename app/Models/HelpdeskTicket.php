<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketUrgency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $ticket_number
 * @property int $user_id
 * @property int $category_id
 * @property int $status_id
 * @property string $title
 * @property string $description
 * @property string $priority
 * @property string $urgency
 * @property int|null $assigned_to
 * @property \Illuminate\Support\Carbon|null $assigned_at
 * @property int|null $equipment_item_id
 * @property string|null $location
 * @property string|null $contact_phone
 * @property \Illuminate\Support\Carbon|null $due_at
 * @property \Illuminate\Support\Carbon|null $resolved_at
 * @property \Illuminate\Support\Carbon|null $closed_at
 * @property string|null $resolution
 * @property string|null $resolution_notes
 * @property int|null $resolved_by
 * @property int|null $satisfaction_rating
 * @property string|null $feedback
 * @property array|null $attachments
 * @property array|null $file_attachments
 * @property array|null $activity_log
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TicketCategory $category
 * @property-read \App\Models\TicketStatus $status
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $assignedTo
 * @property-read \App\Models\User|null $assignedToUser
 * @property-read \App\Models\User|null $resolvedByUser
 * @property-read \App\Models\EquipmentItem|null $equipmentItem
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TicketComment> $comments
 * @property-read float|null $response_time
 * @property-read float|null $resolution_time
 * @property-read string $reference_code
 * @property-read mixed $activity_log
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class HelpdeskTicket extends Model
{
    use HasFactory;

    /**
     * Get the status for this ticket (relation for 'status').
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the assigned user (for 'assignedToUser' relation).
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who resolved the ticket (for 'resolvedByUser' relation).
     */
    public function resolvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the comments for this ticket.
     */
    public function comments()
    {
        return $this->hasMany(TicketComment::class, 'ticket_id');
    }

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
        'file_attachments',
        'activity_log',
        'admin_remarks',
    ];

    /**
     * Accessor for admin_remarks (stub for Larastan compatibility)
     */
    public function getAdminRemarksAttribute(): ?string
    {
        return $this->attributes['admin_remarks'] ?? null;
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
    public function ticketStatus(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    /**
     * Get the assigned staff member.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the staff who resolved the ticket.
     */
    public function resolvedBy(): BelongsTo
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
     * Check if ticket is overdue
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

    protected function casts(): array
    {
        return [
            'priority' => TicketPriority::class,
            'urgency' => TicketUrgency::class,
            'assigned_at' => 'datetime',
            'due_at' => 'datetime',
            'resolved_at' => 'datetime',
            'closed_at' => 'datetime',
            'satisfaction_rating' => 'integer',
            'attachments' => 'json',
            'file_attachments' => 'array',
            'activity_log' => 'array',
        ];
    }

    /**
     * Boot the model and auto-generate ticket_number if not set.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($ticket): void {
            if (empty($ticket->ticket_number)) {
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

                $ticket->ticket_number = $prefix.'-'.$sequence;
            }

            // Set due_at based on category SLA if not set
            if (empty($ticket->due_at) && $ticket->category) {
                $ticket->due_at = now()->addHours($ticket->category->default_sla_hours);
            }
        });
    }
    public function getAssignedToAttribute(): ?User
    {
        $user = $this->assignedToUser;

        return $user instanceof User ? $user : null;
    }

    /**
     * Accessor for activity_log (stub for Larastan)
     *
     * @return mixed
     */
    public function getActivityLogAttribute()
    {
        // Return null or actual activity log if implemented
        return null;
    }

}
