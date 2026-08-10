<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResetPassword\Traits\CanAuthPasswordReset;
use App\Http\Requests\PasswordReset\UpdatePasswordResetRequest;
use App\Models\PasswordReset;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class ResetPasswordUpdateController extends Controller
{
    use CanAuthPasswordReset;

    public function __invoke(UpdatePasswordResetRequest $request, PasswordReset $password_reset)
    {

        $this->auth($request, $password_reset);

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
