<?php

use App\Enums\Can;
use App\Livewire\Auth\{Login, Password, Register};
use App\Livewire\{Admin, Welcome};
use Illuminate\Support\Facades\Route;

//region Login/Logout Routes
Route::get('login', Login::class)
    ->name('login');
Route::get('logout', fn () => Auth::logout() && redirect('login'));
//endregion

//region Register/Password Routes
Route::get('register', Register::class)
    ->name('auth.register');
Route::get('password/recovery', Password\Recovery::class)
    ->name('password.recovery');
Route::get('password/reset', Password\Reset::class)
    ->name('password.reset');
//endregion

//region Middleware Auth
Route::middleware('auth')->group(function () {
    //region Dashboard
    Route::get('', Welcome::class)
        ->name('dashboard');
    //endregion

    //region Admin Route
    Route::prefix('admin')
        ->middleware('can:' . Can::BE_AN_ADMIN->value)
        ->group(
            function () {
                Route::get('dashboard', Admin\Dashboard::class)
                    ->name('admin.dashboard');

                Route::get('users', Admin\Users\Index::class)
                    ->name('admin.users');
            }
        );
    //endregion
});
//endregion
