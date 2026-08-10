<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Events\PasswordReset\PasswordResetRequested;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\StorePasswordResetRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Timebox;

class ResetPasswordStoreController extends Controller
{
    public function __invoke(StorePasswordResetRequest $request): RedirectResponse
    {

        new Timebox()->call(function () use ($request) {

            $user = User::firstWhere('email', $request->validated('email'));

            if ($user && ! $user->passwordResets()->whereNotExpired()->count()) {
                event(new PasswordResetRequested($user));
            }

        }, 200000);

        return to_route('login')->withFlash([
            'success' => 'An email will be sent to you with a link to reset your password.',
        ]);

    }
}
