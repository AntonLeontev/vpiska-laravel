<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use App\Events\EventCanceled;
use App\Events\OrderCanceled;
use App\Models\BalanceTransfer;

class TransferMoney
{
	public function handleOrderCreated(OrderCreated $event)
	{
		if ($event->order->payment_id === 'balance') {
			$customer = User::find($event->order->customer_id);
			$price    = $event->order->event->price;
			$fee      = $event->order->event->fee;

			$customer->update(['balance' => $customer->balance - $price - $fee]);

			BalanceTransfer::create([
				'user_id'     => $customer->id,
				'type'        => 'payment',
				'sum'         => $price,
				'description' => "Оплата заказа",
				'order_id'    => $event->order->id,
			]);

			BalanceTransfer::create([
				'user_id'     => $customer->id,
				'type'        => 'payment',
				'sum'         => $fee,
				'description' => "Оплата комиссии",
				'order_id'    => $event->order->id,
			]);
		}
	}

	public function handleOrderCanceled(OrderCanceled $event)
	{
		//TODO write method
	}

	public function handleEventCanceled(EventCanceled $event)
	{
		//TODO write method
	}

	public function subscribe($events)
	{
		return [
			EventCanceled::class => 'handleEventCanceled',
			OrderCreated::class => 'handleOrderCreated',
			OrderCanceled::class => 'handleOrderCanceled',
		];
	}
}
