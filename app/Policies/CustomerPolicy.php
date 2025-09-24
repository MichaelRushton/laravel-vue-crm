<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Customer $customer): bool
    {
        return ! $customer->trashed();
    }

    public function delete(User $user, Customer $customer): bool
    {
        return ! $customer->trashed();
    }

    public function restore(User $user, Customer $customer): bool
    {
        return $customer->trashed();
    }
}
