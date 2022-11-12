<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Mail\EmailConfirmationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function store(Request $request)
    {
        //
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
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
