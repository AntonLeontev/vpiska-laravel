<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Events\OrderCompleted;
use App\Exceptions\OrderDeletingException;
use App\Http\Requests\ActivateCodeRequest;
use App\Models\Event;
use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\OrderDeclined;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderDecisionRequest;
use App\Http\Requests\OrderDeleteRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function store(Order $order, OrderCreateRequest $request): JsonResponse
    {
        $order = $order->create($request->except(['_token', 'scales', 'pay_from_account']));
        event(new OrderCreated($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
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
        $order->updateOrFail(['status' => OrderStatus::Accepted->value]);
        event(new OrderAccepted($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }

    public function decline(Order $order, OrderDecisionRequest $request): JsonResponse
    {
        $order->updateOrFail(['status' => OrderStatus::Declined->value]);
        event(new OrderDeclined($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }

    public function activateCode(ActivateCodeRequest $request): JsonResponse
    {
        $userEvents = Event::where('creator_id', Auth::user()->id)
            ->where('ends_at', '>', now())
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

        return Response::json(['status' => 'message', 'message' => 'Код не найден']);
    }
}
