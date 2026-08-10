<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResetPassword\Traits\CanAuthPasswordReset;
use App\Models\PasswordReset;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class ResetPasswordEditController extends Controller
{
    use CanAuthPasswordReset;

    public function __invoke(Request $request, PasswordReset $password_reset): InertiaResponse
    {

        $this->auth($request, $password_reset);

        return inertia('PasswordReset/Edit', [
            'uuid' => $password_reset->id,
            'token' => $request->token,
            'password_min' => PasswordService::MIN_LENGTH,
        ]);

    }
}
