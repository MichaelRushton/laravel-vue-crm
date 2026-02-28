<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsUserActive;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::inertia('/sign-in', 'Auth/Create')->name('login');
    Route::post('/sign-in', [AuthController::class, 'store'])->name('auth.store')->middleware('throttle:auth.store');

    Route::resource('reset-password', ResetPasswordController::class)
        ->except(['create', 'edit', 'destroy'])
        ->whereUuid('password_reset');

});

Route::middleware(['auth', IsUserActive::class])->group(function () {

    Route::get('/', [DashboardController::class, 'show'])->name('dashboard.show');

    Route::resource('customers', CustomerController::class)
        ->except(['show', 'destroy'])
        ->whereUuid('customer');

    Route::resource('users', UserController::class)
        ->except(['show', 'destroy'])
        ->whereUuid('user');

    Route::controller(UserController::class)->name('users.')->group(function () {
        Route::post('/users/{user}/impersonate', 'impersonate')->whereUuid('user')->name('impersonate');
        Route::delete('/users/impersonate', 'unimpersonate')->name('unimpersonate');
    });

    Route::controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('/user/edit', 'edit')->name('edit');
        Route::patch('/user', 'update')->name('update');
        Route::delete('/sign-out', 'destroy')->name('destroy');
    });

});
