<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LoanRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property LoanRequestStatus $status
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'reference_number',
        'user_id',
        'applicant_name',
        'applicant_position',
        'applicant_department',
        'applicant_phone',
        'status',
        'purpose',
        'location',
        'requested_from',
        'requested_to',
        'loan_start_date',
        'expected_return_date',
        'responsible_officer_name',
        'responsible_officer_position',
        'responsible_officer_phone',
        'same_as_applicant',
        'equipment_requests',
        'endorsing_officer_name',
        'endorsing_officer_position',
        'endorsement_status',
        'endorsement_comments',
        'submitted_at',
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
     * Get the user who made the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
     * Get loan items for this request
     */
    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Scope a query to only include pending requests.
     * "Pending" is defined as any status in the approval workflow.
     */
    public function scopePending(Builder $query): void
    {
        $query->whereIn('status', [
            LoanRequestStatus::PENDING_BPM_REVIEW->value,
            LoanRequestStatus::PENDING_SUPERVISOR_APPROVAL->value,
            LoanRequestStatus::PENDING_ICT_APPROVAL->value,
        ]);
    }

    /**
     * Scope a query to only include requests for a specific user.
     */
    public function scopeForUser(Builder $query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    /**
     * Check if request is in an editable state.
     * Editable if in any "pending" state.
     */
    public function canBeEdited(): bool
    {
        return in_array($this->status, [
            LoanRequestStatus::PENDING_BPM_REVIEW->value,
            LoanRequestStatus::PENDING_SUPERVISOR_APPROVAL->value,
            LoanRequestStatus::PENDING_ICT_APPROVAL->value,
        ]);
    }

    /**
     * Check if request can be cancelled.
     * Not cancellable if already returned, cancelled, or rejected.
     */
    public function canBeCancelled(): bool
    {
        return !in_array($this->status, [
            LoanRequestStatus::RETURNED->value,
            LoanRequestStatus::CANCELLED->value,
            LoanRequestStatus::REJECTED->value,
        ]);
    }

    /**
     * Check if request is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === LoanRequestStatus::COLLECTED->value
            && $this->expected_return_date
            && $this->expected_return_date->isPast();
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
     * Attribute casting for Eloquent.
     */
    protected function casts(): array
    {
        return [
            'status' => LoanRequestStatus::class,
            'equipment_requests' => 'array',
            'same_as_applicant' => 'boolean',
            'requested_from' => 'datetime',
            'requested_to' => 'datetime',
            'loan_start_date' => 'datetime',
            'expected_return_date' => 'datetime',
            'actual_from' => 'datetime',
            'actual_to' => 'datetime',
            'submitted_at' => 'datetime',
            'supervisor_approved_at' => 'datetime',
            'ict_approved_at' => 'datetime',
            'issued_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    /**
     * Generate unique request numbers on creation.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($loanRequest): void {
            if (empty($loanRequest->request_number)) {
                $loanRequest->request_number = static::generateRequestNumber();
            }
            if (empty($loanRequest->reference_number)) {
                $loanRequest->reference_number = static::generateReferenceNumber();
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

    /**
     * Generate a unique reference number.
     * Format: YYYY/MM/TYPE/SEQ
     */
    public static function generateReferenceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $type = 'LOAN'; // Or derive from model context

        // Find the last sequence number for the current year and month
        $lastRequest = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastRequest ? ((int) substr($lastRequest->reference_number, -4)) + 1 : 1;

        return sprintf('%s/%s/%s/%04d', $year, $month, $type, $sequence);
    }
}
