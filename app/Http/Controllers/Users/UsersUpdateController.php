<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UsersUpdateController extends Controller
{
    public function __invoke(UsersUpdateRequest $request, User $user): RedirectResponse
    {

        $user->updateIfDirty($request->validated());

        return to_route('users.index')->withFlash([
            'success' => 'The user has been updated.',
        ]);

    }
}
