<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UsersUpdateController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user): RedirectResponse
    {

        $user->updateIfDirty($request->validated());

        return to_route('users.index')->withFlash([
            'success' => 'The user has been updated.',
        ]);

    }
}
