<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Events\EventArchived;
use App\Events\EventCanceled;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Models\EventImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Event $event, Request $request)
    {
        $query = $event->where('status', $event::ACTIVE)
            ->where('ends_at', '>', now());

        if ($request->session()->has('city_fias_id')) {
            $query = $query->where('city_fias_id', session('city_fias_id'));
        }

        $events = $query->with('orders')->get();
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
            'scales',
            'images'
        ]))->id;

        if (!empty($request->images)) {
            foreach ($request->images as $path) {
                if (!Storage::exists($path)) {
                    continue;
                }

                EventImage::create(['path' => $path, 'event_id' => $eventId]);
                DB::table('temporary_images')->where('path', $path)->delete();
            }
        }

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

    public function cancel(Event $event)
    {
        event(new EventCanceled($event));
        $event = $event->updateOrFail(['status' => $event::CANCELED]);
        return Response::json(['status' => 'ok', 'redirect' => url()->previous()]);
    }

    public function archiveOld(Event $event)
    {
        $oldEvents = $event
            ->where('ends_at', '<', now(3))
            ->where('status', Event::ACTIVE)
            ->get();

        foreach ($oldEvents as $event) {
            $event->updateOrFail(['status' => Event::ARCHIVED]);
            event(new EventArchived($event));
        }
    }
}
