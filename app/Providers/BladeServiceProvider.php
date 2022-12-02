<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Event;
use App\Services\Cypix\CypixService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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

            $authenticatedUserOrders = $event->orders->filter(function ($order, $key) {
                return $order->customer_id === Auth::user()->id;
            })->count();

            return $authenticatedUserOrders > 0;
        });

        Blade::if('isPaid', function (Event $event) {
            if (is_null(auth()->user())) {
                return false;
            }

            $order = $event->orders->last(function ($order) {
                return $order->customer_id === Auth::user()->id;
            });

            if (empty($order)) {
                return false;
            }

            if ($order->payment_id === 'balance') {
                return true;
            }

            if (is_null($order->payment_id)) {
                return false;
            }

            return app(CypixService::class)->transactionIsPaid($order->payment_id);
        });

        Blade::if('hasTooManyEvents', function (User $user) {
            return Event::where('ends_at', '>', now())
                ->where('creator_id', $user->id)
                ->where('status', Event::ACTIVE)
                ->where('ends_at', '>', now())
                ->count() > 0;
        });

        Blade::if('userActivated', function (User $user) {
            return !is_null($user->email_verified_at);
        });
    }
}
