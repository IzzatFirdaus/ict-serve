<?php

namespace App\Models;

use App\Enums\LoanRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Generate unique request number.
     */
    public static function generateRequestNumber(): string
    {
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
}
