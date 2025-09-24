<?php

namespace App\Policies;

use App\Models\User;

class SignInPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }
}
