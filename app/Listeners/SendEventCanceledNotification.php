<?php

namespace App\Listeners;

use App\Events\EventCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
    public function handle(EventCanceled $event)
    {
        //
    }
}
