<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

test('view sign in page', function () {

    $this->get(route('login'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Auth/Create')
        );

});
