<?php

declare(strict_types=1);

use App\Models\UserImpersonation;

test('deletes user impersonations older than 30 days', function () {

    UserImpersonation::factory(5)->create();

    $this->travel(config('data-cleanse.user_impersonations', 365) + 1)->days();

    UserImpersonation::factory(10)->create();

    $this->artisan('users:delete-impersonations');

    expect(UserImpersonation::count())
        ->toBe(10);

});

test('delete user impersonations before date', function () {

    UserImpersonation::factory(5)->create();

    $this->travel($days = config('data-cleanse.user_impersonations', 365) + 11)->days();

    UserImpersonation::factory(10)->create();

    $this->artisan('users:delete-impersonations --before="'.today()->subDays($days - 1).'"');

    expect(UserImpersonation::count())
        ->toBe(10);

});
