<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserImageController;
use App\Http\Controllers\ChangeCityController;
use App\Http\Middleware\Event\TimeHandleMiddleware;
use App\Http\Middleware\Event\PhoneFormatMiddleware;

Route::get('/', HomepageController::class)->name('home');

Route::post('/change_city', ChangeCityController::class)->name('change_city');

Route::get('/users/balance', [UserController::class, 'balance'])
    ->middleware('auth')
->name('balance');
Route::get('/users/events', [UserController::class, 'userEvents'])
->middleware('auth')
->name('users.events');
Route::post('/users/edit/{user}', [UserController::class, 'update'])
->middleware('auth')
->name('users.update');
Route::get('/users/{user}', [UserController::class, 'show'])
->name('users.show');


Route::post('/users/photo/add', [UserImageController::class, 'store'])->name('userImage.store');
Route::delete('/users/photo/delete/{userImage}', [UserImageController::class, 'destroy'])
    ->name('userImage.destroy');


Route::get('/events', [EventController::class, 'index'])
->name('events.index');
Route::get('/events/edit/{event}', [EventController::class, 'edit'])
    ->middleware('auth')
    ->name('events.edit');
Route::post('/events/edit/{event}', [EventController::class, 'update'])
    ->middleware('auth')
    ->middleware(PhoneFormatMiddleware::class)
    ->middleware(TimeHandleMiddleware::class)
    ->name('events.update');
Route::get('/events/create', [EventController::class, 'create'])
    ->middleware('auth')
    ->name('events.create');
Route::post('/events/create', [EventController::class, 'store'])
    ->middleware('auth')
    ->middleware(PhoneFormatMiddleware::class)
    ->middleware(TimeHandleMiddleware::class)
    ->name('events.store');
Route::delete('/events/delete/{event}', [EventController::class, 'destroy'])
    ->middleware('auth')
    ->name('events.delete');
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');


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
