<?php

namespace App\Console\Commands;

use App\Models\CustomerRevision;
use Illuminate\Console\Command;

class DeleteCustomerRevisions extends Command
{
    protected $signature = 'customers:delete-revisions {--before=}';

    protected $description = 'Delete customer revisions';

    public function handle()
    {
        CustomerRevision::whereDate('created_at', '<', $this->option('before') ?: today()->subDays(30))->delete();
    }
}
