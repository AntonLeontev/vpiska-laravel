<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemporaryImageRequest;
use Illuminate\Http\Request;
use App\Models\TemporaryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class TemporaryImageController extends Controller
{
    public function store(TemporaryImageRequest $request, TemporaryImage $temporaryImage)
    {
        //TODO Refactor. logic to separate class. Exceptions 
        $images = [];

        foreach ($request->images as $image) {
            $path = $image->store('images/event_photos');
            $id = $temporaryImage->create(['user_id' => $request->input('user_id'), 'path' => "$path"])->id;
            $deletePath = route('temporaryImage.destroy', $id);
            $token = csrf_token();
            $userId = $request->input('user_id');
            $images[] = compact('deletePath', 'path', 'token', 'userId');
        }

        return Response::json(['status' => 'ok', 'images' => $images]);
    }

    public function destroy(TemporaryImage $temporaryImage)
    {
        $path = $temporaryImage->path;
        Storage::delete($temporaryImage->path);
        $temporaryImage->deleteOrFail();
        return Response::json(['status' => 'ok', 'path' => $path]);
    }
}
