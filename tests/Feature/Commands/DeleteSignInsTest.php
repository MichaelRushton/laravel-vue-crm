<?php

declare(strict_types=1);

use App\Models\SignIn;

test('deletes sign ins older than 30 days', function () {

    SignIn::factory(5)->create();

    $this->travel(31)->days();

    SignIn::factory(10)->create();

    $this->artisan('sign-ins:delete');

    expect(SignIn::count())
        ->toBe(10);

});

test('delete sign ins before date', function () {

    SignIn::factory(5)->create();

    $this->travel(61)->days();

    SignIn::factory(10)->create();

    $this->artisan('sign-ins:delete --before="'.today()->subDays(60).'"');

    expect(SignIn::count())
        ->toBe(10);

});
