<?php

namespace App\Mail\Orders;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class YouCanceledOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Вы отменили заказ',
        );
    }

    public function content()
    {
        return new Content(
            view: 'mails.orders.canceledToCustomer',
        );
    }

    public function attachments()
    {
        return [];
    }
}
