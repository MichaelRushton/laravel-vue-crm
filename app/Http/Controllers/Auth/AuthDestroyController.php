<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthDestroyController extends Controller
{
    public function __invoke(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        return to_route('login');

    }
}
