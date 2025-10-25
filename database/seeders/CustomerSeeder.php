<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {

        $count = $this->command->ask('How many customers would you like to seed?', 100);

        if ($count) {
            Customer::factory($count)->create();
        }

    }
}
