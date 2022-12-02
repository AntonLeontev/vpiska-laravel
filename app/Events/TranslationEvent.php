<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TranslationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $message;

    public function __construct(int $id, string $message)
    {
        $this->id = $id;
        $this->message = $message;
    }

    public function broadcastAs()
    {
        return 'TranslationEvent';
    }

    public function broadcastOn()
    {
        return new Channel('translation.' . $this->id);
    }
}
