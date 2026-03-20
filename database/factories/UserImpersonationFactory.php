<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserImpersonationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
}
