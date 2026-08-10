<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthUpdateRequest;
use Illuminate\Http\RedirectResponse;

class AuthUpdateController extends Controller
{
    public function __invoke(AuthUpdateRequest $request): RedirectResponse
    {

        $request->user()->updateIfDirty($request->validated());

        return to_route('auth.edit')->withFlash([
            'success' => 'Your details have been updated.',
        ]);

    }
}
