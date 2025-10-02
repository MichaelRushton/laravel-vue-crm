<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPassword\StoreResetPasswordRequest;
use App\Http\Requests\ResetPassword\UpdateResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Inertia\Response as InertiaResponse;
use SensitiveParameter;

class ResetPasswordController extends Controller
{
    public function store(StoreResetPasswordRequest $request): RedirectResponse
    {

        $email = $request->only('email');

        dispatch(fn () => Password::sendResetLink($email));

        return to_route('login')->withFlash([
            'success' => 'An email will be sent to you with a link to reset your password.',
        ]);

    }

    public function edit(string $token, Request $request): InertiaResponse
    {

        if (! $request->email) {
            abort(404);
        }

        return inertia('ResetPassword/Edit', [
            'token' => $token,
            'email' => $request->email,
        ]);

    }

    public function update(#[SensitiveParameter] UpdateResetPasswordRequest $request): RedirectResponse
    {

        $status = Password::reset(
            $request->validated(),
            function (User $user, #[SensitiveParameter] string $password) {

                $user->update(['password' => $password]);

                Auth::login($user);

                event(new Validated(Auth::guard(), $user));

            }
        );

        if ($status !== Password::PasswordReset) {
            return back()->withErrors(['password' => [__($status)]]);
        }

        session()->regenerate();

        return to_route('dashboard.show');

    }
}
