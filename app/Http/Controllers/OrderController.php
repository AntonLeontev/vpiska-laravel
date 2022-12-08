<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Events\OrderCreated;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderDeclined;
use App\Events\OrderCompleted;
use Illuminate\Http\JsonResponse;
use App\Services\Cypix\CypixService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OrderHideRequest;
use Illuminate\Support\Facades\Response;
use App\Exceptions\Orders\OrderException;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderDeleteRequest;
use App\Http\Requests\ActivateCodeRequest;
use App\Http\Requests\OrderDecisionRequest;
use App\Exceptions\Orders\OrderDeletingException;


class OrderController extends Controller
{
    public function store(Order $order, OrderCreateRequest $request, CypixService $cypixService)
    {
        $order = $order->create($request->except(['_token', 'scales', 'pay_from_account', 'amount']));

        if ($request->boolean('pay_from_account')) {
            event(new OrderCreated($order));

            return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
        }

        $paymentData = $cypixService->transactionWithForm($order, $request);

        $order->updateOrFail(['payment_id' => $paymentData['transaction']['id']]);

        return Response::json(['status' => 'ok', 'redirect' => $paymentData['form']['url']]);
    }

    public function destroy(Order $order, OrderDeleteRequest $request): JsonResponse
    {
        if ($order->status === OrderStatus::Declined->value) {
            throw new OrderDeletingException('Нельзя отменить заказ, отклоненный организатором');
        }

        event(new OrderCanceled($order));
        $order->deleteOrFail();
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }

    public function accept(Order $order, OrderDecisionRequest $request): JsonResponse
    {
        $order->updateOrFail(['status' => OrderStatus::Accepted->value, 'show' => 1]);
        event(new OrderAccepted($order));
        return Response::json(['status' => 'ok']);
    }

    public function decline(Order $order, OrderDecisionRequest $request): JsonResponse
    {
        $order->updateOrFail(['status' => OrderStatus::Declined->value, 'show' => 1]);
        event(new OrderDeclined($order));
        return Response::json(['status' => 'ok']);
    }

    public function activateCode(ActivateCodeRequest $request): JsonResponse
    {
        $userEvents = Event::where('creator_id', Auth::user()->id)
            ->where('ends_at', '>', now())
            ->where('status', Event::ACTIVE)
            ->with('orders')
            ->get();

        $incomingOrders = [];
        foreach ($userEvents as $event) {
            $event->orders->each(function ($order) use (&$incomingOrders) {
                if ($order->status === OrderStatus::Accepted->value) {
                    $incomingOrders[] = $order;
                }
            });
        }

        foreach ($incomingOrders as $order) {
            if ($order->code !== $request->code) {
                continue;
            }

            $order->updateOrFail(['status' => OrderStatus::Completed->value]);
            event(new OrderCompleted($order));
            return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
        }

        throw new OrderException(
            sprintf(
                'Нет заказа с таким кодом. Пользователь %s. Код %s',
                auth()->user->id,
                $request->code
            )
        );
    }

    public function hide(Order $order, OrderHideRequest $request)
    {
        $order->updateOrFail(['show' => false]);
        return Response::json(['status' => 'ok']);
    }
}
