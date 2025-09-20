<?php

namespace Database\Seeders;

use App\Models\SignIn;
use App\Models\User;
use Illuminate\Database\Seeder;

class SignInSeeder extends Seeder
{
    public function run(): void
    {

        $count = $this->command->ask('How many sign ins would you like to seed?', 100);

        if ($count) {
            SignIn::factory($count)
                ->recycle(User::all())
                ->create();
        }

    }
}
