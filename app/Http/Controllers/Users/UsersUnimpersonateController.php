<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Services\UserImpersonationService;
use Illuminate\Http\RedirectResponse;

class UsersUnimpersonateController extends Controller
{
    public function __invoke(UserImpersonationService $service): RedirectResponse
    {

        if (! $service->unimpersonate()) {
            abort(400);
        }

        return to_route('dashboard.show');

    }
}
