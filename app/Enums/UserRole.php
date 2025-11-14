<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\Dropdown;

enum UserRole: string
{
    use Dropdown;

    case Administrator = 'administrator';
    case User = 'user';

    public function name(): string
    {
        return ucfirst($this->value);
    }
}
