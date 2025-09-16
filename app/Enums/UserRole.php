<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case SUPERVISOR = 'supervisor';
    case ICT_ADMIN = 'ict_admin';
    case HELPDESK_STAFF = 'helpdesk_staff';
    case SUPER_ADMIN = 'super_admin';

    // Legacy/test compatibility values
    case STAFF = 'staff';
    case ADMIN = 'admin';
    case SUPPORTING_OFFICER = 'supporting_officer';
    case BMP_STAFF = 'bmp_staff';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::SUPERVISOR => 'Supervisor',
            self::ICT_ADMIN => 'ICT Admin',
            self::HELPDESK_STAFF => 'Helpdesk Staff',
            self::SUPER_ADMIN => 'Super Admin',
            // Legacy/test compatibility
            self::STAFF => 'Staff',
            self::ADMIN => 'Admin',
            self::SUPPORTING_OFFICER => 'Supporting Officer',
            self::BMP_STAFF => 'BMP Staff',
        };
    }

    public function canAccessPanel(): bool
    {
        return match ($this) {
            self::SUPER_ADMIN, self::ICT_ADMIN, self::HELPDESK_STAFF => true,
            // Legacy/test compatibility - admin roles can access panel
            self::ADMIN, self::SUPPORTING_OFFICER, self::BMP_STAFF => true,
            default => false,
        };
    }
}
