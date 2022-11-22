<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function balance()
    {
        return view('users.balance');
    }

    public function userEvents()
    {
        $userEvents = Event::where('creator_id', Auth::user()->id)
            ->where('ends_at', '>', Carbon::create('now'))
            ->with('orders')
            ->get();

        $incomingOrders = [];
        foreach ($userEvents as $event) {
            $event->orders->each(function ($order) use (&$incomingOrders) {
                if ($order->status === OrderStatus::Undefined->value) {
                    $incomingOrders[] = $order;
                }
            });
        }

        $outgoingOrders = Auth::user()->orders
        ->filter(function ($order) {
            return $order->event->starts_at > now()->format('Y-m-d H:i:s');
        })
        ->sort(function ($a, $b) {
            $b->event->starts_at <=> $a->event->starts_at;
        });

        return view('users.events', compact('userEvents', 'incomingOrders', 'outgoingOrders'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function update(EditUserRequest $request, User $user)
    {
        $user->updateOrFail($request->except('_token'));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }
}
