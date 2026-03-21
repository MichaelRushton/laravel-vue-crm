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

        $days = config('data-cleanse.sign_ins', 365);

        SignIn::where('created_at', '<', $this->option('before') ?: today()->subDays($days))->delete();

    }
}
