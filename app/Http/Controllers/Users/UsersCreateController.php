<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class UsersCreateController extends Controller
{
    public function __invoke(): Response
    {

        Gate::authorize('create', User::class);

        return inertia('Users/Edit', [
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
            'password_min' => config('auth.password_validation.min'),
        ]);

    }
}
