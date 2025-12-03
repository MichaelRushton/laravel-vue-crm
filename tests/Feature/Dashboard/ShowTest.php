<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view dashboard', function () {

    $this->get(route('dashboard.show'))
        ->assertRedirectToRoute('login');

});

test('view dashboard', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('dashboard.show'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Dashboard/Show')
        );

});
