<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderAccepted;
use App\Mail\Orders\OrderAccepted as MailOrderAccepted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderAcceptedMail
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
     * @param  object  $event
     * @return void
     */
    public function handle(OrderAccepted $orderAccepted)
    {
        $order = $orderAccepted->order;
        $customer = User::find($order->customer_id);

        Mail::to($customer->email)->send(new MailOrderAccepted($order));
    }
}
