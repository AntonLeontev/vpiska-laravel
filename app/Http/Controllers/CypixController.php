<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\Cypix\CypixService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CypixController extends Controller
{
    // public function pay(CypixService $cypixService)
    // {
    //     $paymentData = $cypixService->transactionWithForm();

    //     Order::find(session()->get('order_id'))->updateOrFail(['payment_id' => $paymentData['transaction']['id']]);

    //     return Response::json(['status' => 'ok', 'redirect' => $paymentData['form']['url']]);
    // }

    public function notificationGet(Request $request)
    {
        Log::channel('payment')->notice('get', [$request]);
    }

    public function notificationPost(Request $request)
    {
        Log::channel('payment')->notice('post', [$request]);
    }
}
