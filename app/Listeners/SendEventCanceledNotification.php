<?php

namespace App\Listeners;

use App\Events\EventCanceled;
use App\Mail\Events\EventCanceledMail;
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
        foreach ($eventCanceled->event->orders as $order) {
            $customer = User::find($order->customer_id);
            Mail::to($customer->email)->send(new EventCanceledMail($eventCanceled->event));
        }
    }
}
