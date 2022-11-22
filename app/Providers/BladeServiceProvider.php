<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

use function PHPUnit\Framework\isNull;
use Illuminate\Support\ServiceProvider;

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
            if (is_null(auth()->user())) {
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
            if (is_null(auth()->user())) {
                return false;
            }

            $authenticatedUserOrders = $event->orders->filter(function ($value, $key) {
                if ($value['customer_id'] === auth()->user()->id) {
                    return true;
                }
                return false;
            })->count();

            return $authenticatedUserOrders > 0;
        });

        Blade::if('isPaid', function (Event $event) {
            if (is_null(auth()->user())) {
                return false;
            }

            $order = $event->orders->first(function ($order) {
                return $order->customer_id === Auth::user()->id;
            });

            if (empty($order)) {
                return false;
            }

            if ($order->payment_id === 'balance') {
                return true;
            }
            //TODO isPaid
            return false;
        });

        Blade::if('hasTooManyEvents', function (User $user) {
            return Event::where('ends_at', '>', now())
                ->where('creator_id', $user->id)
                ->count() > 0;
        });

        Blade::if('userActivated', function (User $user) {
            if (is_null($user->email_verified_at)) {
                return false;
            }

            return true;
        });
    }
}
