<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Events\User\UserImpersonated;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\EditUserResource;
use App\Http\Resources\User\UserIndexResource;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {

        Gate::authorize('viewAny', User::class);

        $users = UserIndexResource::collection(
            User::search($request->name, ['first_name', 'last_name'])
                ->whereRole($role = $request->enum('role', UserRole::class))
                ->whereStatus($status = $request->enum('status', UserStatus::class))
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->orderBy('id')
                ->cursorPaginate((int) ($request->per_page ?: 100))
        );

        return inertia('Users/Index', [
            'users' => inertia()->scroll($users),
            'search' => [
                'name' => $request->name,
                'role' => $role?->value ?? '',
                'status' => $status?->value ?? '',
            ],
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
        ]);

    }

    public function create(): Response
    {

        Gate::authorize('create', User::class);

        return inertia('Users/Edit', [
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }

    public function store(StoreUserRequest $request): RedirectResponse
    {

        User::create($request->validated());

        return to_route('users.index')->withFlash([
            'success' => 'The user has been created.',
        ]);

    }

    public function edit(User $user): Response
    {

        Gate::authorize('update', $user);

        return inertia('Users/Edit', [
            'user' => new EditUserResource($user),
            'roles' => UserRole::dropdown(),
            'statuses' => UserStatus::dropdown(),
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {

        $user->updateIfDirty($request->validated());

        return to_route('users.index')->withFlash([
            'success' => 'The user has been updated.',
        ]);

    }

    public function impersonate(User $user, Request $request): RedirectResponse
    {

        Gate::authorize('impersonate', $user);

        if (! $impersonated_by = session('impersonated_by')) {
            session(['impersonated_by' => $impersonated_by = $request->user()]);
        } elseif ($user->is($impersonated_by)) {
            return $this->unimpersonate();
        }

        event(new UserImpersonated($user, $impersonated_by));

        Auth::login($user);

        session()->regenerate();

        return to_route('dashboard.show');

    }

    public function unimpersonate(): RedirectResponse
    {

        if (! $impersonated_by = session('impersonated_by')) {
            abort(400);
        }

        Auth::login($impersonated_by);

        session()->forget('impersonated_by');

        session()->regenerate();

        return to_route('dashboard.show');

    }
}
