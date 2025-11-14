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
        PasswordReset::where('created_at', '<', $this->option('before') ?: today()->subDays(30))->forceDelete();
    }
}
