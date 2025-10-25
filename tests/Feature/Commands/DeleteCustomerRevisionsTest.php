<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\CustomerRevision;

test('deletes customer revisions older than 30 days', function () {

    Customer::factory(5)->create();

    $this->travel(31)->days();

    Customer::factory(10)->create();

    $this->artisan('customers:delete-revisions');

    expect(CustomerRevision::count())
        ->toBe(10);

});

test('delete customer revisions before date', function () {

    Customer::factory(5)->create();

    $this->travel(61)->days();

    Customer::factory(10)->create();

    $this->artisan('customers:delete-revisions --before="'.today()->subDays(60).'"');

    expect(CustomerRevision::count())
        ->toBe(10);

});
