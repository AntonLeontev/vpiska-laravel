<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventImageRequest;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class EventImageController extends Controller
{
	public function store(EventImageRequest $request, Event $event, EventImage $eventImage)
	{
		//TODO Refactor. logic to separate class. Exceptions 
		$images = [];

		foreach ($request->images as $image) {
			$path = $image->store('images/event_photos');
			$imageId = $eventImage->create(['event_id' => $event->id, 'path' => "$path"])->id;
			$deletePath = route('eventImage.destroy', $imageId);
			$token = csrf_token();
			$userId = auth()->user()->id;
			$images[] = compact('deletePath', 'path', 'token', 'userId');
		}

		return Response::json(['status' => 'ok', 'images' => $images]);
	}

	public function destroy(EventImage $eventImage)
	{
		if (!Storage::delete($eventImage->path)) {
			return Response::json(['status' => 'error'], 500);
		}

		$eventImage->deleteOrFail();

		return Response::json(['status' => 'ok']);
	}
}
