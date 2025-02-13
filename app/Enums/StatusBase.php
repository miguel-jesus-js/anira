<?php

namespace App\Enums;

enum StatusBase: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function label(): string
    {
        return match ($this) {
            self::INACTIVE => 'INACTIVO',
            self::ACTIVE => 'ACTIVO',
        };
    }
}
