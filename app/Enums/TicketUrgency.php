<?php

namespace App\Enums;

enum TicketUrgency: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'gray',
            self::MEDIUM => 'primary',
            self::HIGH => 'warning',
            self::CRITICAL => 'danger',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::LOW => 'Can wait for regular processing time',
            self::MEDIUM => 'Standard processing timeframe expected',
            self::HIGH => 'Needs faster than normal processing',
            self::CRITICAL => 'Requires immediate processing',
        };
    }

    public function sortOrder(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
            self::CRITICAL => 4,
        };
    }
}
