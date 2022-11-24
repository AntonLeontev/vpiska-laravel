<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use App\Events\EventCanceled;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderDeclined;
use App\Models\BalanceTransfer;

class TransferMoney
{
	public function subscribe($events)
	{
		return [
			EventCanceled::class => 'handleEventCanceled',
			OrderCreated::class  => 'handleOrderCreated',
			OrderCanceled::class => 'handleOrderCanceled',
			OrderAccepted::class => 'handleOrderAccepted',
			OrderDeclined::class => 'handleOrderDeclined',
		];
	}

	public function handleOrderCreated(OrderCreated $orderCreated)
	{
		if ($orderCreated->order->payment_id !== 'balance') {
			return;
		}

		$customer = User::find($orderCreated->order->customer_id);
		$price    = $orderCreated->order->event->price;
		$fee      = $orderCreated->order->event->fee;

		$customer->updateOrFail(['balance' => $customer->balance - $price - $fee]);

		BalanceTransfer::create([
			'user_id'     => $customer->id,
			'type'        => 'payment',
			'sum'         => $price,
			'description' => "Оплата заказа",
			'order_id'    => $orderCreated->order->id,
		]);

		BalanceTransfer::create([
			'user_id'     => $customer->id,
			'type'        => 'payment',
			'sum'         => $fee,
			'description' => "Оплата комиссии",
			'order_id'    => $orderCreated->order->id,
		]);
	}

	public function handleOrderCanceled(OrderCanceled $canceledOrderEvent)
	{
		$customer = User::find($canceledOrderEvent->order->customer_id);
		$price    = $canceledOrderEvent->order->event->price;

		$customer->update(['balance' => $customer->balance + $price]);

		BalanceTransfer::create([
			'user_id'     => $customer->id,
			'type'        => 'refund',
			'sum'         => $price,
			'description' => "Возврат средств за заказ",
			'order_id'    => $canceledOrderEvent->order->id,
		]);
	}

	public function handleEventCanceled(EventCanceled $event)
	{
		//TODO write method
	}

	public function handleOrderAccepted(OrderAccepted $event)
	{
		//
	}

	public function handleOrderDeclined(OrderDeclined $orderDeclinedEvent)
	{
		$customer = User::find($orderDeclinedEvent->order->customer_id);
		$price    = $orderDeclinedEvent->order->event->price;
		$fee      = $orderDeclinedEvent->order->event->fee;

		$customer->updateOrFail(['balance' => $customer->balance + $price + $fee]);

		BalanceTransfer::create([
			'user_id'     => $customer->id,
			'type'        => 'refund',
			'sum'         => $price,
			'description' => "Возврат оплаты заказа",
			'order_id'    => $orderDeclinedEvent->order->id,
		]);

		BalanceTransfer::create([
			'user_id'     => $customer->id,
			'type'        => 'refund',
			'sum'         => $fee,
			'description' => "Возврат комиссии",
			'order_id'    => $orderDeclinedEvent->order->id,
		]);
	}
}
