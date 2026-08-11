<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

readonly class ImpersonateUser
{
    public function __construct(
        public UnimpersonateUser $unimpersonate,
        public SaveUserImpersonation $save_impersonation
    ) {}

    public function handle(
        User $user,
        User $admin
    ): bool {

        if (! $impersonated_by = session('impersonated_by')) {
            session(['impersonated_by' => $impersonated_by = $admin->id]);
        } elseif ($user->id === $impersonated_by) {
            return $this->unimpersonate->handle();
        }

        $this->save_impersonation->handle($user, User::findOrFail($impersonated_by));

        Auth::login($user);

        session()->regenerate();

        return true;

    }
}
