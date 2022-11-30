<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use App\Mail\Orders\ThanksForOrder;
use App\Mail\Orders\YouHaveNewOrder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewOrderNotification
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $orderCreated)
    {
        $customer = $this->user->find($orderCreated->order->customer_id);
        $creator  = $this->user->find($orderCreated->order->event->creator_id);

        Mail::to($customer->email)->send(new ThanksForOrder($customer));
        Mail::to($creator->email)->send(new YouHaveNewOrder($creator));
    }
}
