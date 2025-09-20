<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::inertia('/sign-in', 'Auth/SignIn')->name('login');
    Route::post('/sign-in', [AuthController::class, 'store'])->name('auth.store')->middleware('throttle:auth.store');

    Route::controller(ResetPasswordController::class)->name('password.')->group(function () {
        Route::inertia('/reset-password', 'ResetPassword/Create')->name('create');
        Route::post('/reset-password', 'store')->name('store')->middleware('throttle:auth.store');
        Route::get('/reset-password/{token}', 'edit')->name('reset');
        Route::patch('/reset-password', 'update')->name('update');
    });

});

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'show'])->name('dashboard.show');

    Route::resource('users', UserController::class)
        ->except(['show', 'destroy'])
        ->whereNumber('user');

    Route::controller(UserController::class)->name('users.')->group(function () {
        Route::post('/users/{user}/impersonate', 'impersonate')->whereNumber('user')->name('impersonate');
        Route::delete('/users/impersonate', 'unimpersonate')->name('unimpersonate');
    });

    Route::resource('customers', CustomerController::class)
        ->except('show')
        ->whereNumber('customer');

    Route::controller(CustomerController::class)->name('customers.')->group(function () {
        Route::patch('/customers/{customer}/restore', 'restore')->whereNumber('customer')->name('restore')->withTrashed();
    });

    Route::resource('sign-ins', SignInController::class)->only('index');

    Route::delete('/sign-out', [AuthController::class, 'destroy'])->name('auth.destroy');

});
