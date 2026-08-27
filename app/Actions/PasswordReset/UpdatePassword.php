<?php

declare(strict_types=1);

namespace App\Actions\PasswordReset;

use App\Http\Requests\PasswordReset\PasswordResetUpdateRequest;
use App\Models\PasswordReset;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;

class UpdatePassword
{
    public function __construct(
        public readonly AuthPasswordReset $auth
    ) {}

    public function handle(
        PasswordReset $password_reset,
        PasswordResetUpdateRequest $request
    ): void {

        $this->auth->handle($password_reset, $request->token);

        $password_reset->user->update([
            'password' => $request->validated('password'),
        ]);

        $password_reset->delete();

        Auth::login($password_reset->user);

        event(new Validated(config('auth.defaults.guard'), $password_reset->user));

        session()->regenerate();

    }
}
