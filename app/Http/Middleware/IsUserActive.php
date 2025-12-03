<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUserActive
{
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user() && $request->user()->status !== UserStatus::Active) {

            Auth::logout();

            session()->invalidate();

            return to_route('login')->withFlash([
                'error' => 'Your account has been deactivated.',
            ]);

        }

        return $next($request);

    }
}
