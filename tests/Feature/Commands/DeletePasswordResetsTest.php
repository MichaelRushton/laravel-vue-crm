<?php

declare(strict_types=1);

use App\Models\PasswordReset;

test('deletes password resets older than 30 days', function () {

    PasswordReset::factory(5)->create();

    $this->travel(config('data-cleanse.password_resets', 365) + 1)->days();

    PasswordReset::factory(10)->create();

    $this->artisan('password-resets:delete');

    expect(PasswordReset::count())
        ->toBe(10);

});

test('delete password resets before date', function () {

    PasswordReset::factory(5)->create();

    $this->travel($days = config('data-cleanse.password_resets', 365) + 11)->days();

    PasswordReset::factory(10)->create();

    $this->artisan('password-resets:delete --before="'.today()->subDays($days - 1).'"');

    expect(PasswordReset::count())
        ->toBe(10);

});
