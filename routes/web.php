<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomepageController::class)->name('home');

Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/balance', [UserController::class, 'balance'])
    ->name('balance');



Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

Route::get('/events/create', [EventController::class, 'create'])
    ->middleware('auth')
    ->name('events.create');

Route::post('/events/create', [EventController::class, 'store'])
    ->middleware('auth')
    ->name('events.store');

Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('/events/edit/{event}', [EventController::class, 'edit'])
    ->middleware('auth')
    ->name('events.edit');

Route::post('/events/edit/{event}', [EventController::class, 'update'])
    ->middleware('auth')
    ->name('events.update');



Route::view('/public-offer', 'static.public-offer')
    ->name('offer');

Route::view('/terms-of-use', 'static.terms-of-use')
    ->name('terms');

Route::view('/privacy-policy', 'static.privacy-policy')
    ->name('policy');

Route::view('/payment-security', 'static.payment-security')
    ->name('payment-security');

Route::view('/processing-of-personal-data', 'static.processing-of-personal-data')
->name('processing');

Route::view('/dissemination-of-personal-data', 'static.dissemination-of-personal-data')
->name('dissemination');

require __DIR__ . '/auth.php';
