<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\PasswordReset\PasswordResetRequested;
use App\Http\Requests\PasswordReset\StorePasswordResetRequest;
use App\Http\Requests\PasswordReset\UpdatePasswordResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Timebox;
use Inertia\Response as InertiaResponse;

class ResetPasswordController extends Controller
{
    public function index(): InertiaResponse
    {
        return inertia('PasswordReset/Index');
    }

    public function store(StorePasswordResetRequest $request): RedirectResponse
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

    public function show(PasswordReset $reset_password, Request $request): InertiaResponse
    {

        $this->auth($reset_password, $request);

        return inertia('PasswordReset/Show', [
            'uuid' => $reset_password->id,
            'token' => $request->token,
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }

    public function update(PasswordReset $reset_password, UpdatePasswordResetRequest $request)
    {

        $this->auth($reset_password, $request);

        $reset_password->user->update([
            'password' => $request->validated('password'),
        ]);

        $reset_password->delete();

        Auth::login($reset_password->user);

        event(new Validated(config('auth.defaults.guard'), $reset_password->user));

        session()->regenerate();

        return to_route('dashboard.show');

    }

    protected function auth(PasswordReset $password_reset, Request $request): void
    {

        if (! Hash::check($request->token, $password_reset->token)) {
            abort(403);
        }

        if ($password_reset->expires_at < now()) {
            abort(419);
        }

    }
}
