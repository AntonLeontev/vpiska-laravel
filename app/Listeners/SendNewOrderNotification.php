<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use App\Mail\Orders\ThanksForOrder;
use App\Mail\Orders\YouHaveNewOrder;
use App\Notifications\NewOrderNotification;
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
        $creator  = $this->user->find($orderCreated->order->event->creator_id);

        $creator->increment('notifications');
        $creator->notify(new NewOrderNotification());
    }
}
