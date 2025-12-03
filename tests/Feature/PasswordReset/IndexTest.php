<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia;

test('view password reset page', function () {

    $this->get(route('reset-password.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('PasswordReset/Index')
        );

});
