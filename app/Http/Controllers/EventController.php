<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Mail\EmailConfirmationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class EventController extends Controller
{
    public function index(Event $event, Request $request)
    {   
        $events = $event->all();

        //TODO Filtration
        if ($request->session()->has('city_fias_id')) {
            $events = $events->filter(function ($event) {
                return $event->city_fias_id === session('city_fias_id');
            });
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(EventRequest $request)
    {
        $eventId = Event::create($request->except([
            '_token',
            'user_phone',
            'time',
            'date',
            'scales'
        ]))->id;

        return Response::json(['status' => 'ok', 'redirect' => route('events.show', $eventId)]);
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->updateOrFail($request->except([
            '_token',
            'user_phone',
            'time',
            'date',
            'scales'
        ]));

        return Response::json(['status' => 'ok', 'redirect' => route('events.show', $event->id)]);
    }

    public function destroy(Event $event)
    {
        $event->deleteOrFail();
        return Response::json(['status' => 'ok', 'redirect' => route('home')]);
    }
}
