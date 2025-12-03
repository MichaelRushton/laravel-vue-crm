<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UserImpersonation;
use Illuminate\Console\Command;

class DeleteUserImpersonations extends Command
{
    protected $signature = 'users:delete-impersonations {--before=}';

    protected $description = 'Delete user impersonations';

    public function handle()
    {
        UserImpersonation::where('created_at', '<', $this->option('before') ?: today()->subDays(30))->delete();
    }
}
