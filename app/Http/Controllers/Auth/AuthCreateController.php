<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Response;

class AuthCreateController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Auth/Create');
    }
}
