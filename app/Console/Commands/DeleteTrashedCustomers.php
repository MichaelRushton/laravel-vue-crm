<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;

class DeleteTrashedCustomers extends Command
{
    protected $signature = 'customers:delete-trashed {--before=}';

    protected $description = 'Delete trashed customers';

    public function handle()
    {

        if (! $before = $this->option('before')) {
            $confirm = $this->confirm('Are you sure you would like to delete all trashed customers?');
        }

        if (! $before && ! $confirm) {
            return;
        }

        Customer::onlyTrashed()
            ->when($before, fn ($query) => $query->whereDate('deleted_at', '<', $before))
            ->forceDelete();

    }
}
