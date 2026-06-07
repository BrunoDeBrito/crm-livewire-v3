<?php

use App\Livewire\Auth\Register;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class);
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => Auth::logout());
