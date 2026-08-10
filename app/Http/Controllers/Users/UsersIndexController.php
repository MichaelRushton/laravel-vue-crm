<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserIndexResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class UsersIndexController extends Controller
{
    public function __invoke(Request $request): Response
    {

        Gate::authorize('viewAny', User::class);

        $users = UserIndexResource::collection(
            User::search($request->name, ['first_name', 'last_name'])
                ->whereRole($role = $request->enum('role', UserRole::class))
                ->whereStatus($status = $request->has('status') ? $request->enum('status', UserStatus::class) : UserStatus::Active)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->orderBy('id')
                ->cursorPaginate((int) ($request->per_page ?: 100))
        );

        return inertia('Users/Index', [
            'users' => inertia()->scroll($users),
            'search' => [
                'name' => $request->name,
                'role' => $role ?? '',
                'status' => $status ?? '',
            ],
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
        ]);

    }
}
