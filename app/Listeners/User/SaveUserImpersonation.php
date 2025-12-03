<?php

declare(strict_types=1);

namespace App\Listeners\User;

use App\Events\User\UserImpersonated;
use App\Models\UserImpersonation;

class SaveUserImpersonation
{
    public function __construct() {}

    public function handle(UserImpersonated $event): void
    {

        $impersonation = new UserImpersonation;

        $impersonation->user()->associate($event->user);

        $impersonation->createdBy()->associate($event->impersonated_by);

        $impersonation->save();

    }
}
