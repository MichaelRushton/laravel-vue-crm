<?php

declare(strict_types=1);

namespace App\Events\PasswordReset;

use App\Models\User;

class PasswordResetRequested
{
    public function __construct(public readonly User $user) {}
}
