<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreAuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthStoreController extends Controller
{
    public function __invoke(StoreAuthRequest $request): RedirectResponse
    {

        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Incorrect email address or password.',
            ]);
        }

        session()->regenerate();

        return to_route('dashboard.show');

    }
}
