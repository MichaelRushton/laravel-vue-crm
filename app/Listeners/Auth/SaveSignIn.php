<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\SignIn;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Validated;

class SaveSignIn
{
    public function __construct() {}

    public function handle(Validated|Failed $event): void
    {

        $sign_in = new SignIn;

        $sign_in->email = $event->user?->email ?? $event->credentials['email'];

        $sign_in->user()->associate($event->user);

        $sign_in->correct_password = match (true) {
            $event instanceof Validated => true,
            (bool) $event->user => false,
            default => null,
        };

        $sign_in->save();

    }
}
