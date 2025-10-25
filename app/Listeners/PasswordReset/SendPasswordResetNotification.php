<?php

declare(strict_types=1);

namespace App\Listeners\PasswordReset;

use App\Events\PasswordReset\PasswordResetRequested;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Str;

class SendPasswordResetNotification
{
    public function __construct() {}

    public function handle(PasswordResetRequested $event): void
    {

        $password_reset = new PasswordReset([
            'token' => $token = Str::random(),
        ]);

        $password_reset->user()->associate($event->user);

        $password_reset->save();

        $event->user->notify(new PasswordResetNotification($password_reset, $token));

    }
}
