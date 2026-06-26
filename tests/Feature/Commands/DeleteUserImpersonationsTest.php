<?php

declare(strict_types=1);

use App\Models\UserImpersonation;
use Illuminate\Console\Command;

test('requires a --before date', function () {

    $this->artisan('users:delete-impersonations')
        ->expectsOutput('You must provide a --before date')
        ->assertExitCode(Command::INVALID);

});

test('delete user impersonations before date', function () {

    UserImpersonation::factory(5)->create();

    $this->travel($days = 365 + 11)->days();

    UserImpersonation::factory(10)->create();

    $this->artisan('users:delete-impersonations --before="'.today()->subDays($days - 1).'"')
        ->assertSuccessful();

    expect(UserImpersonation::count())
        ->toBe(10);

});
