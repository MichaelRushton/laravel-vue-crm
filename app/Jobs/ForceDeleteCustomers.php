<?php

namespace App\Jobs;

use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ForceDeleteCustomers implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        Customer::whereDate('deleted_at', '<=', today()->subDays(8))->forceDelete();
    }
}
