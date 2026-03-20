<?php

declare(strict_types=1);

namespace App\Listeners\User;

use App\Events\User\UserSaved;
use App\Models\UserRevision;
use Illuminate\Support\Facades\Auth;

class SaveUserRevision
{
    public function __construct() {}

    public function handle(UserSaved $event): void
    {

        $attributes = $event->user->refresh()->getAttributes();

        unset($attributes['id'], $attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

        $revision = new UserRevision($attributes);

        $revision->trashed = $event->user->trashed();

        $revision->createdBy()->associate(Auth::user());

        $revision->impersonatedBy()->associate(session('impersonated_by'));

        $event->user->revisions()->save($revision);

    }
}
