<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomepageController::class)->name('home');

Route::get('/users/{user}', [UserController::class, 'show']);

Route::get('/create', function () {
    return view('create');
})->name('create');

Route::get('/find', function () {
    return view('find');
})->name('find');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
