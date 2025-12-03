<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view edit user page', function () {

    $this->get(route('users.edit', User::factory()->create()))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view edit user page', function () {

    $this->actingAs($user = User::factory()->create())
        ->get(route('users.edit', $user))
        ->assertForbidden();

});

test('view edit user page', function () {

    $this->actingAs($user = User::factory()->administrator()->create())
        ->get(route('users.edit', $user))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Edit')
            ->has('user', fn (AssertableInertia $page) => $page
                ->where('uuid', $user->uuid)
                ->where('first_name', $user->first_name)
                ->where('last_name', $user->last_name)
                ->where('email', $user->email)
                ->where('role', $user->role->value)
                ->where('status', $user->status->value)
            )
            ->where('roles', UserRole::dropdown())
            ->where('statuses', UserStatus::dropdown())
        );

});
