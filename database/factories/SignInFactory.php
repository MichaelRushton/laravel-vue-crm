<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignInFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ip_address' => fake()->ipv4(),
            'email' => fake()->safeEmail(),
            'user_id' => $user = mt_rand(0, 1) ? User::factory() : null,
            'correct_password' => $user ? (bool) mt_rand(0, 1) : null,
        ];
    }
}
