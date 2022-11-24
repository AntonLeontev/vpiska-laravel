<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Events\OrderAccepted;
use App\Events\OrderCanceled;
use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\OrderDeclined;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderDecisionRequest;
use App\Http\Requests\OrderDeleteRequest;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function store(Order $order, OrderCreateRequest $request)
    {
        $order = $order->create($request->except(['_token', 'scales', 'pay_from_account']));
        event(new OrderCreated($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }

    public function destroy(Order $order, OrderDeleteRequest $request)
    {
        event(new OrderCanceled($order));
        $order->deleteOrFail();
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }

    public function accept(Order $order, OrderDecisionRequest $request)
    {
        $order->updateOrFail(['status' => OrderStatus::Accepted->value]);
        event(new OrderAccepted($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }

    public function decline(Order $order, OrderDecisionRequest $request)
    {
        $order->updateOrFail(['status' => OrderStatus::Declined->value]);
        event(new OrderDeclined($order));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }
}
