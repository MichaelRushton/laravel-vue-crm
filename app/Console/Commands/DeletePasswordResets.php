<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('password-resets:delete {--before=}')]
#[Description('Delete password resets')]
class DeletePasswordResets extends Command
{
    public function handle(): int
    {

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        new PasswordReset()->prunable(Carbon::parse($before))->forceDelete();

        return self::SUCCESS;

    }
}
