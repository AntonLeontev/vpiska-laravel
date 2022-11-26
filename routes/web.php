<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomepageController;
use App\Http\Middleware\PaymentIdMiddleware;
use App\Http\Controllers\UserImageController;
use App\Http\Controllers\ChangeCityController;
use App\Http\Controllers\EventImageController;
use App\Http\Controllers\TemporaryImageController;
use App\Http\Middleware\Event\TimeHandleMiddleware;
use App\Http\Middleware\Event\PhoneFormatMiddleware;

Route::get('/', HomepageController::class)->name('home');


Route::post('/change_city', ChangeCityController::class)->name('change_city');

/*------------------Users---------------------*/
Route::middleware('auth')->group(function () {
    Route::get('/users/balance', [UserController::class, 'balance'])
    ->name('balance');
    Route::get('/users/events', [UserController::class, 'userEvents'])
    ->name('users.events');
    Route::post('/users/edit/{user}', [UserController::class, 'update'])
    ->name('users.update');
});
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

/*------------------User photos---------------------*/
Route::post('/users/photo/add', [UserImageController::class, 'store'])
    ->name('userImage.store');
Route::delete('/users/photo/delete/{userImage}', [UserImageController::class, 'destroy'])
    ->name('userImage.destroy');

/*------------------Event photos---------------------*/
Route::post('/events/photo/add', [EventImageController::class, 'store'])->name('eventImage.store');
Route::delete('/events/photo/delete/{eventImage}', [EventImageController::class, 'destroy'])
    ->name('eventImage.destroy');

/*------------------Temp photos---------------------*/
Route::post('/events/photo/temp/preload', [TemporaryImageController::class, 'store'])
    ->name('temporaryImage.store');
Route::delete('/events/photo/temp/delete/{temporaryImage}', [TemporaryImageController::class, 'destroy'])
    ->name('temporaryImage.destroy');

/*------------------Events---------------------*/
Route::get('/events', [EventController::class, 'index'])
->name('events.index');
Route::middleware('auth')->group(function () {
    Route::get('/events/edit/{event}', [EventController::class, 'edit'])
    ->name('events.edit');
    Route::post('/events/edit/{event}', [EventController::class, 'update'])
    ->middleware(PhoneFormatMiddleware::class)
        ->middleware(TimeHandleMiddleware::class)
        ->name('events.update');
    Route::get('/events/create', [EventController::class, 'create'])
    ->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])
    ->middleware(PhoneFormatMiddleware::class)
        ->middleware(TimeHandleMiddleware::class)
        ->name('events.store');
    Route::delete('/events/delete/{event}', [EventController::class, 'destroy'])
    ->name('events.delete');
});
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

/*------------------Orders---------------------*/
Route::middleware('auth')->group(function () {
    Route::post('/orders/create', [OrderController::class, 'store'])
        ->middleware(PaymentIdMiddleware::class)
        ->name('orders.store');
    Route::delete('/orders/delete/{order}', [OrderController::class, 'destroy'])
        ->name('orders.delete');
    Route::post('/orders/accept/{order}', [OrderController::class, 'accept'])
        ->name('orders.accept');
    Route::post('/orders/decline/{order}', [OrderController::class, 'decline'])
        ->name('orders.decline');
    Route::post('/activate_code', [OrderController::class, 'activateCode'])
        ->name('activate_code');
});

/*------------------Static---------------------*/
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
