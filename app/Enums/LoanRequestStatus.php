<?php

namespace App\Enums;

enum LoanRequestStatus: string
{
    case PENDING_BPM_REVIEW = 'pending_bpm_review';
    case PENDING_SUPERVISOR_APPROVAL = 'pending_supervisor_approval';
    case PENDING_ICT_APPROVAL = 'pending_ict_approval';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COLLECTED = 'collected';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING_BPM_REVIEW => 'Pending BPM Review',
            self::PENDING_SUPERVISOR_APPROVAL => 'Pending Supervisor Approval',
            self::PENDING_ICT_APPROVAL => 'Pending ICT Approval',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::COLLECTED => 'Collected',
            self::RETURNED => 'Returned',
            self::OVERDUE => 'Overdue',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING_BPM_REVIEW, self::PENDING_SUPERVISOR_APPROVAL, self::PENDING_ICT_APPROVAL => 'warning',
            self::APPROVED => 'success',
            self::REJECTED, self::CANCELLED => 'danger',
            self::COLLECTED => 'primary',
            self::RETURNED => 'success',
            self::OVERDUE => 'danger',
        };
    }

    public function canBeEdited(): bool
    {
        return in_array($this, [
            self::PENDING_BPM_REVIEW,
            self::PENDING_SUPERVISOR_APPROVAL,
            self::PENDING_ICT_APPROVAL,
        ]);
    }

    public function canBeCancelled(): bool
    {
        return !in_array($this, [
            self::RETURNED,
            self::CANCELLED,
            self::REJECTED,
        ]);
    }
}
