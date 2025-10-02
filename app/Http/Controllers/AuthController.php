<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreAuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use SensitiveParameter;

class AuthController extends Controller
{
    public function store(#[SensitiveParameter] StoreAuthRequest $request): RedirectResponse
    {

        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'You have entered an incorrect email address or password.',
            ]);
        }

        session()->regenerate();

        return to_route('dashboard.show');

    }

    public function destroy(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return to_route('login');

    }
}
