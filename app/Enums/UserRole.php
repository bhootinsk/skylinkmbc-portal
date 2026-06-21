<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case Client = 'client';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Site Manager',
            self::Admin => 'Administrator',
            self::Client => 'Client',
        };
    }

    public function isStaff(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin], true);
    }
}
