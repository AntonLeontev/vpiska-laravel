<?php

namespace App\Listeners;

use Illuminate\Support\Arr;
use App\Events\UserCreating;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserDefaultPhoto
{
    public function handle(UserCreating $event)
    {
        $user = $event->user;

        if (!empty($user->photo_path)) {
            return;
        }

        if ($user->sex === 'не указан') {
            // TODO Images for undefined sex
            return;
        }

        if ($user->sex === 'женский') {
            $all = Storage::disk('images')->allFiles('plugs/avatars/female');
        }

        if ($user->sex === 'мужской') {
            $all = Storage::disk('images')->allFiles('plugs/avatars/male');
        }
        $rand = Arr::random($all);

        $name = str()->random(10) . time();

        Image::make(resource_path('images/' . $rand))
            ->fit(192, 192, function ($constraint) {
                $constraint->upsize();
            })
            ->save(storage_path("app/public/images/user_photos/$name.webp"), 90, 'webp');

        $user->photo_path = "images/user_photos/$name.webp";
    }
}
