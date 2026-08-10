<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersStoreRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UsersStoreController extends Controller
{
    public function __invoke(UsersStoreRequest $request): RedirectResponse
    {

        User::create($request->validated());

        return to_route('users.index')->withFlash([
            'success' => 'The user has been created.',
        ]);

    }
}
