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
 * @property \Illuminate\Support\Carbon $requested_from
 * @property \Illuminate\Support\Carbon $requested_to
 * @property \Illuminate\Support\Carbon|null $actual_from
 * @property \Illuminate\Support\Carbon|null $actual_to
 * @property string|null $notes
 * @property string|null $rejection_reason
 * @property int|null $supervisor_id
 * @property \Illuminate\Support\Carbon|null $supervisor_approved_at
 * @property string|null $supervisor_notes
 * @property int|null $ict_admin_id
 * @property \Illuminate\Support\Carbon|null $ict_approved_at
 * @property string|null $ict_notes
 * @property int|null $issued_by
 * @property \Illuminate\Support\Carbon|null $issued_at
 * @property string|null $pickup_signature_path
 * @property int|null $received_by
 * @property \Illuminate\Support\Carbon|null $returned_at
 * @property string|null $return_signature_path
 * @property string|null $return_condition_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LoanStatus $status
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $supervisor
 * @property-read \App\Models\User|null $ictAdmin
 * @property-read \App\Models\User|null $issuedBy
 * @property-read \App\Models\User|null $receivedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EquipmentItem> $equipmentItems
 * @property-read \App\Models\EquipmentItem|null $equipmentItem
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LoanItem> $loanItems
 * @property string $status
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
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

    /**
     * Get the user who made this loan request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the current status of this loan request
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LoanStatus::class, 'status_id');
    }

    /**
     * Get the supervisor who approved this request
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the ICT admin who approved this request
     */
    public function ictAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ict_admin_id');
    }

    /**
     * Get the user who issued the equipment
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Get the user who received the returned equipment
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Get equipment items for this loan request
     */
    public function equipmentItems(): BelongsToMany
    {
        return $this->belongsToMany(EquipmentItem::class, 'loan_items', 'loan_request_id', 'equipment_item_id')
            ->withPivot(['quantity', 'condition_out', 'condition_in', 'notes_out', 'notes_in', 'damage_reported'])
            ->withTimestamps();
    }

    /**
     * Accessor for single equipment item (for legacy code)
     *
     * @return \App\Models\EquipmentItem|null
     */
    public function getEquipmentItemAttribute(): ?EquipmentItem
    {
        /** @var \App\Models\EquipmentItem|null $item */
        $item = $this->equipmentItems()->first();

        return $item;
    }

    /**
     * Get loan items for this request
     */
    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Check if request is pending approval
     */
    public function isPending(): bool
    {
        return $this->status->code === 'pending';
    }

    /**
     * Check if request is approved by supervisor
     */
    public function isSupervisorApproved(): bool
    {
        return $this->status->code === 'supervisor_approved';
    }

    /**
     * Check if request is approved by ICT
     */
    public function isIctApproved(): bool
    {
        return $this->status->code === 'ict_approved';
    }

    /**
     * Check if loan is currently active
     */
    public function isActive(): bool
    {
        return $this->status->code === 'active';
    }

    /**
     * Check if loan is returned
     */
    public function isReturned(): bool
    {
        return $this->status->code === 'returned';
    }

    /**
     * Check if loan is overdue
     */
    public function isOverdue(): bool
    {
        if (! $this->isActive()) {
            return false;
        }

        return now()->isAfter($this->requested_to);
    }

    protected function casts(): array
    {
        return [
            'requested_from' => 'date',
            'requested_to' => 'date',
            'actual_from' => 'date',
            'actual_to' => 'date',
            'supervisor_approved_at' => 'datetime',
            'ict_approved_at' => 'datetime',
            'issued_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
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
        });
    }

    /**
     * Generate request number in format: LR-YYYY-MMDD-XXX
     */
    protected static function generateRequestNumber(): string
    {
        $date = now();
        $prefix = 'LR-'.$date->format('Y-md');

        $lastRequest = static::where('request_number', 'like', $prefix.'%')
            ->orderBy('request_number', 'desc')
            ->first();

        if ($lastRequest) {
            $lastSequence = intval(substr($lastRequest->request_number, -3));
            $sequence = str_pad(strval($lastSequence + 1), 3, '0', STR_PAD_LEFT);
        } else {
            $sequence = '001';
        }

        return $prefix.'-'.$sequence;
    }
}
