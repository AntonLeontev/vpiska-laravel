<?php

namespace App\Http\Requests;

use App\Models\UserImage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserImageRequest extends FormRequest
{
    public function authorize()
    {
        return (int) $this->user_id === Auth::user()->id;
    }

    public function rules()
    {
        $maxImages = config('vpiska.max_photo_per_user') - UserImage::where('user_id', $this->user_id)->count();
        return [
            'user_id'  => ['required', 'exists:users,id', 'integer'],
            'images'   => ['required', "max:$maxImages"],
            'images.*' => [
                'required',
                'image',
                'bail',
                'max:' . (config('vpiska.max_image_size')),
                Rule::dimensions()
                    ->minWidth(config('vpiska.min_image_width', 200))
                    ->minHeight(config('vpiska.min_image_height', 200)),
            ],
        ];
    }

    public function messages()
    {
        return [
            'images.max' => 'Еще можно загрузить не более :max фото',
            'images.*.max' => 'Максимальный размер файла 3 Мб',
            'images.*.image' => 'Загружать можно только изображения',
            'images.*.dimensions' => 'Минимальное разрешение изображения 200х200 px',
        ];
    }
}
