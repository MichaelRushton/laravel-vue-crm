<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view user index page', function () {

    $this->get(route('users.index'))
        ->assertRedirectToRoute('login');

});

test('must be an administrator to view user index page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('users.index'))
        ->assertForbidden();

});

test('can view user index page', function () {

    User::factory(9)->create();

    $this->actingAs(User::factory()->administrator()->create())
        ->get(route('users.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Index')
            ->has('users.data', 10)
        );

});

test('can search users', function () {

    User::factory(9)->create([
        'first_name' => 'test',
        'last_name' => 'test',
    ]);

    $this->actingAs($user = User::factory()->administrator()->create(['first_name' => 'admin']))
        ->get(route('users.index', [
            'search' => 'admin',
        ]))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/Index')
            ->has('users.data', 1, fn (AssertableInertia $page) => $page
                ->where('id', $user->id)
                ->where('first_name', $user->first_name)
                ->where('last_name', $user->last_name)
                ->where('role', $user->role->name())
                ->where('can_impersonate', false)
            )
        );

});
