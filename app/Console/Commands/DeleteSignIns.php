<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\SignIn;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('sign-ins:delete {--before=}')]
#[Description('Delete sign ins')]
class DeleteSignIns extends Command
{
    public function handle(): int
    {

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        new SignIn()->prunable(Carbon::parse($before))->delete();

        return self::SUCCESS;

    }
}
