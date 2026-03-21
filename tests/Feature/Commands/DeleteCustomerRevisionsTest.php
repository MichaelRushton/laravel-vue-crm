<?php

declare(strict_types=1);

use App\Models\Customer;
use App\Models\CustomerRevision;

test('deletes customer revisions older than 30 days', function () {

    Customer::factory(5)->create();

    $this->travel(config('data-cleanse.customer_revisions', 365) + 1)->days();

    Customer::factory(10)->create();

    $this->artisan('customers:delete-revisions');

    expect(CustomerRevision::count())
        ->toBe(10);

});

test('delete customer revisions before date', function () {

    Customer::factory(5)->create();

    $this->travel($days = config('data-cleanse.customer_revisions', 365) + 11)->days();

    Customer::factory(10)->create();

    $this->artisan('customers:delete-revisions --before="'.today()->subDays($days - 1).'"');

    expect(CustomerRevision::count())
        ->toBe(10);

});
