<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Events\OrderCreated;
use App\Http\Requests\OrderCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function store(Order $order, OrderCreateRequest $request)
    {
        $order = $order->create($request->except(['_token', 'scales', 'pay_from_account']));
        OrderCreated::dispatch($order);
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }

    public function destroy(Order $order)
    {
    }
}
