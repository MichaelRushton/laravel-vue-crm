<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Seeder;

class UserNotificationSeeder extends Seeder
{
    public function run(): void
    {

        $count = $this->command->ask('How many user notifications would you like to seed?', 100);

        if ($count) {
            UserNotification::factory($count)
                ->recycle(User::all())
                ->create();
        }

    }
}
