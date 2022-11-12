<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChangeCityRequest;
use Illuminate\Support\Facades\Response;

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

    public function changeCity(ChangeCityRequest $request, User $user)
    {
        if (is_null($user->city_fias_id)) {
            $user->updateOrFail($request->except('_token'));
        }
        $request->session()->put('city_fias_id', $request->input('city_fias_id'));
        $request->session()->put('city_name', $request->input('city_name'));

        return Response::json(['status' => 'ok', 'redirect' => $request->input('srcUri')]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
