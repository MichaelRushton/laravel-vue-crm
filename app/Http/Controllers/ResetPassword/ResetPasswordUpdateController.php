<?php

declare(strict_types=1);

namespace App\Http\Controllers\ResetPassword;

use App\Actions\PasswordReset\UpdatePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\PasswordResetUpdateRequest;
use App\Models\PasswordReset;

class ResetPasswordUpdateController extends Controller
{
    public function __invoke(
        PasswordResetUpdateRequest $request,
        PasswordReset $password_reset,
        UpdatePassword $update_password
    ) {

        $update_password->handle($password_reset, $request);

        return to_route('dashboard.show');

    }
}
