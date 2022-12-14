<?php

namespace App\Providers;

use App\Events\EventArchived;
use App\Events\OrderCreated;
use App\Events\EventCanceled;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderDeclined;
use App\Events\UserCreating;
use App\Listeners\TransferMoney;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendCancelOrderNotification;
use App\Listeners\SendEventCanceledNotification;
use App\Listeners\SendOrderAcceptedNotification;
use App\Listeners\SendOrderDeclinedNotification;
use App\Listeners\CreateUserDefaultPhoto;
use App\Services\vkontakte\CustomVKontakteExtendSocialite;
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
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            CustomVKontakteExtendSocialite::class . '@handle',
        ],
        OrderCreated::class => [
            SendNewOrderNotification::class,
        ],
        OrderCanceled::class => [
            SendCancelOrderNotification::class,
        ],
        OrderAccepted::class => [
            SendOrderAcceptedNotification::class,
        ],
        OrderDeclined::class => [
            SendOrderDeclinedNotification::class,
        ],
        EventCanceled::class => [
            SendEventCanceledNotification::class,
        ],
        EventArchived::class => [
            //
        ],
        UserCreating::class => [
            CreateUserDefaultPhoto::class,
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
