<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\StoreAuthRequest;
use App\Http\Requests\Auth\UpdateAuthRequest;
use App\Http\Resources\Auth\EditAuthResource;
use App\Services\PasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

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

    public function edit(Request $request): Response
    {

        return inertia('Auth/Edit', [
            'user' => new EditAuthResource($request->user()),
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }

    public function update(UpdateAuthRequest $request): RedirectResponse
    {

        $request->user()->updateIfDirty($request->validated());

        return to_route('auth.edit')->withFlash([
            'success' => 'Your details have been updated.',
        ]);

    }

    public function destroy(): RedirectResponse
    {

        Auth::logout();

        session()->invalidate();

        return to_route('login');

    }
}
