<?php

use App\Jobs\ForceDeleteCustomers;
use App\Models\Customer;

test('force delete customers every week', function () {

    $job = new ForceDeleteCustomers;

    Customer::factory(10)->create();

    Customer::first()->delete();

    $job->handle();

    expect(Customer::withTrashed()->count())
        ->toBe(10);

    $this->travel(7)->days();

    $job->handle();

    expect(Customer::withTrashed()->count())
        ->toBe(10);

    $this->travel(1)->days();

    $job->handle();

    expect(Customer::withTrashed()->count())
        ->toBe(9);

});
