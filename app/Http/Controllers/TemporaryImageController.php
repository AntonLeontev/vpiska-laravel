<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryImage;
use Intervention\Image\Facades\Image;
use App\Actions\FitGalleryImageAction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\TemporaryImageRequest;

class TemporaryImageController extends Controller
{
    public function store(
        TemporaryImageRequest $request,
        TemporaryImage $temporaryImage,
        FitGalleryImageAction $action
    )
    {
        //TODO Refactor. logic to separate class. Exceptions 
        $images = [];

        foreach ($request->images as $image) {
            $imagePath = $action->handle($image, 'event_photos');

            $image = $temporaryImage->create(['user_id' => $request->input('user_id'), 'path' => $imagePath]);
            $thumbnail = $image->makeThumbnail('192x192');
            $deletePath = route('temporaryImage.destroy', $image->id);
            $token = csrf_token();
            $userId = $request->input('user_id');
            $images[] = compact('deletePath', 'imagePath', 'token', 'userId', 'thumbnail');
        }

        return Response::json(['status' => 'ok', 'images' => $images]);
    }

    public function destroy(TemporaryImage $temporaryImage)
    {
        $dir  = str()->beforeLast($temporaryImage->path, '/');
        $file = str()->afterLast($temporaryImage->path, '/');

        foreach (config('thumbnails.allowed_sizes') as $size) {
            Storage::delete("$dir/$size/$file");
        }

        $path = $temporaryImage->path;
        Storage::delete($temporaryImage->path);
        $temporaryImage->deleteOrFail();
        return Response::json(['status' => 'ok', 'path' => $path]);
    }
}
