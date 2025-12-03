<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserRevision;

test('deletes user revisions older than 30 days', function () {

    User::factory(5)->create();

    $this->travel(31)->days();

    User::factory(10)->create();

    $this->artisan('users:delete-revisions');

    expect(UserRevision::count())
        ->toBe(10);

});

test('delete user revisions before date', function () {

    User::factory(5)->create();

    $this->travel(61)->days();

    User::factory(10)->create();

    $this->artisan('users:delete-revisions --before="'.today()->subDays(60).'"');

    expect(UserRevision::count())
        ->toBe(10);

});
