<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
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
        $userEvents = Auth::user()->events->filter(function ($event) {
            if ($event['ends_at'] > Carbon::create('now')) {
                return true;
            }
            return false;
        });

        $incomingOrders = [];
        foreach ($userEvents as $event) {
            $event->orders->each(function ($order) use (&$incomingOrders) {
                if ($order->status === OrderStatus::Undefined->value) {
                    $incomingOrders[] = $order;
                }
            });
        }

        $outgoingOrders = Auth::user()->orders->filter(function ($order) {
            return true;
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
