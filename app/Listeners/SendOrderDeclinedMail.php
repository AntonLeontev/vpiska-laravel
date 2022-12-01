<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderDeclined;
use App\Mail\Orders\OrderDeclined as MailOrderDeclined;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderDeclinedMail
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
    public function handle(OrderDeclined $orderDeclined)
    {
        $order = $orderDeclined->order;
        $customer = User::find($order->customer_id);

        Mail::to($customer->email)->send(new MailOrderDeclined($order));
    }
}
