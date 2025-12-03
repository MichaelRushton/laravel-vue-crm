<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignInFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ip_address' => $this->faker->ipv4(),
            'email' => $this->faker->safeEmail(),
            'user_id' => $user = mt_rand(0, 1) ? User::factory() : null,
            'correct_password' => $user ? mt_rand(0, 1) : null,
        ];
    }
}
