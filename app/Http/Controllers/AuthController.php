<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreAuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(StoreAuthRequest $request): RedirectResponse
    {

        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Incorrect email address or password.',
            ]);
        }

        session()->regenerate();

        return to_route('dashboard.show');

    }

    public function destroy(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        return to_route('login');

    }
}
