<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UserImpersonation;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('users:delete-impersonations {--before=}')]
#[Description('Delete user impersonations')]
class DeleteUserImpersonations extends Command
{
    public function handle(): int
    {

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        new UserImpersonation()->prunable(Carbon::parse($before))->delete();

        return self::SUCCESS;

    }
}
