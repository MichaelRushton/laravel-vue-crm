<?php

use App\Models\User;
use App\Models\UserNotification;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view dashboard', function () {

    $this->get(route('dashboard.show'))
        ->assertRedirectToRoute('login');

});

test('can view dashboard', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('dashboard.show'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Dashboard/Show')
        );

});

test('dashboard shows notifications', function () {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    UserNotification::factory(1)->recycle($user1)->create();
    UserNotification::factory(2)->recycle($user2)->create();

    $this->actingAs($user1)
        ->get(route('dashboard.show'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Dashboard/Show')
            ->has('notifications', 1)
        );

});
