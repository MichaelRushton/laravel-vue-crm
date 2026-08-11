<?php

declare(strict_types=1);

namespace App\Actions\PasswordReset;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Str;

class SendPasswordResetNotification
{
    public function handle(User $user): void
    {

        $password_reset = new PasswordReset([
            'token' => $token = Str::random(),
        ]);

        $password_reset->user()->associate($user);

        $password_reset->save();

        $user->notify(new PasswordResetNotification($password_reset, $token));

    }
}
