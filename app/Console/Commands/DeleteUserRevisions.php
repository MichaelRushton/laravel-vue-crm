<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UserRevision;
use Illuminate\Console\Command;

class DeleteUserRevisions extends Command
{
    protected $signature = 'users:delete-revisions {--before=}';

    protected $description = 'Delete user revisions';

    public function handle()
    {
        UserRevision::where('created_at', '<', $this->option('before') ?: today()->subDays(30))->delete();
    }
}
