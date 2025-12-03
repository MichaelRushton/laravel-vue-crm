<?php

declare(strict_types=1);

namespace App\Listeners\Customer;

use App\Events\Customer\CustomerSaved;
use App\Models\CustomerRevision;
use Illuminate\Support\Facades\Auth;

class SaveCustomerRevision
{
    public function __construct() {}

    public function handle(CustomerSaved $event): void
    {

        $attributes = $event->customer->refresh()->getAttributes();

        unset($attributes['id'], $attributes['created_at'], $attributes['updated_at'], $attributes['deleted_at']);

        $revision = new CustomerRevision($attributes);

        $revision->trashed = $event->customer->trashed();

        $revision->createdBy()->associate(Auth::user());

        $revision->impersonatedBy()->associate(session('impersonated_by'));

        $event->customer->revisions()->save($revision);

    }
}
