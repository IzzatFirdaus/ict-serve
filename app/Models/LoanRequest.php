<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $request_number
 * @property int $user_id
 * @property int $status_id
 * @property string $purpose
 * @property \Carbon\Carbon $requested_from
 * @property \Carbon\Carbon $requested_to
 * @property \Carbon\Carbon|null $actual_from
 * @property \Carbon\Carbon|null $actual_to
 * @property string|null $notes
 * @property string|null $rejection_reason
 * @property string|null $approval_token
 * @property int|null $supervisor_id
 * @property \Carbon\Carbon|null $supervisor_approved_at
 * @property string|null $supervisor_notes
 * @property int|null $ict_admin_id
 * @property \Carbon\Carbon|null $ict_approved_at
 * @property string|null $ict_notes
 * @property int|null $issued_by
 * @property \Carbon\Carbon|null $issued_at
 * @property string|null $pickup_signature_path
 * @property int|null $received_by
 * @property \Carbon\Carbon|null $returned_at
 * @property string|null $return_signature_path
 * @property string|null $return_condition_notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read User $user
 * @property-read LoanStatus $status
 * @property-read User|null $supervisor
 * @property-read User|null $ictAdmin
 * @property-read User|null $issuedBy
 * @property-read User|null $receivedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LoanItem> $loanItems
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EquipmentItem> $equipmentItems
 * @property-read EquipmentItem|null $equipmentItem
 */
class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'user_id',
        'status_id',
        'purpose',
        'requested_from',
        'requested_to',
        'actual_from',
        'actual_to',
        'notes',
        'rejection_reason',
        'approval_token',
        'supervisor_id',
        'supervisor_approved_at',
        'supervisor_notes',
        'ict_admin_id',
        'ict_approved_at',
        'ict_notes',
        'issued_by',
        'issued_at',
        'pickup_signature_path',
        'received_by',
        'returned_at',
        'return_signature_path',
        'return_condition_notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_from' => 'date',
            'requested_to' => 'date',
            'actual_from' => 'date',
            'actual_to' => 'date',
            'equipment_requests' => 'array',
            'supervisor_approved_at' => 'datetime',
            'ict_approved_at' => 'datetime',
            'issued_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    /**
     * Legacy attribute accessor: when code references $loanRequest->status as string,
     * return the related status code; if object expected, relation method should be used.
     */
    public function getStatusAttribute($value): mixed
    {
        // If Eloquent provided a raw column named 'status', keep it;
        // otherwise, fall back to related model's code for string contexts.
        if ($value !== null) {
            return $value;
        }

        return $this->getRelationValue('loanStatus')?->code;
    }

    /**
     * Get the user who made the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loan status.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LoanStatus::class, 'status_id');
    }

    /**
     * Backwards-compatible alias used in Blade views.
     */
    public function loanStatus(): BelongsTo
    {
        return $this->belongsTo(LoanStatus::class, 'status_id');
    }

    /**
     * Get the supervisor who needs to approve.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the ICT admin who approved.
     */
    public function ictAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ict_admin_id');
    }

    /**
     * Get the staff who issued the equipment.
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Get the person who received the equipment.
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Get the loan items for this request.
     */
    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class, 'loan_request_id');
    }

    /**
     * Get the equipment items for this request (through loan items).
     */
    public function equipmentItems(): BelongsToMany
    {
        return $this->belongsToMany(
            EquipmentItem::class,
            'loan_items',
            'loan_request_id',
            'equipment_item_id'
        )->withPivot('quantity', 'condition_out', 'condition_in', 'notes_out', 'notes_in', 'damage_reported');
    }

    /**
     * Get the approvals for this request.
     * Note: LoanApproval model needs to be created
     */
    public function approvals(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\App\Models\Approval::class, 'approvable');
    }

    /**
     * Accessor for single equipment item (for legacy code)
     */
    public function getEquipmentItemAttribute(): ?EquipmentItem
    {
        /** @var \App\Models\LoanItem|null $loanItem */
        $loanItem = $this->loanItems()->first();

        return $loanItem?->equipmentItem;
    }

    /**
     * Generate unique request number
     */
    public static function generateRequestNumber(): string
    {
        $prefix = 'LR'.date('Y');
        $lastRequest = static::where('request_number', 'like', $prefix.'%')
            ->orderBy('request_number', 'desc')
            ->first();

        if ($lastRequest) {
            $lastNumber = (int) substr($lastRequest->request_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix.str_pad((string) $newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if request can be edited.
     */
    public function canBeEdited(): bool
    {
        return (bool) $this->loanStatus?->canBeEdited();
    }

    /**
     * Check if request can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return (bool) $this->loanStatus?->canBeCancelled();
    }

    /**
     * Check if request is overdue.
     */
    public function isOverdue(): bool
    {
        $code = $this->loanStatus?->code;

        return in_array($code, ['active', 'in_use', 'approved'], true)
            && $this->requested_to
            && $this->requested_to < now();
    }

    /**
     * Get loan duration in days.
     */
    public function getLoanDurationAttribute(): ?int
    {
        if (! $this->requested_from || ! $this->requested_to) {
            return null;
        }

        return (int) ($this->requested_from->diffInDays($this->requested_to) + 1);
    }

    /**
     * Generate unique request number
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($loanRequest): void {
            if (empty($loanRequest->request_number)) {
                $loanRequest->request_number = static::generateRequestNumber();
            }

            // If a plain string status has been set (e.g., by tests), sync status_id accordingly
            if (! empty($loanRequest->status) && empty($loanRequest->status_id)) {
                $statusModel = \App\Models\LoanStatus::where('code', $loanRequest->status)->first();
                if ($statusModel) {
                    $loanRequest->status_id = $statusModel->id;
                }
            }
        });

        static::saving(function ($loanRequest): void {
            // Keep status_id in sync when a string status is provided
            if (! empty($loanRequest->status)) {
                $statusModel = \App\Models\LoanStatus::where('code', $loanRequest->status)->first();
                if ($statusModel) {
                    $loanRequest->status_id = $statusModel->id;
                }
            }
        });
    }
}
