<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Actions\Users\UnimpersonateUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UsersUnimpersonateController extends Controller
{
    public function __invoke(UnimpersonateUser $unimpersonate): RedirectResponse
    {

        if (! $unimpersonate->handle()) {
            abort(400);
        }

        return to_route('dashboard.show');

    }
}
