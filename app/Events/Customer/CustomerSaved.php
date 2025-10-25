<?php

declare(strict_types=1);

namespace App\Events\Customer;

use App\Models\Customer;

class CustomerSaved
{
    public function __construct(public readonly Customer $customer) {}
}
