<?php

use App\Livewire\Auth\Register;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('dashboard');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => Auth::logout());
