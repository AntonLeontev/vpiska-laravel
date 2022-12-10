<?php

namespace App\Actions;

use Intervention\Image\Facades\Image;
use Intervention\Image\Image as ImageImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FitAvatarAction
{
	public function handle(string|UploadedFile|ImageImage $file): string
	{
		$name = str()->random(10) . time();

		Image::make($file)
			->fit(192, 192, function ($constraint) {
				$constraint->upsize();
			})
			->save(storage_path("app/public/images/user_photos/$name.webp"), 90, 'webp');

		return "images/user_photos/$name.webp";
	}
}
