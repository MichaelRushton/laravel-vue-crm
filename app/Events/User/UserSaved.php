<?php

namespace App\Events\User;

use App\Models\User;

class UserSaved
{
    public function __construct(public readonly User $user) {}
}
