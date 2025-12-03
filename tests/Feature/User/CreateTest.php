<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view create user page', function () {

    $this->get(route('users.create'))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view create user page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('users.create'))
        ->assertForbidden();

});

test('view create user page', function () {

    $this->actingAs(User::factory()->administrator()->create())
        ->get(route('users.create'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Edit')
            ->where('roles', UserRole::dropdown())
            ->where('statuses', UserStatus::dropdown())
        );

});
