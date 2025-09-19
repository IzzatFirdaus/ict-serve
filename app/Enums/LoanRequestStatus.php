<?php

namespace App\Enums;

enum LoanRequestStatus: string
{
    case PENDING_SUPERVISOR = 'pending_supervisor';
    case APPROVED_SUPERVISOR = 'approved_supervisor';
    case PENDING_ICT = 'pending_ict';
    case APPROVED_ICT = 'approved_ict';
    case READY_PICKUP = 'ready_pickup';
    case IN_USE = 'in_use';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING_SUPERVISOR => 'Pending Supervisor',
            self::APPROVED_SUPERVISOR => 'Approved by Supervisor',
            self::PENDING_ICT => 'Pending ICT',
            self::APPROVED_ICT => 'Approved by ICT',
            self::READY_PICKUP => 'Ready for Pickup',
            self::IN_USE => 'In Use',
            self::RETURNED => 'Returned',
            self::OVERDUE => 'Overdue',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING_SUPERVISOR, self::PENDING_ICT => 'warning',
            self::APPROVED_SUPERVISOR, self::APPROVED_ICT, self::READY_PICKUP, self::IN_USE => 'success',
            self::RETURNED => 'success',
            self::OVERDUE => 'danger',
            self::REJECTED, self::CANCELLED => 'danger',
        };
    }

    public function canBeEdited(): bool
    {
        return in_array($this, [
            self::PENDING_SUPERVISOR,
            self::PENDING_ICT,
        ]);
    }

    public function canBeCancelled(): bool
    {
        return ! in_array($this, [
            self::RETURNED,
            self::CANCELLED,
            self::REJECTED,
        ]);
    }
}
