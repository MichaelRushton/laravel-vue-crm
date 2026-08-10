<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\SignIn;
use Illuminate\Console\Command;

class DeleteSignIns extends Command
{
    protected $signature = 'sign-ins:delete {--before=}';

    protected $description = 'Delete sign ins';

    public function handle()
    {

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        new SignIn()->prunable($before)->delete();

    }
}
