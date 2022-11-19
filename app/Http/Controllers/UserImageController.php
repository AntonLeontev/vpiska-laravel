<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserImageDeleteRequest;
use App\Models\UserImage;
use Illuminate\Http\Request;
use App\Http\Requests\UserImageRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UserImageController extends Controller
{
    public function store(UserImage $userImage, UserImageRequest $request)
    {
        //TODO Refactor. logic to separate class. Exceptions 
        $images = [];

        foreach ($request->images as $image) {
            $path = $image->store('images/user_photos');
            $id = $userImage->create(['user_id' => $request->input('user_id'), 'path' => "$path"])->id;
            $deletePath = route('userImage.destroy', $id);
            $token = csrf_token();
            $images[] = compact('deletePath', 'path', 'token');
        }

        return Response::json(['status' => 'ok', 'images' => $images]);
    }

    public function destroy(UserImage $userImage, UserImageDeleteRequest $request)
    {
        Storage::delete($userImage->path);
        $userImage->deleteOrFail();
        return Response::json(['status' => 'ok']);
    }
}
