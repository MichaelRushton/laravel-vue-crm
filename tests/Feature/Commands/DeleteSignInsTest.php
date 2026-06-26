<?php

declare(strict_types=1);

use App\Models\SignIn;
use Illuminate\Console\Command;

test('requires a --before date', function () {

    $this->artisan('sign-ins:delete')
        ->expectsOutput('You must provide a --before date')
        ->assertExitCode(Command::INVALID);

});

test('delete sign ins before date', function () {

    SignIn::factory(5)->create();

    $this->travel($days = 365 + 1)->days();

    SignIn::factory(10)->create();

    $this->artisan('sign-ins:delete --before="'.today()->subDays($days - 1).'"')
        ->assertSuccessful();

    expect(SignIn::count())
        ->toBe(10);

});
