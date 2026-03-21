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

        $days = config('data-cleanse.user_impersonations', 365);

        UserImpersonation::where('created_at', '<', $this->option('before') ?: today()->subDays($days))->delete();

    }
}
