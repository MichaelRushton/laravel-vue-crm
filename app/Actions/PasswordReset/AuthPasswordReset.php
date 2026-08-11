<?php

declare(strict_types=1);

namespace App\Actions\PasswordReset;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;

class AuthPasswordReset
{
    public function handle(PasswordReset $password_reset, string $token): void
    {

        if (! Hash::check($token, $password_reset->token)) {
            abort(403);
        }

        if ($password_reset->expires_at < now()) {
            abort(419);
        }

    }
}
