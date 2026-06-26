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

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        UserImpersonation::where('created_at', '<', $before)->delete();

    }
}
