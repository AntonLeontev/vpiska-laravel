<?php

namespace App\Http\Controllers;

use App\Models\UserImage;
use Illuminate\Http\Request;
use App\Http\Requests\AvatarRequest;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Actions\FitGalleryImageAction;
use App\Http\Requests\UserImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\UserImageDeleteRequest;

class UserImageController extends Controller
{
    public function store(
        UserImage $userImage,
        UserImageRequest $request,
        FitGalleryImageAction $action
    )
    {
        //TODO Refactor. logic to separate class. Exceptions 
        $images = [];

        foreach ($request->images as $image) {
            $imagePath = $action->handle($image, 'user_photos');

            $image = $userImage->create([
                'user_id' => $request->input('user_id'),
                'path' => $imagePath,
            ]);
            $thumbnail = $image->makeThumbnail('192x192');
            $deletePath = route('userImage.destroy', $image->id);
            $token = csrf_token();
            $userId = $request->input('user_id');
            $images[] = compact('deletePath', 'thumbnail', 'token', 'userId');
        }

        return Response::json(['status' => 'ok', 'images' => $images]);
    }

    public function destroy(UserImage $userImage, UserImageDeleteRequest $request)
    {
        $dir  = str()->beforeLast($userImage->path, '/');
        $file = str()->afterLast($userImage->path, '/');

        foreach (config('thumbnails.allowed_sizes') as $size) {
            Storage::delete("$dir/$size/$file");
        }

        Storage::delete($userImage->path);
        $userImage->deleteOrFail();
        return Response::json(['status' => 'ok']);
    }
}
