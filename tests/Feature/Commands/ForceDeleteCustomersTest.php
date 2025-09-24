<?php

use App\Models\Customer;

test('confirms delete all trashed customers', function () {

    Customer::factory(10)->create();

    Customer::first()->delete();

    $this->artisan('customers:delete-trashed')
        ->expectsConfirmation('Are you sure you would like to delete all trashed customers?');

    expect(Customer::withTrashed()->count())
        ->toBe(10);

});

test('deletes all trashed customers', function () {

    Customer::factory(10)->create();

    Customer::first()->delete();

    $this->artisan('customers:delete-trashed')
        ->expectsConfirmation('Are you sure you would like to delete all trashed customers?', 'yes');

    expect(Customer::withTrashed()->count())
        ->toBe(9);

});

test('delete customers before date', function () {

    Customer::factory(10)->create();

    Customer::first()->delete();

    $this->artisan('customers:delete-trashed --before="'.today().'"');

    expect(Customer::withTrashed()->count())
        ->toBe(10);

    $this->artisan('customers:delete-trashed --before="'.today()->addDay().'"');

    expect(Customer::withTrashed()->count())
        ->toBe(9);

});
