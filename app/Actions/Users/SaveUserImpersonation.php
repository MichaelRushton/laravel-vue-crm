<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use App\Models\UserImpersonation;

class SaveUserImpersonation
{
    public function handle(
        User $user,
        User $impersonated_by
    ): UserImpersonation {

        $impersonation = new UserImpersonation;

        $impersonation->user()->associate($user);

        $impersonation->createdBy()->associate($impersonated_by);

        $impersonation->save();

        return $impersonation;

    }
}
