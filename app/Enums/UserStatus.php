<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\Dropdown;

enum UserStatus: string
{
    use Dropdown;

    case Active = 'active';
    case Inactive = 'inactive';

    public function name(): string
    {
        return ucfirst($this->value);
    }
}
