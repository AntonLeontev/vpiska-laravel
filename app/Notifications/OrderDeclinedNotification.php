<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OrderDeclinedNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ваш заказ отклонен')
            ->view('mails.orders.deniedToCustomer', ['order' => $this->order]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Ваш заказ отклонен организатором',
            'notifications' => $notifiable->notifications,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
