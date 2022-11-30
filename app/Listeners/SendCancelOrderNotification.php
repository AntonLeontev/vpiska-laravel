<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use App\Mail\Orders\OrderOnYourEventWasCanceled;
use App\Mail\Orders\YouCanceledOrder;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCancelOrderNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCanceled  $event
     * @return void
     */
    public function handle(OrderCanceled $orderCanceled)
    {
        $customer = User::find($orderCanceled->order->customer_id);
        $creator  = User::find($orderCanceled->order->event->creator_id);

        Mail::to($customer->email)->send(new YouCanceledOrder($orderCanceled->order->event));
        Mail::to($creator->email)->send(new OrderOnYourEventWasCanceled($orderCanceled->order->event));
    }
}
