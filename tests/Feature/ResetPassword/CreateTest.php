<?php

use Inertia\Testing\AssertableInertia;

test('can view password reset page', function () {

    $this->get(route('password.create'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('ResetPassword/Create')
        );

});
