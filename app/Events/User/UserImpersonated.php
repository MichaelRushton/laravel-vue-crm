<?php

declare(strict_types=1);

namespace App\Events\User;

use App\Models\User;

class UserImpersonated
{
    public function __construct(
        public readonly User $user,
        public readonly User $impersonated_by
    ) {}
}
