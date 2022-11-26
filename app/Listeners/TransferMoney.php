<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\User;
use App\Events\OrderCreated;
use App\Events\EventCanceled;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderDeclined;
use App\Models\Transactions;

class TransferMoney
{
	public function subscribe($events)
	{
		return [
			EventCanceled::class => 'handleEventCanceled',
			OrderCreated::class  => 'handleOrderCreated',
			OrderCanceled::class => 'handleOrderCanceled',
			OrderDeclined::class => 'handleOrderDeclined',
		];
	}

	public function handleOrderCreated(OrderCreated $orderCreated)
	{
		if ($orderCreated->order->payment_id !== 'balance') {
			return;
		}

		$this->doTransaction($orderCreated->order, true, true);

        $this->createPaymentPriceTransaction($orderCreated->order);
        $this->createPaymentFeeTransaction($orderCreated->order);
	}

	public function handleOrderCanceled(OrderCanceled $canceledOrderEvent)
	{
        $this->doTransaction($canceledOrderEvent->order, false, false);

        $this->createRefundPriceTransaction($canceledOrderEvent->order);
	}

	public function handleEventCanceled(EventCanceled $eventCanceled)
	{
		$orders = $eventCanceled->event->orders;
        foreach ($orders as $order) {
            $this->doTransaction($order, false, true);

            $this->createRefundPriceTransaction($order);
            $this->createRefundFeeTransaction($order);
        }
	}

    public function handleOrderDeclined(OrderDeclined $orderDeclinedEvent)
	{
		$this->doTransaction($orderDeclinedEvent->order, false, true);

        $this->createRefundPriceTransaction($orderDeclinedEvent->order);
        $this->createRefundFeeTransaction($orderDeclinedEvent->order);
	}

    private function doTransaction(Order $order, bool $payment, bool $withFee): void
    {
        $customer = User::find($order->customer_id);
        $price    = $order->event->price;
        $fee      = 0;

        if ($withFee) {
            $fee = $order->event->fee;
        }

        if ($payment) {
            $this->pay($customer, $price, $fee);
            return;
        }

        $this->refund($customer, $price, $fee);
    }

    private function pay(User $customer, int $price, int $fee): void
    {
        $customer->updateOrFail(['balance' => $customer->balance - $price - $fee]);
    }

    private function refund(User $customer, int $price, int $fee): void
    {
        $customer->updateOrFail(['balance' => $customer->balance + $price + $fee]);
    }

    private function createRefundPriceTransaction(Order $order): void
    {
        Transactions::create([
            'user_id'     => $order->customer_id,
            'type'        => 'refund',
            'sum'         => $order->event->price,
            'description' => "Возврат оплаты заказа",
            'order_id'    => $order->id,
        ]);
    }

    private function createRefundFeeTransaction(Order $order): void
    {
        Transactions::create([
            'user_id'     => $order->customer_id,
            'type'        => 'refund',
            'sum'         => $order->event->fee,
            'description' => "Возврат комиссии",
            'order_id'    => $order->id,
        ]);
    }

    private function createPaymentPriceTransaction(Order $order): void
    {
        Transactions::create([
            'user_id'     => $order->customer_id,
            'type'        => 'payment',
            'sum'         => $order->event->price,
            'description' => "Оплата заказа",
            'order_id'    => $order->id,
        ]);
    }

    private function createPaymentFeeTransaction(Order $order): void
    {
        Transactions::create([
            'user_id'     => $order->customer_id,
            'type'        => 'payment',
            'sum'         => $order->event->fee,
            'description' => "Оплата комиссии",
            'order_id'    => $order->id,
        ]);
    }
}
