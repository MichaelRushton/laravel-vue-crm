<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\AuthEditResource;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Inertia\Response;

class AuthEditController extends Controller
{
    public function __invoke(Request $request): Response
    {

        return inertia('Auth/Edit', [
            'user' => new AuthEditResource($request->user()),
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }
}
