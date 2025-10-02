<?php

namespace App\Listeners\User;

use App\Enums\UserRole;
use App\Events\User\UserImpersonated;
use App\Models\User;

class CreateUserImpersonatedNotification
{
    public function __construct() {}

    public function handle(UserImpersonated $event): void
    {

        foreach (
            User::where('role', UserRole::Administrator->value)
                ->whereNot('id', $event->impersonated_by->id)
                ->get() as $admin
        ) {
            $admin->notifications()->create(['message' => "{$event->impersonated_by->name} impersonated {$event->user->name}"]);
        }

    }
}
