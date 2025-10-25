<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('must be signed in to view create customer page', function () {

    $this->get(route('customers.create'))
        ->assertRedirectToRoute('login');

});

test('view create customer page', function () {

    $this->actingAs(User::factory()->create())
        ->get(route('customers.create'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Customers/Edit')
        );

});
