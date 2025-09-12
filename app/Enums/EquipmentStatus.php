<?php

namespace App\Enums;

enum EquipmentStatus: string
{
    case AVAILABLE = 'available';
    case ON_LOAN = 'on_loan';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Available',
            self::ON_LOAN => 'On Loan',
            self::MAINTENANCE => 'Under Maintenance',
            self::RETIRED => 'Retired',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::AVAILABLE => 'success',
            self::ON_LOAN => 'warning',
            self::MAINTENANCE => 'primary',
            self::RETIRED => 'gray',
        };
    }
}
