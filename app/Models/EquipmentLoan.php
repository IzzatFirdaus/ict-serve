<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_name',
        'division',
        'position_grade',
        'email',
        'phone_number',
        'equipment_requested',
        'loan_start_date',
        'loan_end_date',
        'purpose',
        'event_location',
        'responsible_officer_name',
        'responsible_officer_position',
        'responsible_officer_phone',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
        'rejection_reason',
        'collected_at',
        'returned_at',
        'return_condition_notes',
    ];

    protected $casts = [
        'equipment_requested' => 'array',
        'loan_start_date' => 'date',
        'loan_end_date' => 'date',
        'approved_at' => 'datetime',
        'collected_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    /**
     * Get the status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        switch ($this->status) {
            case 'submitted':
                return 'warning';
            case 'pending_approval':
                return 'primary';
            case 'approved':
                return 'success';
            case 'rejected':
                return 'danger';
            case 'collected':
                return 'primary';
            case 'returned':
                return 'success';
            default:
                return 'gray';
        }
    }

    /**
     * Get the loan duration in days.
     */
    public function getLoanDurationAttribute(): int
    {
        $days = Carbon::parse($this->loan_start_date)->diffInDays(Carbon::parse($this->loan_end_date)) + 1;
        return (int) $days;
    }

    /**
     * Check if the loan is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'collected' &&
               Carbon::now()->isAfter(Carbon::parse($this->loan_end_date));
    }

    /**
     * Check if the loan can be approved.
     */
    public function canBeApproved(): bool
    {
        return in_array($this->status, ['submitted', 'pending_approval']);
    }

    /**
     * Check if equipment can be collected.
     */
    public function canBeCollected(): bool
    {
        return $this->status === 'approved' &&
               (Carbon::now()->isSameDay(Carbon::parse($this->loan_start_date)) ||
               Carbon::now()->isAfter(Carbon::parse($this->loan_start_date)));
    }

    /**
     * Check if equipment can be returned.
     */
    public function canBeReturned(): bool
    {
        return $this->status === 'collected';
    }

    /**
     * Get the formatted equipment list.
     */
    public function getFormattedEquipmentAttribute(): string
    {
        if (! $this->equipment_requested) {
            return 'No equipment specified';
        }

        return collect($this->equipment_requested)
            ->map(fn ($item) => is_array($item) ?
                ($item['name'] ?? 'Unknown').' (Qty: '.($item['quantity'] ?? 1).')' :
                $item
            )
            ->join(', ');
    }
}
