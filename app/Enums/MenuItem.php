<?php

declare(strict_types=1);

namespace App\Enums;

enum MenuItem
{
    case Dashboard;
    case Customers;
    case Users;

    public function href(): string
    {

        return trim(match ($this) {
            self::Dashboard => '',
            default => strtolower(preg_replace('/[A-Z]/', '-$0', lcfirst($this->name)))
        }, '/');

    }

    public function label(): string
    {

        return trim(match ($this) {
            default => ucfirst(preg_replace('/[A-Z]/', ' $0', lcfirst($this->name)))
        });

    }
}
