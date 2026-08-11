<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Actions\PasswordReset\AuthPasswordReset;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\PasswordResetUpdateRequest;
use App\Models\PasswordReset;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class ResetPasswordUpdateController extends Controller
{
    public function __invoke(PasswordResetUpdateRequest $request, PasswordReset $password_reset, AuthPasswordReset $auth)
    {

        $auth->handle($password_reset, $request->token);

        $password_reset->user->update([
            'password' => $request->validated('password'),
        ]);

        $password_reset->delete();

        Auth::login($password_reset->user);

        event(new Validated(config('auth.defaults.guard'), $password_reset->user));

        session()->regenerate();

        return to_route('dashboard.show');

    }
}
