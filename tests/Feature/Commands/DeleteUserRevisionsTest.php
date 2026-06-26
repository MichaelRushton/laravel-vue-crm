<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserRevision;
use Illuminate\Console\Command;

test('requires a --before date', function () {

    $this->artisan('users:delete-revisions')
        ->expectsOutput('You must provide a --before date')
        ->assertExitCode(Command::INVALID);

});

test('delete user revisions before date', function () {

    User::factory(5)->create();

    $this->travel($days = 365 + 11)->days();

    User::factory(10)->create();

    $this->artisan('users:delete-revisions --before="'.today()->subDays($days - 1).'"')
        ->assertSuccessful();

    expect(UserRevision::count())
        ->toBe(10);

});
