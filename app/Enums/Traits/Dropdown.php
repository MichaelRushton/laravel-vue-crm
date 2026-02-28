<?php

declare(strict_types=1);

namespace App\Enums\Traits;

trait Dropdown
{
    public static function dropdown(): array
    {
        return array_map(fn ($case) => [
            'value' => $case->value,
            'label' => $case->name(),
        ], self::cases());
    }
}
