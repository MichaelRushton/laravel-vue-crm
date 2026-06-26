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

        if (! $before = $this->option('before')) {

            $this->error('You must provide a --before date');

            return self::INVALID;

        }

        PasswordReset::where('created_at', '<', $before)->forceDelete();

    }
}
