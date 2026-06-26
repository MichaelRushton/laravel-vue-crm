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

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        UserRevision::where('created_at', '<', $before)->delete();

    }
}
