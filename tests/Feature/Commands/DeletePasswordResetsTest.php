<?php

declare(strict_types=1);

use App\Models\PasswordReset;
use Illuminate\Console\Command;

test('requires a --before date', function () {

    $this->artisan('password-resets:delete')
        ->expectsOutput('You must provide a --before date')
        ->assertExitCode(Command::INVALID);

});

test('delete password resets before date', function () {

    PasswordReset::factory(5)->create();

    $this->travel($days = 365 + 11)->days();

    PasswordReset::factory(10)->create();

    $this->artisan('password-resets:delete --before="'.today()->subDays($days - 1).'"')
        ->assertSuccessful();

    expect(PasswordReset::count())
        ->toBe(10);

});
