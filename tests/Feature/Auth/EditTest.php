<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view edit user page', function () {

    $this->get(route('auth.edit'))
        ->assertRedirectToRoute('login');

});

test('view edit user page', function () {

    $this->actingAs($user = User::factory()->create())
        ->get(route('auth.edit'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Auth/Edit')
            ->has('user', fn (AssertableInertia $page) => $page
                ->where('uuid', $user->uuid)
                ->where('first_name', $user->first_name)
                ->where('last_name', $user->last_name)
                ->where('email', $user->email)
            )
        );

});
