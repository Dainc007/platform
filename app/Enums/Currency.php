<?php

namespace App\Enums;

enum Currency: int
{
    case PLN = 1;
    case EUR = 2;

    public function symbol(): string
    {
        return match($this) {
            self::PLN => 'zł',
            self::EUR => '€',
        };
    }

    public function label(): string
    {
        return match($this) {
            self::PLN => 'PLN',
            self::EUR => 'EUR',
        };
    }
}
