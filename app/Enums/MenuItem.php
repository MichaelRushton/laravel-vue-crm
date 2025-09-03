<?php

namespace App\Enums;

enum MenuItem
{
    case Dashboard;
    case Users;
    case Customers;

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
            default => ucwords(preg_replace('/[A-Z]/', ' $0', lcfirst($this->name)))
        });

    }
}
