<?php

declare(strict_types=1);

use App\Models\PasswordReset;

test('deletes password resets older than 30 days', function () {

    PasswordReset::factory(5)->create();

    $this->travel(31)->days();

    PasswordReset::factory(10)->create();

    $this->artisan('password-resets:delete');

    expect(PasswordReset::count())
        ->toBe(10);

});

test('delete password resets before date', function () {

    PasswordReset::factory(5)->create();

    $this->travel(61)->days();

    PasswordReset::factory(10)->create();

    $this->artisan('password-resets:delete --before="'.today()->subDays(60).'"');

    expect(PasswordReset::count())
        ->toBe(10);

});
