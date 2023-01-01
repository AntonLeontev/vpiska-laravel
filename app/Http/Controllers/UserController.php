<?php

namespace App\Http\Controllers;

use App\Actions\FitAvatarAction;
use App\Models\User;
use App\Models\Event;
use App\Enums\OrderStatus;
use App\Http\Requests\AvatarRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Storage;
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
        $userEvents = Event::where('creator_id', Auth::user()->id)
            ->where('status', Event::ACTIVE)
            ->where('ends_at', '>', now())
            ->with('orders')
            ->get();

        $incomingOrders = [];
        foreach ($userEvents as $event) {
            $event->orders->each(function ($order) use (&$incomingOrders) {
                if (
                    $order->status === OrderStatus::Undefined->value
                    && $order->isPaid()
                ) {
                    $incomingOrders[] = $order;
                }
            });
        }

        $outgoingOrders = Auth::user()->orders
        ->filter(function ($order) {
            return $order->event->ends_at > now() && $order->isPaid() && $order->show;
        })
        ->sort(function ($a, $b) {
            $b->event->starts_at <=> $a->event->starts_at;
        });

        return view('users.events', compact('userEvents', 'incomingOrders', 'outgoingOrders'));
    }

    public function show(User $user)
    {
        $feedbacks = Feedback::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->with('author')
            ->get();

        return view('users.show', compact('user', 'feedbacks'));
    }

    public function update(EditUserRequest $request, User $user)
    {
        $user->updateOrFail($request->except('_token'));
        return Response::json(['status' => 'ok', 'redirect' => url()->previous('/')]);
    }

    public function resetNotifications(User $user)
    {
        $user->updateOrFail(['notifications' => 0]);
        return Response::json(['status' => 'ok']);
    }

    public function newAvatar(AvatarRequest $request, FitAvatarAction $action)
    {
        $path = $action->handle($request->avatar);

        $oldFile = auth()->user()->photo_path;
        auth()->user()->updateOrFail(['photo_path' => $path]);
        Storage::delete($oldFile);
        return Response::json(['status' => 'ok', 'path' => "/storage/$path"]);
    }
}
