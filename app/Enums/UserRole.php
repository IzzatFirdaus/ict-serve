<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case SUPERVISOR = 'supervisor';
    case ICT_ADMIN = 'ict_admin';
    case HELPDESK_STAFF = 'helpdesk_staff';
    case SUPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::SUPERVISOR => 'Supervisor',
            self::ICT_ADMIN => 'ICT Admin',
            self::HELPDESK_STAFF => 'Helpdesk Staff',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }

    public function canAccessPanel(): bool
    {
        return match ($this) {
            self::SUPER_ADMIN, self::ICT_ADMIN, self::HELPDESK_STAFF => true,
            default => false,
        };
    }
}
