<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LoanRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
=======
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
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'request_number',
        'user_id',
        'applicant_name',
        'applicant_position',
        'applicant_department',
        'applicant_phone',
        'status_id',
        'purpose',
        'location',
        'requested_from',
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
        'status',
        'submitted_at',
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

<<<<<<< HEAD
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

=======
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
    /**
     * Get the user who made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supervisor who needs to approve.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the ICT admin who approved.
     */
    public function ictAdmin()
    {
        return $this->belongsTo(User::class, 'ict_admin_id');
    }

    /**
     * Get the staff who issued the equipment.
     */
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Get the person who received the equipment.
     */
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Get the loan status.
     */
    public function loanStatus()
    {
        return $this->belongsTo(LoanStatus::class, 'status_id');
    }

    /**
<<<<<<< HEAD
     * Generate unique request number.
=======
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
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
     */
    public static function generateRequestNumber(): string
    {
<<<<<<< HEAD
        $prefix = 'LR' . date('Y');
        $lastRequest = static::where('request_number', 'like', $prefix . '%')
            ->orderBy('request_number', 'desc')
            ->first();

        if ($lastRequest) {
            $lastNumber = (int) substr($lastRequest->request_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if request can be edited.
=======
        return $this->hasMany(LoanItem::class);
    }

    /**
     * Check if request is pending approval
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
     */
    public function canBeEdited(): bool
    {
        return $this->status->canBeEdited();
    }

    /**
     * Check if request can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return $this->status->canBeCancelled();
    }

    /**
     * Check if request is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === LoanRequestStatus::COLLECTED
            && $this->expected_return_date
            && $this->expected_return_date < now();
    }

    /**
     * Get loan duration in days.
     */
    public function getLoanDurationAttribute(): ?int
    {
        if (!$this->requested_from || !$this->requested_to) {
            return null;
        }

        return $this->requested_from->diffInDays($this->requested_to) + 1;
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
