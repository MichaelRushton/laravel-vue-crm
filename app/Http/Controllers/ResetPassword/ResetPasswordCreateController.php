<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;

class ResetPasswordCreateController extends Controller
{
    public function __invoke(): InertiaResponse
    {
        return inertia('PasswordReset/Create');
    }
}
