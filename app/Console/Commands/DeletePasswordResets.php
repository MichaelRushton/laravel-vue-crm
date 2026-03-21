<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\PasswordReset;
use Illuminate\Console\Command;

class DeletePasswordResets extends Command
{
    protected $signature = 'password-resets:delete {--before=}';

    protected $description = 'Delete password resets';

    public function handle()
    {

        $days = config('data-cleanse.password_resets', 365);

        PasswordReset::where('created_at', '<', $this->option('before') ?: today()->subDays($days))->forceDelete();

    }
}
