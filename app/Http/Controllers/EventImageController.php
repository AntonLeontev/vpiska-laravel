<?php

namespace App\Http\Controllers;

use App\Actions\FitGalleryImageAction;
use App\Models\Event;
use App\Models\EventImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventImageRequest;
use Illuminate\Support\Facades\Response;

class EventImageController extends Controller
{
	public function store(
		EventImageRequest $request,
		Event $event,
		EventImage $eventImage,
		FitGalleryImageAction $action
	) {
		//TODO Refactor. logic to separate class. Exceptions 
		$images = [];

		foreach ($request->images as $image) {
			$imagePath = $action->handle($image, 'event_photos');

			$image = $eventImage->create(['event_id' => $event->id, 'path' => $imagePath]);
			$thumbnail = $image->makeThumbnail('192x192');
			$deletePath = route('eventImage.destroy', $image->id);
			$token = csrf_token();
			$userId = auth()->user()->id;
			$images[] = compact('deletePath', 'thumbnail', 'token', 'userId');
		}

		return Response::json(['status' => 'ok', 'images' => $images]);
	}

	public function destroy(EventImage $eventImage)
	{
		$dir  = str()->beforeLast($eventImage->path, '/');
		$file = str()->afterLast($eventImage->path, '/');

		foreach (config('thumbnails.allowed_sizes') as $size) {
			Storage::delete("$dir/$size/$file");
		}

		if (!Storage::delete($eventImage->path)) {
			return Response::json(['status' => 'error'], 500);
		}

		$eventImage->deleteOrFail();

		return Response::json(['status' => 'ok']);
	}
}
