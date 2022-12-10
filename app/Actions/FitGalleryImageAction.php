<?php

namespace App\Actions;

use Intervention\Image\Facades\Image;
use Intervention\Image\Image as ImageImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FitGalleryImageAction
{
	public function handle(string|UploadedFile|ImageImage $file, string $dir): string
	{
		$name = str()->random(10) . time();
		$resultPath = "images/$dir/$name.webp";

		Image::make($file)
			->widen(800, function ($constraint) {
				$constraint->upsize();
			})
			->save(storage_path("app/public/$resultPath"), 90, 'webp');

		return $resultPath;
	}
}
