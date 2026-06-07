<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $count = $this->command->ask('How many users would you like to seed?', 200);

        $password = Hash::make('password1234');

        if ($count && ! User::count()) {

            $count--;

            User::factory()->administrator()->create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => $password,
            ]);

        }

        if ($count) {
            User::factory($count)->create(['password' => $password]);
        }

    }
}
