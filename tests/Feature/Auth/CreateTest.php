<?php

use Inertia\Testing\AssertableInertia;

test('can view sign in page', function () {

    $this->get(route('login'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Auth/SignIn')
        );

});
