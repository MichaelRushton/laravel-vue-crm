<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UsersEditResource;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class UsersEditController extends Controller
{
    public function __invoke(User $user): Response
    {

        Gate::authorize('update', $user);

        return inertia('Users/Edit', [
            'user' => new UsersEditResource($user),
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }
}
