<?php

declare(strict_types=1);

use App\Models\SignIn;

test('deletes sign ins older than 30 days', function () {

    SignIn::factory(5)->create();

    $this->travel(config('data-cleanse.sign_ins', 365) + 1)->days();

    SignIn::factory(10)->create();

    $this->artisan('sign-ins:delete');

    expect(SignIn::count())
        ->toBe(10);

});

test('delete sign ins before date', function () {

    SignIn::factory(5)->create();

    $this->travel($days = config('data-cleanse.sign_ins', 365) + 1)->days();

    SignIn::factory(10)->create();

    $this->artisan('sign-ins:delete --before="'.today()->subDays($days - 1).'"');

    expect(SignIn::count())
        ->toBe(10);

});
