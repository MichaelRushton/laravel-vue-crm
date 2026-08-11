<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UserRevision;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('users:delete-revisions {--before=}')]
#[Description('Delete user revisions')]
class DeleteUserRevisions extends Command
{
    public function handle(): int
    {

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        new UserRevision()->prunable(Carbon::parse($before))->delete();

        return self::SUCCESS;

    }
}
