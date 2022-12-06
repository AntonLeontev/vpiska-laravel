<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\User;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Cypix\CypixService;
use App\Services\Cypix\PaymentException;
use Illuminate\Support\Facades\Response;

class CypixController extends Controller
{
    // public function pay(CypixService $cypixService)
    // {
    //     $paymentData = $cypixService->transactionWithForm();

    //     Order::find(session()->get('order_id'))->updateOrFail(['payment_id' => $paymentData['transaction']['id']]);

    //     return Response::json(['status' => 'ok', 'redirect' => $paymentData['form']['url']]);
    // }


    public function handlePayment(Request $request)
    {
        //TODO action class
        if ($request->transaction['status'] !== 'PROCESSED') {
            return;
        }

        $order = Order::find((int) $request->transaction['orderId']);

        if (empty($order)) {
            logger()->channel('payment')->alert('Несуществующий номер заказа', [$request]);
            throw new PaymentException('Несуществующий номер заказа');
        }

        if ($order->payment_id !== $request->transaction['id']) {
            logger()->channel('payment')->alert('Не совпадает ID транзакции', [$request]);
            throw new PaymentException('Не совпадает ID транзакции');
        }

        $order->updateOrFail(['payment_id' => $request->transaction['id']]);

        event(new OrderCreated($order));
    }
}
