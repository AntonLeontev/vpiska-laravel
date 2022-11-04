<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomepageController::class)->name('home');

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::get('/events/edit/{event}', [EventController::class, 'edit'])->name('events.edit');

Route::get('/create', function () {
    return view('create');
})->name('create');

Route::view('/public-offer', 'static.public-offer')->name('offer');
Route::view('/terms-of-use', 'static.terms-of-use')->name('terms');
Route::view('/privacy-policy', 'static.privacy-policy')->name('policy');
Route::view('/payment-security', 'static.payment-security')->name('payment-security');
Route::view('/processing-of-personal-data', 'static.processing-of-personal-data')->name('processing');
Route::view('/dissemination-of-personal-data', 'static.dissemination-of-personal-data')->name('dissamination');

require __DIR__ . '/auth.php';
