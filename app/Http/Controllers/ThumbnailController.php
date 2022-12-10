<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __invoke(
        string $dir,
        string $size,
        string $file
    ): BinaryFileResponse {
        abort_if(
            !in_array($size, config('thumbnails.allowed_sizes', [])),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk('public_images');

        $realPath = "$dir/$file";
        $newDirPath = "$dir/$size";
        $resultPath = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if (!$storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));

            [$width, $height] = explode('x', $size);

            $image->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            });
            $image->save($storage->path($resultPath));
        }

        return Response::file($storage->path($resultPath));
    }
}
