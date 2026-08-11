<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

        RateLimiter::for('auth.store', function (Request $request) {
            return Limit::perSecond(1, 5)->by($request->email);
        });

        Password::defaults(
            fn () => Password::min(config('auth.password_validation.min'))
        );

        JsonResource::withoutWrapping();

    }
}
