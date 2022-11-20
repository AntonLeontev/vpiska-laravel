<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Events\EventCanceled;
use App\Events\OrderCanceled;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\TransferMoneyOrderCreated;
use App\Listeners\TransferMoneyEventCanceled;
use App\Listeners\TransferMoneyOrderCanceled;
use App\Listeners\SendCancelOrderNotification;
use App\Listeners\SendEventCanceledNotification;
use App\Listeners\SendThanksForOrderNotification;
use App\Listeners\TransferMoney;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendNewOrderNotification::class,
            SendThanksForOrderNotification::class,
        ],
        OrderCanceled::class => [
            SendCancelOrderNotification::class,
        ],
        EventCanceled::class => [
            SendEventCanceledNotification::class,
        ],
    ];

    protected $subscribe = [
        TransferMoney::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
