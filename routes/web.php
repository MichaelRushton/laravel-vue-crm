<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthCreateController;
use App\Http\Controllers\Auth\AuthDestroyController;
use App\Http\Controllers\Auth\AuthEditController;
use App\Http\Controllers\Auth\AuthStoreController;
use App\Http\Controllers\Auth\AuthUpdateController;
use App\Http\Controllers\ResetPassword\ResetPasswordCreateController;
use App\Http\Controllers\ResetPassword\ResetPasswordEditController;
use App\Http\Controllers\ResetPassword\ResetPasswordStoreController;
use App\Http\Controllers\ResetPassword\ResetPasswordUpdateController;
use App\Http\Controllers\Users\UsersCreateController;
use App\Http\Controllers\Users\UsersEditController;
use App\Http\Controllers\Users\UsersImpersonateController;
use App\Http\Controllers\Users\UsersIndexController;
use App\Http\Controllers\Users\UsersShowController;
use App\Http\Controllers\Users\UsersStoreController;
use App\Http\Controllers\Users\UsersUnimpersonateController;
use App\Http\Controllers\Users\UsersUpdateController;
use App\Http\Middleware\IsUserActive;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('/sign-in', AuthCreateController::class)->name('login');
    Route::post('/sign-in', AuthStoreController::class)->name('auth.store')->middleware('throttle:auth.store');

    Route::name('reset-password.')->prefix('/reset-password')->group(function () {
        Route::get('/', ResetPasswordCreateController::class)->name('create');
        Route::post('/', ResetPasswordStoreController::class)->name('store');
        Route::get('/{password_reset}', ResetPasswordEditController::class)->name('edit')->whereUuid('password_reset');
        Route::patch('/{password_reset}', ResetPasswordUpdateController::class)->name('update')->whereUuid('password_reset');
    });

});

Route::middleware(['auth', IsUserActive::class])->group(function () {

    Route::inertia('/', 'Dashboard/Show')->name('dashboard.show');

    Route::name('users.')->prefix('/users')->group(function () {
        Route::get('/', UsersIndexController::class)->name('index');
        Route::get('/create', UsersCreateController::class)->name('create');
        Route::post('/', UsersStoreController::class)->name('store');
        Route::get('/{user}', UsersShowController::class)->name('show')->whereUuid('user');
        Route::get('/{user}/edit', UsersEditController::class)->name('edit')->whereUuid('user');
        Route::patch('/{user}', UsersUpdateController::class)->name('update')->whereUuid('user');
        Route::post('/{user}/impersonate', UsersImpersonateController::class)->name('impersonate')->whereUuid('user');
        Route::delete('/impersonate', UsersUnimpersonateController::class)->name('unimpersonate');
    });

    Route::name('auth.')->group(function () {
        Route::get('/user/edit', AuthEditController::class)->name('edit');
        Route::patch('/user', AuthUpdateController::class)->name('update');
        Route::delete('/sign-out', AuthDestroyController::class)->name('destroy');
    });

});
