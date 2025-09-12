<?php

namespace App\Enums;

enum EquipmentCondition: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case FAIR = 'fair';
    case POOR = 'poor';
    case DAMAGED = 'damaged';

    public function label(): string
    {
        return match($this) {
            self::EXCELLENT => 'Excellent',
            self::GOOD => 'Good',
            self::FAIR => 'Fair',
            self::POOR => 'Poor',
            self::DAMAGED => 'Damaged',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EXCELLENT => 'success',
            self::GOOD => 'primary',
            self::FAIR => 'warning',
            self::POOR => 'warning',
            self::DAMAGED => 'danger',
        };
    }
}
