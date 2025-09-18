<?php

namespace App\Enums;

enum TicketPriority: string
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
            self::LOW => 'success',
            self::MEDIUM => 'primary',
            self::HIGH => 'warning',
            self::CRITICAL => 'danger',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::LOW => 'Minor issues that can be addressed in regular business hours',
            self::MEDIUM => 'Standard issues requiring normal attention',
            self::HIGH => 'Important issues that need prompt attention',
            self::CRITICAL => 'Urgent issues requiring immediate attention',
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
