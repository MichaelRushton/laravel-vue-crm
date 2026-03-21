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

        $days = config('data-cleanse.user_revisions', 365);

        UserRevision::where('created_at', '<', $this->option('before') ?: today()->subDays($days))->delete();

    }
}
