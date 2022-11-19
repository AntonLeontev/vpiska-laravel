<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserImageRequest extends FormRequest
{
    public function authorize()
    {
        return (int) $this->user_id === Auth::user()->id;
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id', 'integer'],
            'images' => ['required'],
            'images.*' => ['required', 'image', 'bail', 'max:3072', 'dimensions:min_width=200,min_height=200'],
        ];
    }

    public function messages()
    {
        return [
            'images.*.max' => 'Максимальный размер файла 3 Мб',
            'images.*.image' => 'Загружать можно только изображения',
            'images.*.dimensions' => 'Минимальное разрешение изображения 200х200 px',
        ];
    }
}
