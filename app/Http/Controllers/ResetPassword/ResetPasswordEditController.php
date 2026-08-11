<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Actions\PasswordReset\AuthPasswordReset;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class ResetPasswordEditController extends Controller
{
    public function __invoke(Request $request, PasswordReset $password_reset, AuthPasswordReset $auth): InertiaResponse
    {

        $auth->handle($password_reset, $request->token);

        return inertia('PasswordReset/Edit', [
            'uuid' => $password_reset->id,
            'token' => $request->token,
            'password_min' => config('auth.password_validation.min'),
        ]);

    }
}
