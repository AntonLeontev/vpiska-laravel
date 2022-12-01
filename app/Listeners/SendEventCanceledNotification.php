<?php

namespace App\Listeners;

use App\Enums\OrderStatus;
use App\Events\EventCanceled;
use App\Mail\Events\EventCanceledMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEventCanceledNotification
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
     * @param  \App\Events\EventCanceled  $event
     * @return void
     */
    public function handle(EventCanceled $eventCanceled)
    {
        $orders = Order::where('event_id', $eventCanceled->event->id)
            ->where('status', OrderStatus::Accepted->value)
            ->get();
        foreach ($orders as $order) {
            $customer = User::find($order->customer_id);
            Mail::to($customer->email)->send(new EventCanceledMail($eventCanceled->event));
        }
    }
}
