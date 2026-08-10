<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword\Traits;

use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait CanAuthPasswordReset
{
    protected function auth(Request $request, PasswordReset $password_reset): void
    {

        if (! Hash::check($request->token, $password_reset->token)) {
            abort(403);
        }

        if ($password_reset->expires_at < now()) {
            abort(419);
        }

    }
}
