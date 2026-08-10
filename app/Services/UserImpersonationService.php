<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\User\UserImpersonated;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserImpersonationService
{
    public function impersonate(User $user, User $admin): bool
    {

        if (! $impersonated_by = session('impersonated_by')) {
            session(['impersonated_by' => $impersonated_by = $admin->id]);
        } elseif ($user->id === $impersonated_by) {
            return $this->unimpersonate();
        }

        event(new UserImpersonated($user, User::findOrFail($impersonated_by)));

        Auth::login($user);

        session()->regenerate();

        return true;

    }

    public function unimpersonate(): bool
    {

        if (! $impersonated_by = session('impersonated_by')) {
            return false;
        }

        Auth::loginUsingId($impersonated_by);

        session()->forget('impersonated_by');

        session()->regenerate();

        return true;

    }
}
