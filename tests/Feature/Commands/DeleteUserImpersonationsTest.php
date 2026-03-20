<?php

declare(strict_types=1);

use App\Models\UserImpersonation;

test('deletes user impersonations older than 30 days', function () {

    UserImpersonation::factory(5)->create();

    $this->travel(31)->days();

    UserImpersonation::factory(10)->create();

    $this->artisan('users:delete-impersonations');

    expect(UserImpersonation::count())
        ->toBe(10);

});

test('delete user impersonations before date', function () {

    UserImpersonation::factory(5)->create();

    $this->travel(61)->days();

    UserImpersonation::factory(10)->create();

    $this->artisan('users:delete-impersonations --before="'.today()->subDays(60).'"');

    expect(UserImpersonation::count())
        ->toBe(10);

});
