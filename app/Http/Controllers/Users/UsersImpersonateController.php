<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Actions\Users\ImpersonateUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersImpersonateController extends Controller
{
    public function __invoke(
        Request $request,
        User $user,
        ImpersonateUser $impersonate
    ): RedirectResponse {

        Gate::authorize('impersonate', $user);

        $impersonate->handle($user, $request->user());

        return to_route('dashboard.show');

    }
}
