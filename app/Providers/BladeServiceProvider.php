<?php

namespace App\Providers;

use App\Models\Event;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use function PHPUnit\Framework\isNull;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('isCreator', function (Event $event) {
            if (isNull(auth()->user())) {
                return false;
            }

            return auth()->user()->id === $event->creator->id;
        });

        Blade::if('isFilled', function (Event $event) {
            $acceptedOrders = $event->orders->filter(function ($value, $key) {
                if ($value['status'] === 1) {
                    return true;
                }
                return false;
            })->count();
            return $event->max_members <= $acceptedOrders;
        });

        Blade::if('isOrdered', function (Event $event) {
            if (isNull(auth()->user())) {
                return false;
            }

            $authenticatedUserOrders = $event->orders->filter(function ($value, $key) {
                if ($value['customer_id'] === auth()->user()->id) {
                    return true;
                }
                return false;
            })->count();

            if ($authenticatedUserOrders > 0) {
                return true;
            }
        });

        Blade::if('isPaid', function (Event $event) {
            if (isNull(auth()->user())) {
                return false;
            }

            //TODO isPaid
            return false;
        });
    }
}