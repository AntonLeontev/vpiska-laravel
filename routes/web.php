<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\CypixController;
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
    Route::put('users/events/{user}', [UserController::class, 'resetNotifications']);
});
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

/*------------------User photos---------------------*/
Route::post('/users/photo/add', [UserImageController::class, 'store'])
    ->name('userImage.store');
Route::delete('/users/photo/delete/{userImage}', [UserImageController::class, 'destroy'])
    ->name('userImage.destroy');

/*------------------Event photos---------------------*/
Route::controller(EventImageController::class)->group(function () {
    Route::post('/events/photo/add', 'store')
    ->name('eventImage.store');
    Route::delete('/events/photo/delete/{eventImage}', 'destroy')
    ->name('eventImage.destroy');
});

/*------------------Temp photos---------------------*/
Route::controller(TemporaryImageController::class)->group(function () {
    Route::post('/events/photo/temp/preload', 'store')
        ->name('temporaryImage.store');
    Route::delete('/events/photo/temp/delete/{temporaryImage}', 'destroy')
    ->name('temporaryImage.destroy');
});

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
    Route::put('/events/cancel/{event}', [EventController::class, 'cancel'])
    ->name('events.cancel');
});
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');
Route::get('/events/archive', [EventController::class, 'archiveOld']);

/*------------------Orders---------------------*/
Route::controller(OrderController::class)->middleware('auth')->group(function () {
    Route::post('/orders/create', 'store')
        ->middleware(PaymentIdMiddleware::class)
        ->name('orders.store');
    Route::delete('/orders/delete/{order}', 'destroy')
        ->name('orders.delete');
    Route::post('/orders/accept/{order}', 'accept')
        ->name('orders.accept');
    Route::post('/orders/decline/{order}', 'decline')
        ->name('orders.decline');
    Route::post('/activate_code', 'activateCode')
        ->name('activate_code');
    Route::post('orders/hide/{order}', 'hide')->name('orders.hide');
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

/*------------------Payments---------------------*/
Route::controller(CypixController::class)->group(function () {
    Route::get('/pay', 'pay')->name('pay');

    Route::post('/pay/notification', 'handlePayment')
    ->withoutMiddleware([VerifyCsrfToken::class])
        ->name('pay.notification');
});

require __DIR__ . '/auth.php';
