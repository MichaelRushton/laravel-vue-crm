<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\ShowUserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UsersShowController extends Controller
{
    public function __invoke(User $user): ShowUserResource
    {

        Gate::authorize('view', $user);

        return new ShowUserResource($user);

    }
}
